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


        $degree = [
            [
                'id' => 1,
                'name' => 'Bachelor of Science in Computer Engineering'
            ],
            [
                'id' => 2,
                'name' => 'Bachelor of Science in Criminology'
            ]
        ];

        $major = [
            [
                'id' => 1,
                'degree_id' => 1,
                'name' => 'N/A'
            ],
            [
                'id' => 2,
                'degree_id' => 1,
                'name' => 'Electronics'
            ],
            [
                'id' => 3,
                'degree_id' => 2,
                'name' => 'Forensic'
            ],
            [
                'id' => 4,
                'degree_id' => 2,
                'name' => 'Criminal Psycology'
            ]
        ];

        return view('requestor.registration', compact('selectPage1', 'selectPage2', 'selectPage3', 'degree', 'major'));
    }


    public function store(RequestorRegisterRequest $request) {
        $data = $request->only([
            "student_number",
            "last_name",
            "first_name",
            "middle_name",
            "suffix",
            "sex",
            "contact_number",
            "birth_date",
            "birth_place",
            "address",
            "degree",
            "major",
            "date_enrolled",
            "year_level",
            "is_graduated",
            "date_graduated"
        ]);
        $student = Student::create($data);


        return view('requestor.congratulation', compact('student'));
    }
}
