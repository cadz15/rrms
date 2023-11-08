<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\RequestorRegisterRequest;
use App\Models\Student;

class RequestorRegistrationController extends Controller
{
    
    public function index() {
        $selectPage1 = "active-tab tab-primary";
        $selectPage2 = "";
        $selectPage3 = "";

        return view('requestor.registration', compact('selectPage1', 'selectPage2', 'selectPage3'));
    }


    public function store(RequestorRegisterRequest $request) {
        
        $student = Student::create($request->all());


        return view('requestor.congratulation', compact('student'));
    }
}
