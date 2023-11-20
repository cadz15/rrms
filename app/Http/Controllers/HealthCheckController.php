<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Notifications\SmsNotification;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    public function checkSmsNotification()
    {
        $user = User::whereHas('role',function($query) {
            $query->where("name", RoleEnum::ADMIN);
        })->first();

        $user->notify(new SmsNotification('Health Check: 100%'));

        return "Health Check SMS sent";
    }
}
