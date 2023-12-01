@extends('layout.contentLayoutFull')

@section('title', 'Register')

@section('page-styles')

    <style>
        .multi-step-indicator {
            padding: 1rem;
            border: 1px solid #d9dee3;
        }

        .multi-step-indicator:first-of-type{
            border-left: none;
            border-right: none;
        }
        
        .multi-step-indicator:last-of-type {
            border-left: none;
            border-right: none;
        }

        .multi-step-indicator.active-step {
            border-bottom: 2px solid #d9dee3;
            font-size: 1rem;
            font-weight: bold;
        }


        .multi-step-indicator.active-step.step-primary {
            border-bottom-color: #696cff !important;
            color: #696cff !important;
            background-color: #E1E1FF !important;
        }
        .multi-step-indicator.active-step.step-success {
            border-bottom-color: #16794B !important;
            color: #16794B !important;
            background-color: #D0E4DB !important;
        }
        .multi-step-indicator.active-step.step-danger {
            border-bottom-color: #dc3545 !important;
            color: #dc3545 !important;
            background-color: #F8D6D9 !important;
        }

        .hidden {
            display: none !important;
        }
    </style>
@endsection
@section('content')

<div class="container-xxl">
    
    <div class="row">
        
        <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2 mt-4">

            <div class="card">
                <div class="card-header">
                    <h5>Requestor Registration</h5>
                </div>

                <div>
                    <table class="w-100">
                        <tr>
                            <td width="33.3%" class="multi-step-indicator active-step
                                @if(array_intersect($errors->keys(), ['last_name', 'first_name', 'sex', 'contact_number', 'birth_date', 'birth_place', 'address'])) step-danger @else step-primary @endif
                            " id="page-1-indicator">
                                <i class='bx bx-check-circle text-success hidden' id="page-1-success-icon"></i>
                                <i class='bx bx-x-circle text-danger 
                                @if(array_intersect($errors->keys(), ["last_name", "first_name", "sex", "contact_number", "birth_date", "birth_place", "address"]))  @else hidden @endif
                                ' id="page-1-danger-icon"></i>
                                <i class='bx bx-circle 
                                @if(array_intersect($errors->keys(), ["last_name", "first_name", "sex", "contact_number", "birth_date", "birth_place", "address"])) hidden @else  @endif
                                ' id="page-1-primary-icon"></i>
                                Basic Information
                            </td>
                            <td  width="33.3%" class="multi-step-indicator" id="page-2-indicator">
                                <i class='bx bx-check-circle text-success hidden' id="page-2-success-icon"></i>
                                <i class='bx bx-x-circle text-danger 
                                @if(array_intersect($errors->keys(), ["degree", "major", "date_enrolled", "year_level"]))  @else hidden @endif
                                ' id="page-2-danger-icon"></i>
                                <i class='bx bx-circle
                                @if(array_intersect($errors->keys(), ["degree", "major", "date_enrolled", "year_level"])) hidden @else  @endif
                                ' id="page-2-primary-icon"></i>
                                Education
                            </td>
                            <td  width="33.3%" class="multi-step-indicator " id="page-3-indicator">
                                <i class='bx bx-check-circle text-success hidden' id="page-3-success-icon"></i>
                                <i class='bx bx-x-circle text-danger hidden' id="page-3-danger-icon"></i>
                                <i class='bx bx-circle' id="page-3-primary-icon"></i>
                                Review and Submit
                            </td>
                        </tr>
                    </table>
                </div>

                <form action="{{ route('requestor.register') }}" method="post" id="register-form">
                    @csrf
                    <div class="card-body">
                        <!-- Page 1 start -->
                        <div id="page-1">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                    
                                    <input type="hidden" name="used" id="used" value="{{ $errors->has('contact_number')? old('contact_number') : '' }}">
                                    <div class="form-group">
                                        
                                        <label for="student_number">Student Number</label>
                                        <input type="text" 
                                            name="student_number" 
                                            id="student_number" 
                                            class="form-control {{ $errors->has('student_number') ? 'is-invalid' : '' }}"
                                            placeholder="Student's ID Number" 
                                            value="{{ old('student_number') }}"
                                        >
                                        <div class="invalid-feedback">
                                            This field is required and must be unique.
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="row gy-3 mt-3 mb-2">
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            name="last_name" 
                                            id="last_name" 
                                            class="form-control  {{ $errors->has('last_name') ? 'is-invalid' : '' }}" 
                                            placeholder="Last Name"
                                            value="{{ old('last_name') }}"
                                        >
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            name="first_name" 
                                            id="first_name" 
                                            class="form-control  {{ $errors->has('first_name') ? 'is-invalid' : '' }}" 
                                            placeholder="First Name"
                                            value="{{ old('first_name') }}"
                                        >
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" 
                                            name="middle_name" 
                                            id="middle_name" 
                                            class="form-control  {{ $errors->has('middle_name') ? 'is-invalid' : '' }}" 
                                            placeholder="Middle Name"
                                            value="{{ old('middle_name') }}"
                                        >
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="suffix">Suffix</label>
                                        <input type="text" 
                                            name="suffix" 
                                            id="suffix" 
                                            class="form-control  {{ $errors->has('suffix') ? 'is-invalid' : '' }}" 
                                            placeholder="ex. Jr. Sr. III"
                                            value="{{ old('suffix') }}"
                                        >
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="sex">Sex <span class="text-danger">*</span></label>
                                        <select name="sex" id="sex" class="form-select  {{ $errors->has('sex') ? 'is-invalid' : '' }}">
                                            <option value="">--Select--</option>
                                            <option value="male"
                                            {{ old('sex') == "male" ? 'selected' : '' }}
                                            >
                                                Male
                                            </option>
                                            <option value="female"
                                            {{ old('sex') == "female" ? 'selected' : '' }}
                                            >
                                                Female
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="contact_number">Contact # <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            name="contact_number" 
                                            id="contact_number" 
                                            class="form-control  {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" 
                                            placeholder="Contact Number ex. 09123456789"
                                            value="{{ old('contact_number') }}"
                                        >
                                        <div class="invalid-feedback">
                                            @if($errors->has('contact_number'))
                                                {{ $errors->first('contact_number') }}
                                            @else 
                                                This field is required or number already in use.
                                            @endif
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="birth_date">Birthday <span class="text-danger">*</span></label>
                                        <input type="date" 
                                            name="birth_date" 
                                            id="birth_date" 
                                            class="form-control  {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" 
                                            placeholder="Birthday"
                                            value="{{ old('birth_date') }}"
                                        >
                                        <div class="invalid-feedback">
                                            @if($errors->has('birth_date'))
                                                {{ $errors->first('birth_date') }}
                                            @else 
                                                This field is required!
                                            @endif
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-8 col-md-12">
    
                                    <div class="form-group">
                                        <label for="birth_place">Birth Place <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            name="birth_place" 
                                            id="birth_place" 
                                            class="form-control  {{ $errors->has('birth_place') ? 'is-invalid' : '' }}" 
                                            placeholder="Birth Place"
                                            value="{{ old('birth_place') }}"
                                        >
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                
                                <div class="col-lg-12 col-md-12">
    
                                    <div class="form-group">
                                        <label for="address">Address <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            name="address" 
                                            id="address" 
                                            class="form-control  {{ $errors->has('address') ? 'is-invalid' : '' }}" 
                                            placeholder="Address"
                                            value="{{ old('address') }}"
                                        >
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- button controls -->
                            <div class="mt-4 d-flex flex-row-reverse">
                                <button class="btn btn-primary" id="goto-page-2">Next <i class='bx bx-right-arrow-alt'></i></button>
                            </div>
                        </div>
                        <!-- Page 1 End -->
    
                        <!-- Page 2 Start -->
                        <div id="page-2" class="hidden">
                            <div class="row gy-3">

                                <div class="col-lg-8 col-md-12">
    
                                    <div class="form-group">
                                        <label for="degree">Education Level / Degree <span class="text-danger">*</span></label>
                                        <select type="text" name="degree" id="degree" class="form-select {{ $errors->has('degree') ? 'is-invalid' : '' }}" style="width:100%">
                                        @foreach ($programs as $program)
                                            <optgroup label="{{ $program['level_name'] }}">
                                                @foreach($program['major_names'] as $major)
                                                    <option value="{{ $major }}" 
                                                        @if($major == old('major'))
                                                            selected
                                                        @endif
                                                    >
                                                    {{ ucwords($major) }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                <!-- <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="major">Major (Leave blank if not applicable)</label>
                                        <input type="text" name="major" id="major" class="form-control  {{ $errors->has('major') ? 'is-invalid' : '' }}" value="{{ old('major') }}">
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div> -->
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="date_enrolled">Date Enrolled <span class="text-danger">*</span></label>
                                        <input type="date" 
                                            name="date_enrolled" 
                                            id="date_enrolled" 
                                            class="form-control  {{ $errors->has('date_enrolled') ? 'is-invalid' : '' }}"
                                            value="{{ old('date_enrolled') }}"
                                        >
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="year_level">Year Level (for tertiary and above)</label>
                                        <input type="number" 
                                            name="year_level" 
                                            id="year_level" 
                                            class="form-control  {{ $errors->has('year_level') ? 'is-invalid' : '' }}" 
                                            placeholder="Year Level"
                                            value="{{ old('year_level') }}"
                                        >
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="is_graduated">Is Graduate</label>
                                        <select name="is_graduated" id="is_graduated" class="form-select  {{ $errors->has('is_graduated') ? 'is-invalid' : '' }}">
                                            <option 
                                                value="0"
                                                @if(old('is_graduated') == 0)
                                                    selected="selected"
                                                @endif
                                            >
                                                No
                                            </option>
                                            <option 
                                                value="1"
                                                @if(old('is_graduated') == 1)
                                                    selected="selected"
                                                @endif   
                                            >
                                                Yes                                    
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
    
                                    <div class="form-group">
                                        <label for="date_graduated">Date Graduated</label>
                                        <input type="date" 
                                            name="date_graduated" 
                                            id="date_graduated" 
                                            class="form-control  {{ $errors->has('date_graduated') ? 'is-invalid' : '' }}"
                                            value="{{ old('date_graduated') }}"                                
                                        >
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- button controls -->
                            <div class="mt-4 d-flex flex-row-reverse justify-content-between">
                                <button class="btn btn-primary" id="goto-page-3">Next <i class='bx bx-right-arrow-alt'></i></button>
                                <button class="btn btn-secondary" id="go-back-page-1"><i class='bx bx-left-arrow-alt'></i> Previous</button>
                            </div>
                        </div>
                        <!-- Page 2 End -->
    
                        <!-- Page 3 Start -->
                        <div id="page-3" class="hidden">
    
                            <div class="col-12">
                                <div class="divider divider-primary">
                                    <div class="divider-text">Basic Information</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Student Number</span>
                                        <b id="student_number_text">Hello World!</b>
                                    </div>
                                </div>
                            </div>
    
                            <div class="row gy-3 mt-2">
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Last Name</span>
                                        <b id="last_name_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>First Name</span>
                                        <b id="first_name_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Middle Name</span>
                                        <b id="middle_name_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Suffix</span>
                                        <b id="suffix_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Sex</span>
                                        <b id="sex_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Contact Number</span>
                                        <b id="contact_number_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Birthday</span>
                                        <b id="birthday_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-8 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Birth Place</span>
                                        <b id="birth_place_text"></b>
                                    </div>
                                </div>
    
    
                                <div class="col-lg-12 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Address</span>
                                        <b id="address_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-12">
                                    <div class="divider divider-primary">
                                        <div class="divider-text">Education</div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Education Level / Degree</span>
                                        <b id="degree_text"></b>
                                    </div>
                                </div>
    
                                <!-- <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Major</span>
                                        <b id="major_text"></b>
                                    </div>
                                </div> -->
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Date Enrolled</span>
                                        <b id="date_enrolled_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Year Level</span>
                                        <b id="year_level_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Is Graduated</span>
                                        <b id="is_graduated_text"></b>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 col-md-12">
                                    <div class="d-flex flex-column">
                                        <span>Date Graduated</span>
                                        <b id="date_graduated_text"></b>
                                    </div>
                                </div>
                            </div>
    
    
                            <!-- button controls -->
                            <div class="mt-4 d-flex flex-row-reverse justify-content-between">
                                <button type="submit" class="btn btn-success" id="register-requestor">Register</button>
                                <button class="btn btn-secondary" id="go-back-page-2"><i class='bx bx-left-arrow-alt'></i> Previous</button>
                            </div>
                        </div>
                        <!-- Page 3 End -->
    
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@vite(['resources/js/requestor-registration.js'])