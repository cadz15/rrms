<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SemaphoreService {

    public static function send($number, $message) {
        $response = Http::post('https://api.semaphore.co/api/v4/messages', [
            'apikey' => config('semaphore.api_key'),
            'number' => $number,
            'message' => $message
        ]);

        $responseBody = collect(json_decode($response->body())[0]);
        //check if response success
        if($response->status() == 200 && $responseBody->has('message_id')) {
            return (object) collect([
                'status' => 200,
                'body' => $responseBody
            ]);
        }else {
            return (object) collect([
                'status' => 403,
                'errors' => $responseBody
            ]);
        }
    }


    public static function getMessages($page = 1, $limit = 1000) {

        $response = Http::get('https://api.semaphore.co/api/v4/messages', [
            'apikey' => config('semaphore.api_key'),
        ]);

        $responseBody = collect(json_decode($response->body()));

        //check if response success
        if($response->status() == 200 && collect($responseBody->first())->has('message_id')) {
            return (object) collect([
                'status' => 200,
                'body' => $responseBody
            ]);
        }else {
            return (object) collect([
                'status' => 403,
                'errors' => $responseBody
            ]);
        }
    }



    public static function getAccount() {
        $response = Http::get('https://api.semaphore.co/api/v4/account', [
            'apikey' => config('semaphore.api_key'),
        ]);

        $responseBody = collect(json_decode($response->body()));

        //check if response success
        if($response->status() == 200 && $responseBody->has('credit_balance')) {
            return (object) collect([
                'status' => 200,
                'body' => $responseBody
            ]);
        }else {
            return (object) collect([
                'status' => 403,
                'errors' => $responseBody
            ]);
        }
    }
}