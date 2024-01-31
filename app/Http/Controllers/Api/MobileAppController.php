<?php

namespace App\Http\Controllers\Api;

use App\Enums\RequestStatusEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Request as ModelsRequest;
use App\Models\RequestableItem;
use App\Models\RequestItem;
use App\Models\RequestStatusHistory;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MobileAppController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if(RateLimiter::tooManyAttempts(request()->ip(), 10)) {
            return response()->json(['message' => 'Too many fail login attempt your ip has restricted for 1 minute.'], Response::HTTP_UNAUTHORIZED);
        }

        $role = Role::where('name', RoleEnum::STUDENT->value)->pluck('id')->first();

        if (! $token = auth()->guard('api')->attempt(['id_number' => $request->username, 'password' => $request->password, 'role_id' => $role])) {
            RateLimiter::hit(request()->ip(), 60);
            return response()->json(['message' => 'Your id number or password is incorrect. Please try again.'], Response::HTTP_UNAUTHORIZED);
        }
        
        RateLimiter::clear(request()->ip());

        return response()->json([
            'message' => 'Login successfully.',
            'token' => $token,
            'user' => auth()->guard('api')->user(),
            'token_expires_in' => now()->addHour()->getPreciseTimestamp(3),
        ]);
        
        // return $this->respondWithToken($token);
    }

    public function profile() {
        $educations = Education::toApiData(auth()->guard('api')->user()->id);

        return response()->json([
            'message' => 'Fetching data successfully.',
            'user' => auth()->guard('api')->user(),
            'educations' => $educations,
        ]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function updateUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' =>'required',
            'last_name' =>'required',
            'email' =>'required|email',
            'contact_number' =>['required', 'regex:/^0\d{10}$/', 'unique:users,contact_number,' . auth()->user()->id],
            'birth_date' =>'required',
            'birth_place' =>'required',
            'address' =>'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::find(auth()->guard('api')->user()->id);

        if(empty($user)) return response()->json(['message' => 'User not found.'], Response::HTTP_NOT_FOUND);

        $data = $request->except(['id', 'id_number', 'password', 'birth_date', 'is_approved', 'approved_by', 'role_id', 'reason', 'created_at', 'updated_at']);

        $data['birth_date'] = Carbon::parse($request->birth_date)->format('Y-m-d');

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully.',
        ]);
    }

    public function updatePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'min:3', 'max:50'],
            'password_confirmation' => ['required', 'min:3', 'max:50'],
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::find(auth()->guard('api')->user()->id);

        if(!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => ['password' => ['Your old password is incorrect.']],
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user->update([
            'password' => bcrypt($request->password_confirmation),
        ]);

        return response()->json([
            'message' => 'User password updated successfully.',
        ]);
    }

    public function requests() {
        $requests = auth()->guard('api')->user()->requests()->toApiData();

        return response()->json([
            'message' => 'Fetching data successfully.',
            'requests' => $requests,
        ]);
    }


    public function cancelRequest(Request $request) {
        $validator = Validator::make($request->all(), [
           'id' =>'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        $requestItem = auth()->guard('api')->user()->requests()->where('id', $request->id)->first();

        if(empty($requestItem)) return response()->json(['message' => 'Request not found.'], Response::HTTP_NOT_FOUND);

        if($requestItem->status!= RequestStatusEnum::PENDING_REVIEW->value) return response()->json(['message' => 'Request is already approved or rejected.'], Response::HTTP_UNAUTHORIZED);
        

        $requestItem->update([
            'status' => RequestStatusEnum::DECLINED
        ]);

        RequestStatusHistory::create([
            'request_id' => $requestItem->id,
            'status' => RequestStatusEnum::DECLINED,
            'date_completed' => now()->format('Y-m-d'),
        ]);

        $requests = auth()->guard('api')->user()->requests()->toApiData();

        return response()->json([
            'message' => 'Request cancelled successfully.',
            'requests' => $requests,
        ]);
    }


    public function requestableItems() {
        return response()->json([
            'message' => 'Fetching data successfully.',
            'requestable_items' => RequestableItem::select('id', 'name')->get(),
        ]);
    }


    public function createRequest(Request $request) {
        $validator = Validator::make($request->all(), [
           'new_request' =>'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        //convert to laravel collection
        $requestItems = collect($request->new_request);

        $newRequest = ModelsRequest::create([
            'user_id' => auth()->guard('api')->user()->id,
            'status' => RequestStatusEnum::PENDING_REVIEW->value,
        ]);


        foreach($requestItems as $requestItem) {
            RequestItem::create([
                'request_id' => $newRequest->id,
                'item_id' => $requestItem['itemId'],
                'item_name' => $requestItem['itemName'],
                'quantity' => $requestItem['quantity'],
            ]);
        }


        return response()->json([
            'message' => 'Request created successfully.',
        ]);
    }

     /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => now()->addHour()->getPreciseTimestamp(3)
        ]);
    }
}
