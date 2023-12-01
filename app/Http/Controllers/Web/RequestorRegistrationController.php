<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\RequestorRegisterRequest;
use App\Models\EducationLevel;
use App\Models\Major;
use App\Models\Student;

class RequestorRegistrationController extends Controller
{

    public function index() {
        $selectPage1 = "active-tab tab-primary";
        $selectPage2 = "";
        $selectPage3 = "";

        $programs = EducationLevel::with('majors')
        ->get()
        ->transform(function($level) {
            return [
                'level_name' => $level->name,
                'major_names' => [...$level->majors->pluck('name')]
            ];
        });

        return view('requestor.registration', compact('selectPage1', 'selectPage2', 'selectPage3', 'programs'));
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
            // "major",
            "date_enrolled",
            "year_level",
            "is_graduated",
            "date_graduated"
        ]);

        // Get Degree
        $educationName = Major::join('education_levels', 'education_levels.id', '=', 'majors.education_level_id')
        ->where('majors.name', $request->degree)
        ->select('education_levels.name as level_name')
        ->pluck('level_name')
        ->first() ?? '';

        $data['major'] = $request->degree;
        $data['degree'] = $educationName;

        $student = Student::create($data);


        return view('requestor.congratulation', compact('student'));
    }
}
