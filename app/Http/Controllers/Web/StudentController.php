<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::approvedStudents()->with('educations')->paginate(10);

        return view('student.list', compact('students'));
    }
}
