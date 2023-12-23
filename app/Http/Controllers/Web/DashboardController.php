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


    public function showAccounts() {

        $users = User::whereNot('role_id', Role::where('name', RoleEnum::STUDENT)->pluck('id')->first())
        ->oldest('last_name')
        ->paginate(10);

        return view('account-index', compact('users'));
    }


    public function showAccount($id) {
        $user = User::where('id', $id)
        ->whereNot('role_id', Role::where('name', RoleEnum::STUDENT)->pluck('id')->first())
        ->first();

        if(empty($user)) return abort(404);

        return view('account-password', compact('user', 'id'));
    }


    public function showCreateForm() {
        return view('create-account');
    }


    public function createUser(HttpRequest $request) {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'suffix' => ['max:10'],
            'user_name' => ['required', "unique:users,id_number"],
            'account_type' => ['required', 'between:1,2'],
            'password' => ['required', 'min:3', 'max:50', 'confirmed'],
        ]);

        $data = [
            'id_number' => $request->user_name,
            'password' => bcrypt($request->password),
            'role_id' => $request->account_type,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'sex' => 'male',
            'contact_number' => '0',
            'birth_date' => date('Y-m-d'),
            'birth_place' => 'N/A',
            'address' => 'N/A',
            'is_approved' => 1
        ];

        User::create($data);

        return redirect()->back()->with('success', 'User successfully created!');
    }


    public function updateInformation($id, HttpRequest $request) {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'suffix' => ['max:10'],
            'user_name' => ['required', "unique:users,id_number,except,$id"],
            'account_type' => ['required', 'between:1,2'],
        ]);


        //check if admin is not empty
        if($request->account_type == 2) {
            $admins = User::whereNot('id', $id)
            ->where('role_id', 1)
            ->count();

            if($admins == 0 ) {
                return redirect()->back()->with('error_admin', 'Admin account cannot be empty!');
            }
        }

        
        $user = User::where('id', $id)
        ->whereNot('role_id', Role::where('name', RoleEnum::STUDENT)->pluck('id')->first())
        ->first();

        if(empty($user)) return abort(404);

        
        $user->update([
            'id_number' => $request->user_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'role_id' => $request->account_type
        ]);

        
        return redirect()->back()->with('success_admin', 'Account information successfully updated!');
    }

    public function changePassword($id, HttpRequest $request) {
        $request->validate([
            'password' => ['required', 'min:3', 'max:50', 'confirmed'],
        ]);


        $user = User::where('id', $id)
        ->whereNot('role_id', Role::where('name', RoleEnum::STUDENT)->pluck('id')->first())
        ->first();

        if(empty($user)) return abort(404);

        
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        
        return redirect()->back()->with('success', 'Password successfully updated!');
    }


    public function deleteAccount($id) {
        $user = User::where('id', $id)
        ->whereNot('role_id', Role::where('name', RoleEnum::STUDENT)->pluck('id')->first())
        ->first();

        if(empty($user)) return abort(404);

        $admins = User::whereNot('id', $id)
        ->where('role_id', 1)
        ->count();

        if($admins == 0 ) {
            return redirect()->back()->with('error', 'Admin account cannot be empty!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User successfully deleted!');
    }
    
}
