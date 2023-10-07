<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RequestResource;
use Illuminate\Http\Request as HttpRequest;
use App\Models\Request;


class RequestorController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'student_number' => [
                'sometimes', 
                'string',    
                'max:50',    
                new UniqueStudentNumberRule ,
            
            'first_name' => 'required|string|max:100',
            'middle_name' => 'sometimes|string|max:100',
            'last_name' => 'required|string|max:10',
            'suffix' => 'sometimes|string|max:100',
            'contact_number' => 'required|string|max:20',
            'birth_date' => 'required|date_format:Y-m-d',
            'birth_place' => 'required|string',
            'address' => 'required|string',
            'degree' => 'required|string|max:100',
            'major' => 'sometimes|string|max:100',
            'year_level' => 'required|numeric|min:1|max:5',
            'date_enrolled' => 'required|date_format:Y-m-d',
            'is_graduated' => 'sometimes|boolean',
            'date_graduated' => 'required|if:is_graduated:true|date_format:Y-m-d'
            ]
    
            
        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $requestor = new Requestor;
        $requestor->student_number = $request->student_number;
        $requestor->first_name = $request->first_name;
        $requestor->middle_name = $request->middle_name;
        $requestor->last_name = $request->last_name;
        $requestor->suffix = $request->suffix;
        $requestor->contact_number = $request->contact_number;
        $requestor->birth_date = $request->birth_date;
        $requestor->birth_place = $request->birth_place;
        $requestor->address = $request->address;
        $requestor->degree = $request->degree;
        $requestor->major = $request->major;
        $requestor->year_level = $request->year_level;
        $requestor->date_enrolled = $request->date_enrolled;
        $requestor->is_graduated = $request->is_graduated;
        $requestor->date_graduated = $request->date_graduated;
        $requestor->save();
        
       
        
        return response()->json(['message' => 'Registration is successful, kindly wait for registrar to validate your information. 
        This will take 2-3 working days"'], 201);
    }
   
    public function index(HttpRequest $httpRequest, $student_id)
    {
        $requests = Request::where('student_id', $student_id)
            ->with(['requestItems', 'transactions'])
            ->paginate($httpRequest->input('per_page', 10));

        return response()->json([
            'data' => RequestResource::collection($requests),
            'links' => [
                'first' => $requests->url(1),
                'last' => $requests->url($requests->lastPage()),
                'prev' => $requests->previousPageUrl(),
                'next' => $requests->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $requests->currentPage(),
                'from' => $requests->firstItem(),
                'last_page' => $requests->lastPage(),
                'path' => $requests->path(),
                'per_page' => $requests->perPage(),
                'to' => $requests->lastItem(),
                'total' => $requests->total(),
            ],
        ], 200);
    }
    }
    

