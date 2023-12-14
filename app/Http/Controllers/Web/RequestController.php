<?php

namespace App\Http\Controllers\Web;

use App\Enums\RequestStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\RequestStatusHistory;
use Illuminate\Http\Request as HttpRequest;

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
        $total = number_format($request->requestItems->reduce(function($carry, $item) {
            $price = $item->price?? 0;

            return $carry + ($item->quantity * $price);
        }));

        $declinedHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::DECLINED)->first();
        $approvedHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::PENDING_REVIEW)->first();
        $paidHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::PENDING_PAYMENT)->first();
        $pickupedHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::FOR_PICK_UP)->first();
        $completedHistory = RequestStatusHistory::where('request_id', $id)->where('status', RequestStatusEnum::COMPLETED)->first();

        return view('requestor.request-timeline', compact('request', 'total', 'declinedHistory', 'approvedHistory', 'paidHistory', 'pickupedHistory', 'completedHistory'));
    }
}
