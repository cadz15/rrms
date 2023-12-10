 @extends('layout.contentLayoutMaster')

 @section('title', 'Education Background | Form')


 @section('content')
     <div class="col-12">
         <form action="{{ route('educations.store', ['id' => $student->id]) }}" method="post">
             @csrf
             <div class="card">
                 <div class="card-body">
                     <h5 class="card-title mb-3">Education Background Form</h5>
                     <div class="col-lg-4 col-md-12">
                         <div class="form-group">
                             <label for="student_number">Student Number</label>
                             <input type="text"id="student_number" class="form-control" placeholder="Student's ID Number"
                                 value="{{ $student->id_number }}" readonly>
                         </div>
                     </div>

                     <div class="row mt-2 gy-2">
                         <div class="divider">
                             <div class="divider-text">
                                 <h6>Education</h6>
                             </div>
                         </div>

                         <div class="col-lg-8 col-md-12">
                             <div class="form-group">
                                 <label for="degree">Education Level / Degree <span class="text-danger">*</span></label>
                                 <select name="degree" id="degree"
                                     class="form-select  {{ $errors->has('degree') ? 'is-invalid' : '' }}">
                                     <option value="">--Select Degree/Course--</option>
                                     @foreach ($programs as $program)
                                         <optgroup label="{{ $program['level_name'] }}">
                                             @foreach ($program['major_names'] as $major)
                                                 <option value="{{ $major->id }}"
                                                     @if ($major->id == old('degree')) selected @endif>
                                                     {{ ucwords($major->name) }}
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
                                 <input type="date" name="date_enrolled" id="date_enrolled"
                                     class="form-control  {{ $errors->has('date_enrolled') ? 'is-invalid' : '' }}"
                                     value="{{ old('year_start') }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="year_level">Year Level <span class="text-danger">*</span></label>
                                 <input type="number" name="year_level" id="year_level"
                                     class="form-control  {{ $errors->has('year_level') ? 'is-invalid' : '' }}"
                                     placeholder="Year Level" value="{{ old('year_level') }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="is_graduated">Is Graduate</label>
                                 <select name="is_graduated" id="is_graduated"
                                     class="form-select  {{ $errors->has('is_graduated') ? 'is-invalid' : '' }}">
                                     <option value="0" @if (old('is_graduated') == 0) selected="selected" @endif>
                                         No
                                     </option>
                                     <option value="1" @if (old('is_graduated') == 1) selected="selected" @endif>
                                         Yes
                                     </option>
                                 </select>
                                 @error('is_graduated')
                                     <div class="invalid-feedback">
                                         {{ $message }}
                                     </div>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="year_end">Date Graduated</label>
                                 <input type="date" name="year_end" id="year_end"
                                     class="form-control  {{ $errors->has('year_end') ? 'is-invalid' : '' }}"
                                     value="{{ old('year_end') }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-12 col-md-12">

                             <div class="form-group">
                                 <label for="school_name">School Name</label>
                                 <input type="text" name="school_name" id="school_name"
                                     class="form-control  {{ $errors->has('school_name') ? 'is-invalid' : '' }}"
                                     value="{{ old('school_name') ?? config('education.school_name') }}"
                                     placeholder="School Name">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-12 col-md-12">

                             <div class="form-group">
                                 <label for="school_address">School Address</label>
                                 <input type="text" name="school_address" id="school_address"
                                     class="form-control  {{ $errors->has('school_address') ? 'is-invalid' : '' }}"
                                     value="{{ old('school_address') ?? config('education.school_address') }}"
                                     placeholder="School Address">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                     </div>

                 </div>

                 <div class="card-footer border-top">
                     <a href="{{ url()->previous() }}" class="btn btn-outline-danger gap-1"><i class='bx bx-exit'></i>
                         Cancel</a>
                     <button type="submit" class="btn btn-outline-success gap-1"><i class='bx bx-save'></i>
                         Save</button>
                 </div>
             </div>

         </form>
     </div>
 @endsection
