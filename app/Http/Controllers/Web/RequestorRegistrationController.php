<?php

namespace App\Http\Controllers\Web;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\RequestorRegisterRequest;
use App\Models\Education;
use App\Models\EducationLevel;
use App\Models\Major;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RequestorRegistrationController extends Controller
{

    public function index() {
        $selectPage1 = "active-tab tab-primary";
        $selectPage2 = "";
        $selectPage3 = "";

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

        return view('requestor.registration', compact('selectPage1', 'selectPage2', 'selectPage3', 'programs'));
    }


    public function store(RequestorRegisterRequest $request) {
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
            "email",
        ]);

        $data['id_number'] = $request->student_number;
        $data['role_id'] = Role::where('name', RoleEnum::STUDENT)->pluck('id')->first();

        $educationData = $request->only([
            // "degree",
            // "major",
            // "date_enrolled",
            "year_level",
            "is_graduated",
            // "date_graduated"
        ]);

        
        $educationData['major_id'] = $request->degree;
        $educationData['year_start'] = $request->date_enrolled;
        // $educationData['year_end'] = $request->date_graduated;
        // $educationData['year_level'] = $request->year_level ?? null;
        
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
        // $student = Student::create($data);

    }
}
