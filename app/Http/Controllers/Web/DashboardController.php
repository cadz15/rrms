<?php

namespace App\Http\Controllers\Web;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $requests = Request::whereNull('deleted_at')
        ->with(['requestItems', 'user'])
        ->latest()
        ->paginate(10);

        $totalStudent = User::where('role_id', Role::where('name', RoleEnum::STUDENT)->pluck('id')->first())->count();
        $totalRequest = Request::count();
        $pendingRequestor = User::where('is_approved', false)
        ->where(fn ($query) => $query->whereNull('approved_by')->orWhere('approved_by', '0'))
        ->count();

        return view('home', compact('requests', 'totalStudent', 'totalRequest', 'pendingRequestor'));
    }


    public function showAccount() {
        return view('account-password');
    }


    public function changePassword(HttpRequest $request) {
        $request->validate([
            'password' => ['required', 'min:3', 'max:50', 'confirmed'],
        ]);

        
        auth()->user()->update([
            'password' => bcrypt($request->password)
        ]);

        
        return redirect()->back()->with('success', 'Password successfully updated!');
    }
}
