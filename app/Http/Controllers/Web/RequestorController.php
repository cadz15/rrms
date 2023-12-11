<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\EducationLevel;
use App\Models\User;
use App\Services\CryptService;
use App\Services\SmsNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RequestorController extends Controller
{
    public function index(Request $request)
    {
        $search = null;
        $filterGraduate = null;
        $filterEducation = null;

        if ($request->has('search')) {
            $search = $request->search;
        }

        if ($request->has('filter_is_graduated')) {
            $filterGraduate = $request->filter_is_graduated;
        }

        if ($request->has('filter_education_level')) {
            $filterEducation = $request->filter_education_level;
        }

        $requestors = User::where('is_approved', false)
            ->where(fn ($query) => $query->whereNull('approved_by')->orWhere('approved_by', '0'))
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                });
            })
            ->when(!empty($filterGraduate), function ($query) use ($filterGraduate) {
                return $query->whereHas('educations', function ($subQuery) use ($filterGraduate) {
                    return $subQuery->where('is_graduated', $filterGraduate);
                });
            })
            ->when(!empty($filterEducation), function ($query) use ($filterEducation) {
                return $query->whereHas(
                    'educations',
                    fn ($subQuery) => $subQuery->whereHas(
                        'major',
                        fn ($majorQuery) => $majorQuery->where('id', $filterEducation)
                    )
                );
            })
            ->with(['educations.major.educationLevel'])
            ->paginate(10);

        $programs = EducationLevel::with('majors')
            ->get()
            ->transform(function ($level) {
                return [
                    'level_name' => $level->name,
                    'major_names' => [...$level->majors],
                ];
            });

        return view('requestor.list', [
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

        $student->load('educations');
        $currentEducation = $student->getLatestEducation();

        $programs = EducationLevel::with('majors')
            ->get()
            ->transform(function ($level) {
                return [
                    'level_name' => $level->name,
                    'major_names' => [...$level->majors],
                ];
            });

        return view('requestor.information', compact('student', 'programs', 'currentEducation'));
    }

    public function approve($id, Request $request)
    {
        $id = CryptService::decrypt($id);

        if (empty($id)) abort(404);

        $validator = Validator::make($request->all(), [
            'student_number' => ['required', Rule::unique('users', 'id_number')->ignore($id, 'id')]
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }


        $student = User::where('id', $id)
            ->first();

        if (empty($student)) abort(404);

        $student->update([
            'id_number' => $request->student_number,
            'password' => bcrypt($randomString),
            'is_approved' => 1,
            'approved_by' => auth()->user()->id
        ]);



        $idNumber = $student->id_number;
        $password = $randomString; // ramdom string for pasword
        $to = '63' . substr($student->contact_number, 1);
        $from = 'RRMS';
        $message = "Greetings, " . $student->last_name . ". Your application has been accepted. Your login information is provided here. Username: $idNumber  Password: $password  ";

        (new SmsNotificationService())->send($to, $from, $message);

        return redirect(route('requestors.list'));
    }


    public function showDisapprove($id)
    {
        $decryptedId = CryptService::decrypt($id);

        if (empty($decryptedId)) abort(404);


        return view('student.decline-student', compact('id'));
    }

    public function disapprove($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $id = CryptService::decrypt($id);

        if (empty($id)) abort(404);


        $student = User::where('id', $id)
            ->first();

        if (empty($student)) abort(404);

        $student->update([
            'is_approved' => 0,
            'approved_by' => auth()->user()->id,
            'reason' => $request->reason
        ]);


        $idNumber = $student->id_number;
        $to = '63' . substr($student->contact_number, 1);
        $from = config('vonage.sms_from');
        $message = "Greetings, " . $student->last_name . ". Your application has been disapproved. ";

        (new SmsNotificationService())->send($to, $from, $message);

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
