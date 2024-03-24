<?php

namespace App\Services;

use App\Enums\RequestStatusEnum;
use App\Models\Request;
use App\Models\RequestStatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class PayMongoService {

    /**
     * Create a checkout session
     * 
     * @param int requestorId
     * @param int requestId
     * @param string cancelUrl Redirect link if payment is cancelled
     * @param string successUrl Redirect link if payment is successful
     * @param array paymentMethods
     * 
     * paymentMethods ['gcash', 'card', 'dob', 'billease', 'grab_pay', 'paymaya']
     */
    public static function checkout(
        $requestorId, 
        $requestId, 
        // $cancelUrl = '', // dynamic reference #
        // $successUrl = '', // dynamic reference #
        $paymentMethods = ['gcash', 'card', 'dob', 'billease', 'grab_pay', 'paymaya']
    ) {
      
        $user = User::where('id', $requestorId)->first();
        
        $studentRequest = Request::where('id', $requestId)
        ->where('user_id', $requestorId)
        ->where('status', RequestStatusEnum::PENDING_REVIEW->value)
        ->with('requestItems')
        ->first();
        
        // throw error if student request or user is not found
        
        // generate reference #
        $referenceNumber = self::generateReferenceNumber($requestorId);
        
        $cancelUrl = route('payment.cancelled', CryptService::encrypt($referenceNumber));
        $successUrl = route('payment.success', CryptService::encrypt($referenceNumber));
        
        // create data for checkout session
        $billing = [
            'name' => $user->full_name,
            'email' => $user->email,
            'phone' => substr($user->contact_number, 1)
        ];
        
        $lineItems = [];
        $totalAmount = 0;
        
        foreach($studentRequest->requestItems as $requestedItem) {
            array_push($lineItems, [
                'currency' => 'PHP',
                'name' => $requestedItem->item_name,
                'amount' => $requestedItem->price * 100,
                'quantity' => $requestedItem->quantity
            ]);

            $totalAmount += $requestedItem->price * $requestedItem->quantity;
        }

        
        $data = collect([
            'data' => [
                'attributes' => [
                    'billing' => $billing,
                    'send_email_receipt' => true,
                    'show_description' => true,
                    'show_line_items' => true,
                    'cancel_url' => $cancelUrl,
                    'success_url' => $successUrl,
                    'description' => 'RRMS Online Payment',
                    'reference_number' => $referenceNumber,
                    'line_items' => $lineItems,
                    'payment_method_types' => $paymentMethods
                ]
            ]
        ])->toJson();

        // create a post request
        $checkout = Http::withBasicAuth(config('paymongo.api_secret'), '')
        ->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])
        ->withBody($data)
        ->post(config('paymongo.checkout_url'));


        // return status and data
        $data = json_decode($checkout->body());

        if($checkout->status() == 200) {
            return [
                'status' => 200,
                'data' => [
                    'checkout_url' => $data->data->attributes->checkout_url,
                    'reference_number' => $data->data->attributes->reference_number,
                    'checkout_session_id' => $data->data->id,
                    'total' => $totalAmount
                ]
            ];
        }else {
            return [
                'status' => $checkout->status(),
                'errors' => $data->errors
            ];
        }
    }


    public static function checkReferenceNumber($referenceNumber) {
        $checkOutSession = Request::where('reference_number', $referenceNumber)->first();

        if(empty($checkOutSession) || empty($checkOutSession->checkout_session_id)) return [
            'status' => 404,
            'errors' => ['errors' => ['Reference number not found!']]
        ];


        $checkout = Http::withBasicAuth(config('paymongo.api_secret'), '')
        ->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])
        ->get(config('paymongo.checkout_url'). '/' . $checkOutSession->checkout_session_id);

        $data = json_decode($checkout->body());

        if($checkout->status() == 200) {
            $dataResult = [
                'payment_method_used' => 'pending',
                'status' => 'pending',
                'paid_at' => null,
                'checkout_id' => $checkOutSession->checkout_session_id
            ];


            if(property_exists( $data->data->attributes, 'paid_at')) {
                $dataResult = [
                    'payment_method_used' => $data->data->attributes->payment_method_used,
                    'status' => $data->data->attributes->payment_intent->attributes->status,
                    'paid_at' => date('Y-m-d H:i:s a', $data->data->attributes->paid_at)
                ];
            }

            return [
                'status' => 200,
                'data' => $dataResult
            ];
        }else {
            return [
                'status' => $checkout->status(),
                'errors' => $data->errors
            ];
        }
    }


    public static function markRequestAsSuccess($referenceNumber) {
        $paymentCheck = self::checkReferenceNumber($referenceNumber);

        $request = Request::whereNull('deleted_at')
        ->where('reference_number', $referenceNumber)
        ->with(['user', 'requestItems'])
        ->first();

        if($paymentCheck['data']['status'] == 'succeeded') {
            if($request->status == RequestStatusEnum::PENDING_PAYMENT->value) {

                $request->update([
                    'status' => RequestStatusEnum::WORKING_ON_REQUEST->value,
                ]);
                
                RequestStatusHistory::firstOrCreate([
                    'request_id' => $request->id,
                    'status' => RequestStatusEnum::PENDING_PAYMENT->value
                ], [
                    'request_id' => $request->id,
                    'status' => RequestStatusEnum::PENDING_PAYMENT->value,
                    'date_completed' => $paymentCheck['data']['paid_at']
                ]);

                // RequestStatusHistory::firstOrCreate([
                //     'request_id' => $request->id,
                //     'status' => RequestStatusEnum::WORKING_ON_REQUEST->value
                // ], [
                //     'request_id' => $request->id,
                //     'status' => RequestStatusEnum::WORKING_ON_REQUEST->value,
                //     'date_completed' => ''
                // ]);
            }

            return true;
        }

        return false;
    }


    public static function markCheckoutExpired($referenceNumber) {
        $paymentCheck = self::checkReferenceNumber($referenceNumber);

        if($paymentCheck['data']['status'] == 'pending') {
            $checkout = Http::withBasicAuth(config('paymongo.api_secret'), '')
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post(config('paymongo.checkout_url'). '/' . $paymentCheck['data']['checkout_id'] . '/expire');

            $data = json_decode($checkout->body());

            if($checkout->status() == 200) {
                return [
                    'status' => 200,
                    'message' => 'Checkout expired!'
                ];
            }else {
                return [
                    'status' => $checkout->status(),
                    'message' => 'Unable to decline request. Payment has already been made.',
                    'errors' => $data->errors
                ];
            }
        }else {
            return [
                'status' => 404,
                'message' => 'Unable to decline request. Payment has already been made.',
                'errors' => null
            ];
        }
        
    }

    private static function generateReferenceNumber($requestorId) {
        $totalRequest = Request::where('user_id', $requestorId)->count();

        // code from
        // https://laracasts.com/discuss/channels/laravel/generate-unique-payment-reference-number  by snapey
        return sprintf('%s%07s%02s',now()->format('ymd'), $requestorId, $totalRequest);
    }
}