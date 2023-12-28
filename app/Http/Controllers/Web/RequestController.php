<?php

namespace App\Http\Controllers\Web;

use App\Enums\RequestStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\RequestStatusHistory;
use Illuminate\Http\Request as HttpRequest;
use App\Services\PayMongoService;
use App\Services\SemaphoreService;
use App\Services\SmsNotificationService;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function index(HttpRequest $request)
    {
        $search = $request->has('search')? $request->search : '';
        $filterStatus = $request->has('filter_status') ? $request->filter_status : '';
    
        $requests = Request::whereNull('deleted_at')
        ->when($request->has('search'), function($query) use($search){
            
            if(!empty($search)) {
                return $query->whereHas('user', function($subQuery) use($search){
                    $subQuery->where('first_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%");
                })
                ->orWhereHas('requestItems', function($subQuery) use($search) {
                    $subQuery->where('item_name', 'LIKE', "%$search%");
                });
            }
        })
        ->when(!empty($filterStatus), function($query) use($filterStatus){

            $query->where('status', $filterStatus);
        })
        ->with(['requestItems', 'user'])
        ->latest()
        ->paginate(10);

        $statuses = [
            [
                'name' => 'Pending for review',
                'value' => 'pending_for_review'
            ],
            [
                'name' => 'Pending payment',
                'value' => 'pending_payment'
            ],
            [
                'name' => 'For Pickup',
                'value' => 'for_pick_up'
            ],
            [
                'name' => 'Working on Request',
                'value' => 'working_on_request'
            ],
            [
                'name' => 'Declined',
                'value' => 'declined'
            ],
            [
                'name' => 'Completed',
                'value' => 'completed'
            ],
        ];
       
        return view('requests.list', compact('requests', 'search', 'filterStatus', 'statuses'));
    }



    public function viewRequest($id) {
        $request = Request::whereNull('deleted_at')
        ->where('id', $id)
        ->with(['user', 'requestItems'])
        ->first();

        if(empty($request)) return abort(404);
        
        // TODO calculate and display total.
        // TODO approve the requested item
        $total = $request->requestItems->reduce(function($carry, $item) {
            $price = $item->price?? 0;

            return $carry + ($item->quantity * $price);
        });

        $declinedHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::DECLINED->value)->first();
        $approvedHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::PENDING_REVIEW->value)->first();
        $paidHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::PENDING_PAYMENT->value)->first();
        $workedOnRequestHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::WORKING_ON_REQUEST->value)->first();
        $pickupedHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::FOR_PICK_UP->value)->first();
        $completedHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::COMPLETED->value)->first();

        if(!empty($request->reference_number) && !empty($approvedHistory)) {

            $paymentCheck = PayMongoService::markRequestAsSuccess($request->reference_number);

        }
        
        return view('requestor.request-timeline', compact('request', 'total', 'declinedHistory', 'approvedHistory', 'paidHistory', 'workedOnRequestHistory', 'pickupedHistory', 'completedHistory'));
    }



    public function forPickup(HttpRequest $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);


        if($validator->fails()) {
            return redirect()->back()->with('error_status', 'Server error! Please refresh and try again.');
        }

        $studentRequest = Request::where('id', $request->id)
        ->with('user')
        ->first();

        if(empty($studentRequest)) return abort(404);

        $studentRequest->update([
            'status' => RequestStatusEnum::FOR_PICK_UP->value,
        ]);

        RequestStatusHistory::firstOrCreate([
            'request_id' => $studentRequest->id,
            'status' => RequestStatusEnum::FOR_PICK_UP->value
        ], [
            'request_id' => $studentRequest->id,
            'status' => RequestStatusEnum::FOR_PICK_UP->value,
            'date_completed' => date('Y-m-d')
        ]);
        
        $to = '63' . substr($studentRequest->user->contact_number, 1);
        // $from = 'RRMS';
        $message = "Greetings " . $studentRequest->user->last_name . ", your requested item(s) is/are ready for pickup.";

        SemaphoreService::send($to, $message);
        // (new SmsNotificationService())->send($to, $from, $message);

        return redirect()->back();
    }


    public function requestComplete(HttpRequest $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);


        if($validator->fails()) {
            return redirect()->back()->with('error_status', 'Server error! Please refresh and try again.');
        }

        $studentRequest = Request::where('id', $request->id)->first();

        if(empty($studentRequest)) return abort(404);

        $studentRequest->update([
            'status' => RequestStatusEnum::COMPLETED->value,
        ]);

        RequestStatusHistory::firstOrCreate([
            'request_id' => $studentRequest->id,
            'status' => RequestStatusEnum::COMPLETED->value
        ], [
            'request_id' => $studentRequest->id,
            'status' => RequestStatusEnum::COMPLETED->value,
            'date_completed' => date('Y-m-d')
        ]);
        

        return redirect()->back();
    }
}
