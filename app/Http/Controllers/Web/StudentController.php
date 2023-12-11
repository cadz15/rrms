<?php

namespace App\Http\Controllers\Web;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EducationLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCreateRequest;
use App\Models\Education;
use App\Models\Major;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::approvedStudents()->with('educations.major')->paginate(10);

        return view('student.list', compact('students'));
    }


    public function viewCreate() {
        $programs = EducationLevel::with('majors')
        ->get()
        ->transform(function($level) {
            return [
                'level_name' => $level->name,
                'major_names' => [...$level->majors->pluck('name')]
            ];
        });

        return view('student.create-form', compact('programs'));
    }



    public function storeStudent(StudentCreateRequest $request) {
        $data = $request->only([
            // "student_number",
            "last_name",
            "first_name",
            "middle_name",
            "suffix",
            "sex",
            "contact_number",
            "birth_date",
            "birth_place",
            "address",
        ]);

        $data['id_number'] = $request->student_number;
        $data['role_id'] = Role::where('name', RoleEnum::STUDENT)->pluck('id')->first();


        $educationData = $request->only([
            "school_name",
            // "school_address",
            "is_graduated",
            "date_graduated"
        ]);


        // Get Degree
        $educationName = Major::join('education_levels', 'education_levels.id', '=', 'majors.education_level_id')
        ->where('majors.name', $request->degree)
        ->select('education_levels.name as level_name')
        ->pluck('level_name')
        ->first() ?? '';

        $educationData['address'] = $request->school_address?? null;
        $educationData['major'] = $request->degree;
        $educationData['degree'] = $educationName;
        $educationData['year_start'] = $request->date_enrolled;
        $educationData['level'] = $request->year_level ?? null;
        
        if($request->has('is_graduated')) {
            if($request->is_graduated == 1) {
                $educationData['year_end'] = $request->date_graduated;
            }
        }

        DB::beginTransaction();
        try {
            
            //try if query success, if fails rollback database

            $student = User::create($data);
            
            $educationData['user_id'] = $student->id;   
            
            Education::create($educationData);

            DB::commit();

            return view('requestor.congratulation', compact('student'));
        }catch(\Exception $ex) {
            DB::rollback();

            return abort(500);
        }
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
