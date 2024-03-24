<?php

namespace App\Http\Controllers\Web;

use App\Enums\RequestStatusEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EducationLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCreateRequest;
use App\Models\Education;
use App\Models\Major;
use App\Models\Request as ModelsRequest;
use App\Models\RequestableItem;
use App\Models\RequestStatusHistory;
use App\Models\Role;
use App\Services\CryptService;
use App\Services\SmsNotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function Ramsey\Uuid\v1;

class StudentController extends Controller
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

        $students = User::approvedStudents()
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('id_number', 'LIKE', '%'. $search .'%');
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
            ->with('educations.major')
            ->paginate(10);

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

        // $students = User::approvedStudents()->with('educations.major')->paginate(10);

        return view('student.list', compact('students', 'programs', 'filterEducation', 'search', 'filterGraduate'));
    }


    public function requestHistory($id, Request $request) {
        $search = $request->has('search')? $request->search : '';
        $filterStatus = $request->has('filter_status') ? $request->filter_status : '';

        $requests = ModelsRequest::whereNull('deleted_at')
        ->where('user_id', $id)
        ->when($request->has('search'), function($query) use($search){
            
            if(!empty($search)) {
                return $query->whereHas('user', function($subQuery) use($search){
                    $subQuery->where('first_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%");
                })
                ->orWhereHas('requestItems', function($subQuery) use($search) {
                    $subQuery->where('item_name', 'LIKE', "%$search%");
                });
            }
        })
        ->when(!empty($filterStatus), function($query) use($filterStatus){

            $query->where('status', $filterStatus);
        })
        ->with(['requestItems', 'user'])
        ->latest()
        ->paginate(10);

        $statuses = [
            [
                'name' => 'Pending for review',
                'value' => 'pending_for_review'
            ],
            [
                'name' => 'Pending payment',
                'value' => 'pending_payment'
            ],
            [
                'name' => 'For Pickup',
                'value' => 'for_pick_up'
            ],
            [
                'name' => 'Declined',
                'value' => 'declined'
            ],
            [
                'name' => 'Completed',
                'value' => 'completed'
            ],
        ];
       
        return view('student.item-request-history', compact('requests', 'search', 'filterStatus', 'statuses'));
    }



    public function showAccount() {
        return view('student.account-setting');
    }


    public function changePassword($id, Request $request) {
        $request->validate([
            'password' => ['required', 'min:3', 'max:50', 'confirmed'],
        ]);

        $student = User::where('id', $request->id)
        ->where('role_id', Role::where('name', RoleEnum::STUDENT)->pluck('id')->first())
        ->first();

        if(empty($student)) return abort(404);

        $student->update([
            'password' => bcrypt($request->password)
        ]);

        
        return redirect()->back()->with('success', 'Password successfully updated!');
    }

    public function viewCreate() {
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
            "email",
        ]);

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        $data['id_number'] = $request->student_number;
        $data['role_id'] = Role::where('name', RoleEnum::STUDENT)->pluck('id')->first();
        $data['is_approved'] = 1;
        $data['approved_by'] = auth()->user()->id;
        $data['password'] = bcrypt($randomString);

        $educationData = $request->only([
            "school_name",
            // "school_address",
            "is_graduated",
            // "date_graduated",
            "year_level"
        ]);



        $educationData['address'] = $request->school_address?? null;
        $educationData['major_id'] = $request->degree;
        // $educationData['degree'] = $educationName;
        $educationData['year_start'] = $request->date_enrolled;
        // $educationData['level'] = $request->year_level ?? null;
        
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

            $idNumber = $request->student_number;
            $password = $randomString; // ramdom string for pasword
            $to = '63' . substr($request->contact_number, 1);
            $from = 'RRMS';
            $message = "Greetings, " . $student->last_name . ". Your application has been accepted. Your login information is provided here. Username: $idNumber  Password: $password  ";

            (new SmsNotificationService())->send($to, $from, $message);

            DB::commit();

            return view('student.congratulation', compact('student'));
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

        return view('student.information-form', compact('student', 'programs'));
    }

    public function update($encryptedId, Request $request)
    {
        $id = CryptService::decrypt($encryptedId);

        // $validator = Validator::make($request->all(), [
        //     'student_number' => ['required', 'unique:users,id_number,' . $id],
        //     'last_name' => ['required'],
        //     'first_name' => ['required'],
        //     'suffix' => ['max:10'],
        //     'sex' => 'required',
        //     'contact_number' => ['required', 'regex:/^0\d{10}$/', 'unique:users,contact_number,' . $id],
        //     'email' => ['required', 'email'],
        // ]);

        $request->validate([
            'student_number' => ['required', 'unique:users,id_number,' . $id],
            'last_name' => ['required'],
            'first_name' => ['required'],
            'suffix' => ['max:10'],
            'sex' => 'required',
            'contact_number' => ['required', 'regex:/^0\d{10}$/', 'unique:users,contact_number,' . $id],
            'email' => ['required', 'email'],
        ]);

        $data = $request->only([
            'last_name',
            'first_name',
            'middle_name',
            'suffix',
            'sex',
            'contact_number',
            'email',
            'birth_date',
            'birth_place',
            'address'
        ]);

        $data['id_number'] = $request->student_number;

        $student = User::where('id', $id)->first();

        if(empty($student)) return abort(404);

        $student->update($data);

        return redirect()->back()->with('successUpdate', ['Student information successfully updated!']);
    }

    public function create()
    {
        $degrees = EducationLevel::get();
        $majors = Major::get();

        return view('student.create-form', compact('degrees', 'majors'));
    }


    /**
     * Student Dashboard
     *  - Show list of request
     */
    public function dashboard() {
        $requests = ModelsRequest::where('user_id', auth()->user()->id)->latest()->paginate(10);

        return view('student.dashboard', compact('requests'));  
    }

    public  function viewRequest($id) {
        $request = ModelsRequest::where('id', $id)->where('user_id', auth()->user()->id)->with('user')->first();
        
        if(empty($request)) return abort(404);

        $declinedHistory = RequestStatusHistory::where('request_id', $request->id)->where('status', RequestStatusEnum::DECLINED->value)->first();
        $approvedHistory = RequestStatusHistory::where('request_id', $request->id)->where('status', RequestStatusEnum::PENDING_REVIEW->value)->first();
        $paidHistory = RequestStatusHistory::where('request_id', $request->id)->where('status', RequestStatusEnum::PENDING_PAYMENT->value)->first();
        $workedOnRequestHistory = RequestStatusHistory::where('request_id', $request->id)->where('status', RequestStatusEnum::WORKING_ON_REQUEST->value)->first();
        $pickupedHistory = RequestStatusHistory::where('request_id', $request->id)->where('status', RequestStatusEnum::FOR_PICK_UP->value)->first();
        $completedHistory = RequestStatusHistory::where('request_id', $request->id)->where('status', RequestStatusEnum::COMPLETED->value)->first();


        $total = $request->requestItems->reduce(function($carry, $item) {
            $price = $item->price?? 0;

            return $carry + ($item->quantity * $price);
        });

        $degrees = Education::where('user_id', auth()->user()->id)->pluck('major_id');
        $majors = Major::whereIn('id', $degrees)->get();

        $requestableItems = RequestableItem::all();

        $items = $request->requestItems->map(function($item) use($majors){
            return [
                'item_id' => $item->item_id,
                'item_name' => $item->item_name,
                'degree_id' => $majors->where('name', $item->degree_name)->pluck('id')->first(),
                'degree_name' => $item->degree_name,
                'quantity' => $item->quantity,
            ];
        })->toArray();

        
        return view('student.view-request', compact('items', 'majors', 'requestableItems', 'request', 'declinedHistory', 'approvedHistory', 'paidHistory', 'workedOnRequestHistory', 'pickupedHistory', 'completedHistory', 'total'));;
    }


    public function viewRequestCreate() {
        $degrees = Education::where('user_id', auth()->user()->id)->pluck('major_id');
        $majors = Major::whereIn('id', $degrees)->get();

        $requestableItems = RequestableItem::all();

        return view('student.create-request', compact('majors', 'requestableItems'));
    }

    public function cancelRequest($id) {
        $request = ModelsRequest::where('id', $id)->where('user_id', auth()->user()->id)->with('user')->first();

        if(empty($request)) return abort(404);

        if($request->status == RequestStatusEnum::PENDING_REVIEW->value) {
            $request->update([
                'status' => RequestStatusEnum::DECLINED->value
            ]);

            return redirect(route('student.dashboard'));
        }else {
            return redirect()->back()->with('error_status', 'You cannot cancel this request. Request has already been approved.');
        }
    }


    public function viewProfile() {
        $student = auth()->user();

        return view('student.information', compact('student'));
    }


    public  function updateProfile(Request $request) {
        // $validator = Validator::make($request->all(), [
        //     'last_name' => ['required'],
        //     'first_name' => ['required'],
        //     'suffix' => ['max:10'],
        //     'sex' => 'required',
        //     'contact_number' => ['required', 'regex:/^0\d{10}$/', 'unique:users,contact_number,' . auth()->user()->id],
        //     'email' => ['required', 'email'],
        // ]);

        $request->validate([
            'last_name' => ['required'],
            'first_name' => ['required'],
            'suffix' => ['max:10'],
            'sex' => 'required',
            'contact_number' => ['required', 'regex:/^0\d{10}$/', 'unique:users,contact_number,' . auth()->user()->id],
            'email' => ['required', 'email'],
        ]);

        $data = $request->only([
            'last_name',
            'first_name',
            'middle_name',
            'suffix',
            'sex',
            'contact_number',
            'email',
            'birth_date',
            'birth_place',
            'address'
        ]);

        $student = User::where('id', auth()->user()->id)->first();

        if(empty($student)) return abort(404);

        $student->update($data);

        return redirect()->back()->with('successUpdate', ['Student information successfully updated!']);
    }

    public function viewEducations() {
        $educations = auth()->user()->educations()->latest('year_start')->paginate(15);

        return view('student.education-list', compact('educations'));
    }


    public function viewChangePassword() {
        return view('student.change-password');
    }

    public function changePass(Request $request) {
        $request->validate([
            'password' => ['required', 'min:3', 'max:50', 'confirmed'],
        ]);

        $student = User::where('id', auth()->user()->id)
        ->where('role_id', Role::where('name', RoleEnum::STUDENT)->pluck('id')->first())
        ->first();

        if(empty($student)) return abort(404);

        $student->update([
            'password' => bcrypt($request->password)
        ]);

        
        return redirect()->back()->with('success', 'Password successfully updated!');
    }
}
