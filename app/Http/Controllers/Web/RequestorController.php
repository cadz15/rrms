<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RequestorController extends Controller
{
    public function index()
    {
        $requestors = User::where('is_approved', false)->whereNull('approved_by')->paginate(10);

        return view('requestor', [
            'requestors' => $requestors,
        ]);
    }

    public function show(User $student)
    {
        if ($student->is_approved == true) {
            abort(404);
        }

    }

    public function approve(Request $request)
    {

    }

    public function showStudentForm($id)
    {
        $student = Student::find($id); 

        if (!$student) {

            abort(404); 
        }
        
        return view('student.information-form', ['student' => $student]);
    }
}
