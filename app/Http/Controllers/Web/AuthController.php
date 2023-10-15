<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Enums\RoleEnum;
use App\Enums\ResponseTypeEnum;
use Illuminate\Http\Response;
use App\Models\User;

class AuthController extends Controller
{
    
    public function login(Request $request)
{
    $credentials = $request->only(['username', 'password']);
    $authenticated = AuthService::authenticate($request->username, $request->password, [RoleEnum::ADMIN, RoleEnum::REGISTRAR, RoleEnum::STUDENT, ResponseTypeEnum::WEB]);
    
    if ($authenticated) {
        return redirect()->route('home.test');
    }
    
    return back()->withErrors([
        'error' => 'Invalid Credentials'
    ]);
    
}
    
    }
