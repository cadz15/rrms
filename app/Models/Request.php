<?php

namespace App\Models;

use App\Enums\RequestStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function prettyStatus()
    {
        return RequestStatusEnum::from($this->status)->prettyStatus();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestHistory() {
        return $this->hasMany(RequestStatusHistory::class);
    }

    public function scopeToApiData(Builder $query) {
        return $query
        ->with('requestItems','requestHistory')
        ->latest()
        ->get()
        ->transform(function($request) {
            $statuses = $request->requestHistory->sortByDesc('created_at')->transform(function($status) use($request){
                $details = "";
                $url = null;

                if($status->status == RequestStatusEnum::PENDING_REVIEW->value) $details = "Request is being reviewed by the registrar. Please wait for the registrar to approve the request.";

                if($status->status == RequestStatusEnum::PENDING_PAYMENT->value) {
                    $details = "Your request is approved. Please pay by clicking the link below.";
                    $url = $request->checkout_url;
                }

                if($request->status == RequestStatusEnum::WORKING_ON_REQUEST->value) $details = "Your request is being processed. Please wait for the registrar to complete your request.";

                if($request->status == RequestStatusEnum::FOR_PICK_UP->value) $details = "Your request is ready for pick up. Please contact the registrar for pick up details.";
                
                if($request->status == RequestStatusEnum::COMPLETED->value) $details = "Your request has been completed. Thank you for your patience.";

                if($request->status == RequestStatusEnum::DECLINED->value) $details = "Your request has been cancelled.";

                return [
                    'id' => $status->id,
                    'status' => $status->toHumanizedStatus,
                    'date' => Carbon::parse($status->date_completed)->format('D F j, Y'),
                    'is_completed' => !empty($status->date_completed),
                    'details' => $details,
                    'checkout_url' => $url,
                    'created_at' => $status->created_at->format('Y-m-d H:i:s')
                ];
            });

            // add statuses that are currrently in progress.
            if($request->status == RequestStatusEnum::PENDING_REVIEW->value && !$statuses->contains('status', ucwords(strtolower(RequestStatusEnum::PENDING_REVIEW->prettyStatus())))) {
                $statuses->push([
                    'id' => 0,
                    'status' => ucwords(strtolower(RequestStatusEnum::PENDING_REVIEW->prettyStatus())),
                    'date' => now()->format('D F j, Y'),
                    'is_completed' => false,
                    'details' => "Request is being reviewed by the registrar. Please wait for the registrar to approve the request.",
                    'checkout_url' => null,
                    'created_at' => now()->format('Y-m-d H:i:s')
                ]);
            }

            if($request->status == RequestStatusEnum::PENDING_PAYMENT->value && !$statuses->contains('status', ucwords(strtolower(RequestStatusEnum::PENDING_PAYMENT->prettyStatus())))) $statuses->push([
                'id' => 0,
                'status' => ucwords(strtolower(RequestStatusEnum::PENDING_PAYMENT->prettyStatus())),
                'date' => now()->format('D F j, Y'),
                'is_completed' => false,
                'details' => "Your request is approved. Please pay by clicking the link below.",
                'checkout_url' => $request->checkout_url,
                'created_at' => now()->format('Y-m-d H:i:s')
            ]);

            if($request->status == RequestStatusEnum::WORKING_ON_REQUEST->value && !$statuses->contains('status', ucwords(strtolower(RequestStatusEnum::WORKING_ON_REQUEST->prettyStatus())))) $statuses->push([
                'id' => 0,
                'status' => ucwords(strtolower(RequestStatusEnum::WORKING_ON_REQUEST->prettyStatus())),
                'date' => now()->format('D F j, Y'),
                'is_completed' => false,
                'details' => "Your request is being processed. Please wait for the registrar to complete your request.",
                'checkout_url' => null,
                'created_at' => now()->format('Y-m-d H:i:s')
            ]);

            if($request->status == RequestStatusEnum::FOR_PICK_UP->value && !$statuses->contains('status', ucwords(strtolower(RequestStatusEnum::FOR_PICK_UP->prettyStatus())))) $statuses->push([
                'id' => 0,
                'status' => ucwords(strtolower(RequestStatusEnum::FOR_PICK_UP->prettyStatus())),
                'date' => now()->format('D F j, Y'),
                'is_completed' => false,
                'details' => "Your request is ready for pick up. Please contact the registrar for pick up details.",
                'checkout_url' => null,
                'created_at' => now()->format('Y-m-d H:i:s')
            ]);

            // if($request->status == RequestStatusEnum::COMPLETED->value && !$statuses->contains('status', ucwords(strtolower(RequestStatusEnum::PENDING_REVIEW->COMPLETED())))) $statuses->push([
            //     'id' => 0,
            //     'status' => ucwords(strtolower(RequestStatusEnum::COMPLETED->prettyStatus())),
            //     'date' => now()->format('D F j, Y'),
            //     'is_completed' => false,
            //     'details' => "Your request has been completed. Thank you for your patience.",
            //     'checkout_url' => null,
            //     'created_at' => now()->format('Y-m-d H:i:s')
            // ]);
            
            // if($request->status == RequestStatusEnum::DECLINED->value && !$statuses->contains('status', ucwords(strtolower(RequestStatusEnum::PENDING_REVIEW->DECLINED())))) $statuses->push([
            //     'id' => 0,
            //     'status' => ucwords(strtolower(RequestStatusEnum::DECLINED->prettyStatus())),
            //     'date' => now()->format('D F j, Y'),
            //     'is_completed' => false,
            //     'details' => "Your request has been declined or cancelled.",
            //     'checkout_url' => null,
            //     'created_at' => now()->format('Y-m-d H:i:s')
            // ]);

            
            $items = $request->requestItems->transform( function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->item_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'amount' => '₱ '. number_format($item->quantity * $item->price, 2),
                    'amount_raw' => $item->quantity * $item->price,
                    'created_at' => $item->created_at->format('Y-m-d H:i:s')
                ];
            });


            $title = "Requesting for ";
            $amount = $items->sum('amount_raw');

            if($items->count() > 2) {
                $itemNames = $items->pluck('name')->take(2)->implode(', ');
                $title.= $itemNames. " and ". ($items->count() - 2). " more";
            }else if($items->count() > 0) {
                $itemNames = $items->pluck('name')->implode(' and ');
                $title.= $itemNames;
            }


            return [
                'id' => $request->id,
                'status' => ucfirst($request->prettyStatus()),
                'title' => $title,
                'amount' => $amount ? '₱ '. number_format($amount, 2) : '',
                'date' => $request->created_at->format('D F j, Y'),
                'checkout_url' => $request->checkout_url,
                'reference_number' => $request->reference_number,
                'items' => $items,
                'statuses' => $statuses->sortByDesc('created_at')->values()
            ];
        });
    }

    /**
     * Define a one-to-many relationship with RequestItem model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requestItems()
    {
        return $this->hasMany(RequestItem::class);
    }

    /**
     * Define a one-to-many relationship with Transaction model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

}
