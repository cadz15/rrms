<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\EducationLevel;
use App\Models\User;
use App\Services\CryptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestorController extends Controller
{
    public function index(Request $request)
    {
        $search = null;
        $filterGraduate = null;
        $filterEducation = null;

        if($request->has('search')) {
            $search = $request->search;
        }

        if($request->has('filter_is_graduated')) {
            $filterGraduate = $request->filter_is_graduated;
        }

        if($request->has('filter_education_level')) {
            $filterEducation = $request->filter_education_level;
        }

        $requestors = User::where('is_approved', false)
        ->whereNull('approved_by')
        ->when(!empty($search), function($query) use($search) {
            return $query->where(function($subQuery) use($search){
                $subQuery->where('first_name', 'LIKE', '%'. $search .'%')
                ->orWhere('last_name', 'LIKE', '%'. $search .'%');
            });
        })
        ->when(!empty($filterGraduate), function($query) use($filterGraduate){
            return $query->whereHas('educations', function($subQuery) use($filterGraduate) {                
                return $subQuery->where('is_graduated', $filterGraduate);
            });
        })
        ->when(!empty($filterEducation), function($query) use($filterEducation){
            return $query->whereHas('educations', function($subQuery) use($filterEducation) {                
                return $subQuery->where('major', $filterEducation);
            });
        })
        ->paginate(10);

        $programs = EducationLevel::with('majors')
        ->get()
        ->transform(function($level) {
            return [
                'level_name' => $level->name,
                'major_names' => [...$level->majors->pluck('name')],
            ];
        });

        return view('requestor', [
            'requestors' => $requestors,
            'programs' => $programs,
            'filterEducation' => $filterEducation,
            'search' => $search,
            'filterGraduate' => $filterGraduate
        ]);
    }

    public function show(User $student)
    {
        if ($student->is_approved == true) {
            abort(404);
        }
        
        $educations = Education::where('user_id', $student->id)
        ->paginate(1);

        $currentEducation = $educations->first();

        $programs = EducationLevel::with('majors')
        ->get()
        ->transform(function($level) {
            return [
                'level_name' => $level->name,
                'major_names' => [...$level->majors->pluck('name')],
            ];
        });

        return view('student.information-form', compact('student', 'educations', 'programs', 'currentEducation'));
    }

    public function approve($id)
    {
        $id = CryptService::decrypt($id);

        if(empty($id)) abort(404);


        $student = User::where('id', $id)
        ->first();

        if(empty($student)) abort(404);

        $student->update([
            'is_approved' => 1,
            'approved_by' => auth()->user()->id
        ]);

        
        return redirect(route('requestors.list'));
    }


    public function showDisapprove($id) {
        $decryptedId = CryptService::decrypt($id);

        if(empty($decryptedId)) abort(404);


        return view('student.decline-student', compact('id'));
    }

    public function disapprove($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'reason' => 'required'
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $id = CryptService::decrypt($id);

        if(empty($id)) abort(404);


        $student = User::where('id', $id)
        ->first();

        if(empty($student)) abort(404);

        $student->update([
            'is_approved' => 0,
            'approved_by' => auth()->user()->id,
            'reason' => $request->reason
        ]);


        return redirect(route('requestors.list'));
    }

    public function showStudentForm($id)
    {
        $student = User::find($id); 

        if (!$student) {

            abort(404); 
        }
        
        return view('student.information-form', ['student' => $student]);
    }
}
