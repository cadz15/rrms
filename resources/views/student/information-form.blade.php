 @extends('layout.contentLayoutMaster')

@section('title', 'Student | Information Form')


@section('content')
<div class="col-12">

    <div class="card">       

        <div class="card-body">

            <h5 class="card-title mb-3">Requestor Information</h5>

            <div class="col-lg-4 col-md-12">
            
                <div class="form-group">
                    
                    <label for="id_number">Student Number <span class="text-danger">*</span></label>
                    <input type="text" 
                        name="id_number" 
                        id="id_number" 
                        class="form-control {{ $errors->has('id_number') ? 'is-invalid' : '' }}"
                        placeholder="Student's ID Number" 
                        value="{{ $student->id_number }}"
                    >
                    <div class="invalid-feedback">
                        This field is required and must be unique.
                    </div>
                </div>
            </div>

            <div class="row mt-2 gy-2">
                
                <div class="divider">
                    <div class="divider-text"><h6>Basic Information</h6></div>
                </div>
            

                <div class="col-lg-4 col-md-12">

                    <div class="form-group">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input type="text" 
                            name="last_name" 
                            id="last_name" 
                            class="form-control  {{ $errors->has('last_name') ? 'is-invalid' : '' }}" 
                            placeholder="Last Name"
                            value="{{ $student->last_name }}"
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
                            value="{{ $student->first_name }}"
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
                            value="{{ $student->middle_name }}"
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
                            value="{{ $student->suffix }}"
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
                            {{ $student->sex == "male" ? 'selected' : '' }}
                            >
                                Male
                            </option>
                            <option value="female"
                            {{ $student->sex == "female" ? 'selected' : '' }}
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
                            placeholder="Contact Number"
                            value="{{ $student->contact_number }}"
                        >
                        <div class="invalid-feedback">
                            This field is required.
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
                            value="{{ $student->birth_date }}"
                        >
                        <div class="invalid-feedback">
                            This field is required.
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
                            value="{{ $student->birth_place }}"
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
                            value="{{ $student->address }}"
                        >
                        <div class="invalid-feedback">
                            This field is required.
                        </div>
                    </div>
                </div>


                <div class="divider">
                    <div class="divider-text"><h6>Education</h6></div>
                </div>

                @if(empty($currentEducation))

                <div class="alert alert-danger" role="alert">
                    No Education found!
                </div>
                @else 
                <div class="col-lg-8 col-md-12">

                    <div class="form-group">
                        <label for="degree">Education Level / Degree <span class="text-danger">*</span></label>
                        <select name="degree" id="degree" class="form-select  {{ $errors->has('degree') ? 'is-invalid' : '' }}">
                            <option value="">--Select Degree/Course--</option>
                            @foreach ($programs as $program)
                                <optgroup label="{{ $program['level_name'] }}">
                                    @foreach($program['major_names'] as $major)
                                        <option value="{{ $major }}" 
                                            @if($major == $currentEducation->major)
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
                
                
                <div class="col-lg-4 col-md-12">

                    <div class="form-group">
                        <label for="date_enrolled">Date Enrolled <span class="text-danger">*</span></label>
                        <input type="date" 
                            name="date_enrolled" 
                            id="date_enrolled" 
                            class="form-control  {{ $errors->has('date_enrolled') ? 'is-invalid' : '' }}"
                            value="{{ $currentEducation->year_start }}"
                        >
                        <div class="invalid-feedback">
                            This field is required.
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">

                    <div class="form-group">
                        <label for="year_level">Year Level <span class="text-danger">*</span></label>
                        <input type="number" 
                            name="year_level" 
                            id="year_level" 
                            class="form-control  {{ $errors->has('year_level') ? 'is-invalid' : '' }}" 
                            placeholder="Year Level"
                            value="{{ $currentEducation->level }}"
                        >
                        <div class="invalid-feedback">
                            This field is required.
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">

                    <div class="form-group">
                        <label for="is_graduated">Is Graduate</label>
                        <select name="is_graduated" id="is_graduated" class="form-control  {{ $errors->has('is_graduated') ? 'is-invalid' : '' }}">
                            <option 
                                value="0"
                                @if($currentEducation->is_graduated == 0)
                                    selected="selected"
                                @endif
                            >
                                No
                            </option>
                            <option 
                                value="1"
                                @if($currentEducation->is_graduated == 1)
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
                            value="{{ $currentEducation->date_graduated }}"                                
                        >
                        <div class="invalid-feedback">
                            This field is required.
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12">

                    <div class="form-group">
                        <label for="school_name">School Name</label>
                        <input type="text" 
                            name="school_name" 
                            id="school_name" 
                            class="form-control  {{ $errors->has('school_name') ? 'is-invalid' : '' }}"
                            value="{{ $currentEducation->school_name }}"   
                            placeholder="School Name"                             
                        >
                        <div class="invalid-feedback">
                            This field is required.
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12">

                    <div class="form-group">
                        <label for="school_address">School Address</label>
                        <input type="text" 
                            name="school_address" 
                            id="school_address" 
                            class="form-control  {{ $errors->has('school_address') ? 'is-invalid' : '' }}"
                            value="{{ $currentEducation->address }}"  
                            placeholder="School Address"                              
                        >
                        <div class="invalid-feedback">
                            This field is required.
                        </div>
                    </div>
                </div>

                <div class="px-3 pt-3 float-end">
                    {{ $educations->links() }}
                </div>
                @endif
                <!-- Education End -->

            </div>

        </div>

        <div class="card-footer border-top">
            <a href="{{ route('requestors.show.disapprove', cryptor($student->id)) }}" class="btn btn-outline-danger"><i class='bx bx-dislike'></i> Disapprove</a>
            <a href="{{ route('requestors.approve', cryptor($student->id)) }}" class="btn btn-outline-success"><i class='bx bx-like'></i> Approve</a>
        </div>
    </div>
</div>

@endsection