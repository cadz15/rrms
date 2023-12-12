<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Models\EducationLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\EducationRequest;
use App\Services\CryptService;

class EducationController extends Controller
{
    public function index($id)
    {
        $student = User::approvedStudents()->find($id);

        if (!$student->isStudent()) {
            abort(404);
        }

        $educations = Education::where('user_id', $student->id)->with('major.educationLevel')->paginate(10);
        return view('student.educations.list', compact('educations'));
    }

    public function create($id)
    {
        if (!$student = User::approvedStudents()->find($id)) {
            abort(404);
        }

        $programs = EducationLevel::with('majors')
        ->get()
        ->transform(function($level) {
            $majors = $level->majors->transform(function($major) {
                return [
                    'id' => $major->id,
                    'name' => $major->name
                ];
            });

            return [
                'level_name' => $level->name,
                'major_names' => [...$majors]
            ];
        });

        return view('student.educations.create', compact('student', 'programs'));
    }

    public function store(EducationRequest $request, $id)
    {
        if (!$student = User::approvedStudents()->find($id)) {
            abort(404);
        }

        Education::create([
            'user_id' => $student->id,
            'major_id' => $request->degree,
            'year_start' => $request->date_enrolled,
            'year_level' => $request->year_level,
            'is_graduated' => $request->is_graduated,
            'year_end' => $request->year_end,
            'school_name' => $request->school_name,
            'address' => $request->school_address,
        ]);

        return redirect(route('educations.index', ['id' => $id]));
    }

    public function show($id, $educationId)
    {
        $student = User::approvedStudents()->find($id);
        if (!$student->isStudent()) {
            abort(404);
        }

        if (!$education = Education::where('user_id', $id)->find($educationId)) {
            abort(404);
        }

        $programs = EducationLevel::with('majors')
        ->get()
        ->transform(function($level) {
            $majors = $level->majors->transform(function($major) {
                return [
                    'id' => $major->id,
                    'name' => $major->name
                ];
            });

            return [
                'level_name' => $level->name,
                'major_names' => [...$majors]
            ];
        });

        return view('student.educations.form', compact('education', 'student', 'programs'));
    }

    public function update(EducationRequest $request, $id, $educationId)
    {
        if (!$education = Education::where('user_id', $id)->find($educationId)) {
            abort(404);
        }

        $education->update([
            'major_id' => $request->degree,
            'year_start' => $request->date_enrolled,
            'year_level' => $request->year_level,
            'is_graduated' => $request->is_graduated,
            'year_end' => $request->year_end,
            'school_name' => $request->school_name,
            'address' => $request->school_address,
        ]);

        return redirect(route('educations.index', ['id' => $id]));
    }

    public function delete($id, $educationId)
    {
        if (!$education = Education::where('user_id', $id)->find($educationId)) {
            abort(404);
        }

        $education->delete();
        return back();
    }
}
