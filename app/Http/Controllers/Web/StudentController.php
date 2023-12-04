<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use App\Models\Major;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::approvedStudents()->with('educations')->paginate(10);

        return view('student.list', compact('students'));
    }

    public function show(Request $request)
    {
        $student = User::find($request->id);
        $degrees = EducationLevel::get();
        $majors = Major::get();

        return view('student.information-form', compact('student', 'degrees', 'majors'));
    }
}
