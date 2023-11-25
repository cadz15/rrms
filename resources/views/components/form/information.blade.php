

<div {{ $attributes->merge(['class' => 'col-12']) }}>
    <div class="card">
        

        <form action="{{ $formURL }}" method="post">

            <div class="card-body">

                <h5 class="card-title mb-3">{{ $formTitle }}</h5>

                @if(is_array($dataForm) && isset($dataForm['id']))
                    <h5>{{ $dataForm['id'] }}</h5>
                @else
                    <h5>Data not found</h5>
                @endif  
                <div class="col-lg-4 col-md-12">
                
                    <div class="form-group">
                        
                        <label for="student_number">Student Number <span class="text-danger">*</span></label>
                        <input type="text" 
                            name="student_number" 
                            id="student_number" 
                            class="form-control {{ $errors->has('student_number') ? 'is-invalid' : '' }}"
                            placeholder="Student's ID Number" 
                            value="@if(!empty($dataForm) && is_array($dataForm)){{ array_key_exists('student_number', $dataForm) ? $dataForm['student_number'] : old('student_number') }}@endif"
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('last_name', $dataForm) ? $dataForm['last_name'] : old('last_name') }}
                            @endif"
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('first_name', $dataForm) ? $dataForm['first_name'] : old('first_name') }}
                            @endif"
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('middle_name', $dataForm) ? $dataForm['middle_name'] : old('middle_name') }}
                            @endif"
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('suffix', $dataForm) ? $dataForm['suffix'] : old('suffix') }}
                            @endif"
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
                                @if(empty($dataForm) || !is_array($dataForm))
                                {{ old("sex") == "male" ? 'selected' : '' }}
                            @elseif(array_key_exists('sex', $dataForm))
                                {{ $dataForm['sex'] == "male" ? 'selected' : '' }}
                            @endif
                                >
                                    Male
                                </option>
                                <option value="female"
                                @if(empty($dataForm) || !is_array($dataForm))
                                {{ old("sex") == "female" ? 'selected' : '' }}
                            @elseif(array_key_exists('sex', $dataForm))
                                {{ $dataForm['sex'] == "female" ? 'selected' : '' }}
                            @endif
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('contact_number', $dataForm) ? $dataForm['contact_number'] : old('contact_number') }}
                            @endif"
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('birth_date', $dataForm) ? $dataForm['birth_date'] : old('birth_date') }}
                            @endif"
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('birth_place', $dataForm) ? $dataForm['birth_place'] : old('birth_place') }}
                            @endif"
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('address', $dataForm) ? $dataForm['address'] : old('address') }}
                            @endif"
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
                                        @if(empty($dataForm))
                                        {{ old("degree") == $degree['id'] ? 'selected' : '' }}
                                    @elseif(isset($dataForm['degree']) && $dataForm['degree'] == $degree['id'])
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
                                        @if(empty($dataForm))
                                        {{ old("major") == $major['id'] ? 'selected' : '' }}
                                    @elseif(isset($dataForm['major']) && $dataForm['major'] == $major['id'])
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('date_enrolled', $dataForm) ? $dataForm['date_enrolled'] : old('date_enrolled') }}
                            @endif"
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('year_level', $dataForm) ? $dataForm['year_level'] : old('year_level') }}
                            @endif"
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
                                    @if(empty($dataForm))
                                    {{ old("is_graduated") == 0 ? 'selected' : '' }}
                                @elseif(isset($dataForm['is_graduated']) && $dataForm['is_graduated'] == 0)
                                    selected="selected"
                                @endif                          
                                >
                                    No
                                </option>
                                <option 
                                    value="1"
                                    @if(empty($dataForm))
                                    {{ old("is_graduated") == 1 ? 'selected' : '' }}
                                @elseif(isset($dataForm['is_graduated']) && $dataForm['is_graduated'] == 1)
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
                                value="@if(!empty($dataForm) && is_array($dataForm))
                                {{ array_key_exists('date_graduated', $dataForm) ? $dataForm['date_graduated'] : old('date_graduated') }}
                            @endif"                                
                            >
                            <div class="invalid-feedback">
                                This field is required.
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="card-footer border-top">
                <button type="submit" class="btn btn-success"><i class='bx bx-save'></i> {{ $saveText }}</button>
                <a href="{{ $cancelURL }}" class="btn btn-outline-danger {{ $cancelVisible }}"><i class='bx bx-block'></i> {{ $cancelText }}</a>
            </div>
        </form>
    </div>
</div>

