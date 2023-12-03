<?php

namespace App\Http\Controllers;

use App\Models\EducationLevel;
use App\Models\Major;
use App\Services\CryptService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EducationController extends Controller
{
    
    public function index(Request $request): View {
        $search = $request->has('search') ? $request->search : '';

        $educations = EducationLevel::with('majors')
        ->where('name', 'LIKE', "%$search%")
        ->paginate(10);

        return view('education.index', compact('educations', 'search'));
    }


    public function view($id): View {
        $decryptedId = CryptService::decrypt($id);
        
        $education = EducationLevel::where('id', $decryptedId)
        ->with('majors')
        ->first();

        if(empty($education)) abort(404);

        return view('education.view', compact('education'));
    }


    public function createEducation(): View {

        return view('education.create');
    }


    public function storeLevel(Request $request) {
        $validator = Validator::make($request->all(), [
            'education_level' => ['required', Rule::unique('education_levels', 'name')],
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $level = EducationLevel::create(['name' => $request->education_level]);

        return redirect(route('education.view', CryptService::encrypt($level->id)));
    }

    public function updateLevel(Request $request) {
        $validator = Validator::make($request->all(), [
            'education_level' => ['required', Rule::unique('education_levels', 'name')->ignore(CryptService::decrypt($request->id_s))],
            'id_s' => ['required'],
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $id = CryptService::decrypt($request->id_s);

        if(!$id) {
            abort(500); // abort if id is not found or unable to decrypt
        }

        $level = EducationLevel::where('id', $id)
        ->first();

        $level->update(['name', $request->education_level]);

        return back()->with('successLevel', 'Level successfully updated!');
    }


    public function storeMajor(Request $request) {
        $validator = Validator::make($request->all(), [
            'major' => ['required', 'unique:majors,name'],
            'id_e' => ['required'],
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        Major::create([
            'name' => $request->major,
            'education_level_id' => CryptService::decrypt($request->id_e)
        ]);

        return back()->with('successMajor', 'Major successfully added!');
    }


    public function deleteMajor($id) {
        $decryptedId = CryptService::decrypt($id);
        $major = Major::where('id', $decryptedId)->first();

        if(empty($major)) abort(404);

        $major->delete();

        return back()->with('successDeleteMajor', 'Major successfully deleted!');
    }
}
