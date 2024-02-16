<?php

namespace App\Http\Controllers\Web;

use App\Enums\ResponseTypeEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        AuthService::authenticate($request->username, $request->password, [RoleEnum::ADMIN, RoleEnum::REGISTRAR, RoleEnum::STUDENT], ResponseTypeEnum::WEB);

        if (! auth()->check()) {
            return back()->withErrors([
                'username' => 'Invalid credentials provided.',
            ]);
        }

        
        if(auth()->user()->isAdmin() || auth()->user()->isRegistrar()) {
            
            return redirect()->intended(route('dashboard'));
        }else if(auth()->user()->isStudent()) {

            return redirect()->intended(route('student.dashboard'));
        }

        auth()->logout();
        
        return back()->withErrors([
            'username' => 'Invalid credentials provided.',
        ]);
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            auth()->logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect(route('login'));
        }

        return back();
    }
}
