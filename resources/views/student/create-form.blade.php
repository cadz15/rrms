@extends('layout.contentLayoutMaster')

@section('title', 'Add Student | Information Form')

@section('content')
<div class="col-12">

    <div class="card">       

        <div class="card-body">

            <h5 class="card-title mb-3">
                <span class="text-muted fw-light">Add Student /</span> Information Form
            </h5>

            <div class="col-lg-4 col-md-12">
            
                <div class="form-group">
                    
                    <label for="id_number">Student Number <span class="text-danger">*</span></label>
                    <input type="text" 
                        name="id_number" 
                        id="id_number" 
                        class="form-control {{ $errors->has('id_number') ? 'is-invalid' : '' }}"
                        placeholder="Student's ID Number" 
                        value="{{ old('id_number') }}"
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
                            placeholder="Contact Number"
                            value="{{ old('contact_number') }}"
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
                            value="{{ old('birth_date') }}"
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


                <div class="divider">
                    <div class="divider-text"><h6>Education</h6></div>
                </div>


                <div class="col-lg-4 col-md-12">

                    <div class="form-group">
                        <label for="degree">Degree / Course <span class="text-danger">*</span></label>
                        <select name="degree" id="degree" class="form-select  {{ $errors->has('degree') ? 'is-invalid' : '' }}">
                            <option value="">--Select Degree/Course--</option>
                            @if(!empty($degrees))
                                @foreach ($degrees as $degree)
                                    <option value="{{ $degree['id'] }}"
                                    @if(old('degree') == $degree['id'])
                                        selected="selected"
                                    @endif
                                    >
                                        {{ $degree['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            This field is required.
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12">

                    <div class="form-group">
                        <label for="major">Major <span class="text-danger">*</span></label>
                        <select name="major" id="major" class="form-select  {{ $errors->has('major') ? 'is-invalid' : '' }}">
                            <option value="">--Select Major--</option>
                            @if(!empty($majors))
                                @foreach ($majors as $major)
                                    <option value="{{ $major['id'] }}"
                                    @if(old('major') == $major['id'])
                                        selected="selected"
                                    @endif
                                    >
                                        {{ $major['name'] }}
                                    </option>
                                @endforeach
                            @endif
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
                            value="{{ old('date_enrolled') }}"
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
                        <select name="is_graduated" id="is_graduated" class="form-control  {{ $errors->has('is_graduated') ? 'is-invalid' : '' }}">
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

        </div>

        <div class="card-footer border-top">
            <a href="#" class="btn btn-outline-success gap-1"><i class='bx bx-save'></i> Save</a>
        </div>
    </div>
</div>

@endsection