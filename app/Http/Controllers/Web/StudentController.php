<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EducationLevel;
use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Major;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::approvedStudents()->with('educations.major')->paginate(10);

        return view('student.list', compact('students'));
    }

    public function show($id)
    {
        $student = User::approvedStudents()->find($id) ?? abort(404);
        $student->educations = Education::where('user_id', $student->id)->with('major')->get();

        $programs = EducationLevel::with('majors')
            ->get()
            ->transform(function ($level) {
                return [
                    'level_name' => $level->name,
                    'major_names' => [...$level->majors],
                ];
            });

        return view('student.information-form', compact('student', 'programs'));
    }

    public function update(Request $request)
    {
        dd($request->all());
    }

    public function create()
    {
        $degrees = EducationLevel::get();
        $majors = Major::get();

        return view('student.create-form', compact('degrees', 'majors'));
    }
}
