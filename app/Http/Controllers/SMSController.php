<?php

namespace App\Http\Controllers;

use App\Services\SemaphoreService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class SMSController extends Controller
{
    //
    public function index(Request $request) {
        // 86400
        $response = SemaphoreService::getMessages();
        $balanceResponse = SemaphoreService::getAccount();

        $data = collect([]);
        $balance = collect([
            'credit_balance' => 0
        ]);

        if($response['status'] = 200) {
            $data = Cache::remember('smslist', 86400, function() use($response){

                return $response['body'];
            });

            $balance = Cache::remember('smsbalance', 86400, function() use($balanceResponse) {
                return $balanceResponse['body'];
            });
        }
 
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $messages = new LengthAwarePaginator($data->sortDesc()->values(), $data->count(), 25, $currentPage);

        return view('SMS.index', compact('messages', 'balance'));
    }



    public function clearCache() {
        Cache::pull('smslist');

        
        $balanceResponse = SemaphoreService::getAccount();
        
        if($balanceResponse['status'] == 200) {
            Cache::pull('smsbalance');
            
            $balance = Cache::remember('smsbalance', 86400, function() use($balanceResponse) {
                return $balanceResponse['body'];
            });
        }
        
        return redirect(route('sms.list'));
    }
}
