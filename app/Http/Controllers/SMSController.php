<?php

namespace App\Http\Controllers;

use App\Services\SemaphoreService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SMSController extends Controller
{
    //
    public function index(Request $request) {
        // 86400 seconds to remember the cache
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


    public function draft() {

        return view('SMS.draft');
    }

    public function send(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone_numbers' => ['required'],
            'message' => ['required']
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        SemaphoreService::send($request->phone_numbers, $request->message);

        return redirect(route('sms.list'));
    }
}
