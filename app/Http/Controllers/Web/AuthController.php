<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Enums\RoleEnum;
use App\Enums\ResponseTypeEnum;
use Illuminate\Http\Response;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = AuthService::authenticate($request->username, $request->password, [RoleEnum::ADMIN, RoleEnum::REGISTRAR, RoleEnum::STUDENT]);
        if($user == $request->username && $request->password)
        {
            return redirect(route('home.test'));
        }
        else 
        { 
        return response()->json([
            'message' => 'Unable to login, invalid credentials provided.',
        ]);
        return redirect(route('auth.login'));
            }
    }
    
    
    }