@extends('layout.contentLayoutStudent')

@section('title', 'Basic Information')

@section('page-styles')
    <style>
        .loading-livewire {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        border: 1px solid black;
        margin: 0;
        padding: 0;
        left: 0;
        text-align: center;
        display: flex;
        align-items: center;
        background-color: #000;
        opacity: 0.5;
    }
    </style>
@endsection

@section('content')

    <h5 class="py-3">
        <span class="text-muted fw-light"> Basic Information </span>
    </h5>

    
    <div class="col-12">
        @if(session()->has('successUpdate'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('successUpdate')[0] }}
            </div>
        @endif
         <form action="{{ route('student.profile.update') }}" method="post">
             @method('PUT')
             @csrf
             <div class="card">

                 <div class="card-body">

                     <h5 class="card-title mb-3">Requestor Information</h5>

                     <div class="col-lg-4 col-md-12">

                         <div class="form-group">

                             <label for="student_number">Student Number</label>
                             <input type="text" name="student_number" id="student_number" readonly
                                 class="form-control {{ $errors->has('student_number') ? 'is-invalid' : '' }}"
                                 placeholder="Student's ID Number" value="{{ $student->id_number }}">
                             <div class="invalid-feedback">
                                 @if ($errors->has('student_number'))
                                     {{ $errors->first('student_number') }}
                                 @endif
                             </div>
                         </div>
                     </div>

                     <div class="row mt-2 gy-2 my-2">

                         <div class="divider">
                             <div class="divider-text">
                                 <h6>Basic Information</h6>
                             </div>
                         </div>


                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                 <input type="text" name="last_name" id="last_name"
                                     class="form-control  {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                     placeholder="Last Name" value="{{ $student->last_name }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="first_name">First Name <span class="text-danger">*</span></label>
                                 <input type="text" name="first_name" id="first_name"
                                     class="form-control  {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                     placeholder="First Name" value="{{ $student->first_name }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="middle_name">Middle Name</label>
                                 <input type="text" name="middle_name" id="middle_name"
                                     class="form-control  {{ $errors->has('middle_name') ? 'is-invalid' : '' }}"
                                     placeholder="Middle Name" value="{{ $student->middle_name }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="suffix">Suffix</label>
                                 <input type="text" name="suffix" id="suffix"
                                     class="form-control  {{ $errors->has('suffix') ? 'is-invalid' : '' }}"
                                     placeholder="ex. Jr. Sr. III" value="{{ $student->suffix }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="sex">Sex <span class="text-danger">*</span></label>
                                 <select name="sex" id="sex"
                                     class="form-select  {{ $errors->has('sex') ? 'is-invalid' : '' }}">
                                     <option value="">--Select--</option>
                                     <option value="male" {{ $student->sex == 'male' ? 'selected' : '' }}>
                                         Male
                                     </option>
                                     <option value="female" {{ $student->sex == 'female' ? 'selected' : '' }}>
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
                                 <input type="text" name="contact_number" id="contact_number"
                                     class="form-control  {{ $errors->has('contact_number') ? 'is-invalid' : '' }}"
                                     placeholder="Contact Number" value="{{ $student->contact_number }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="email">E-mail <span class="text-danger">*</span></label>
                                 <input type="email" name="email" id="email"
                                     class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                     placeholder="Contact Number" value="{{ $student->email }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="birth_date">Birthday <span class="text-danger">*</span></label>
                                 <input type="date" name="birth_date" id="birth_date"
                                     class="form-control  {{ $errors->has('birth_date') ? 'is-invalid' : '' }}"
                                     placeholder="Birthday" value="{{ $student->birth_date }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-4 col-md-12">

                             <div class="form-group">
                                 <label for="birth_place">Birth Place <span class="text-danger">*</span></label>
                                 <input type="text" name="birth_place" id="birth_place"
                                     class="form-control  {{ $errors->has('birth_place') ? 'is-invalid' : '' }}"
                                     placeholder="Birth Place" value="{{ $student->birth_place }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-12 col-md-12">

                             <div class="form-group">
                                 <label for="address">Address <span class="text-danger">*</span></label>
                                 <input type="text" name="address" id="address"
                                     class="form-control  {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                     placeholder="Address" value="{{ $student->address }}">
                                 <div class="invalid-feedback">
                                     This field is required.
                                 </div>
                             </div>
                         </div>

                     </div>

                     <div class="card-footer ">
                         <a href="{{ route('student.dashboard') }}" class="btn btn-outline-danger gap-1"><i
                                 class='bx bx-exit'></i>
                             Cancel</a>
                         <button type="submit" class="btn btn-outline-success gap-1"><i class='bx bx-save'></i>
                             Update</button>
                     </div>
                 </div>

         </form>
     </div>

@endsection