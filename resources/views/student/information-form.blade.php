{{-- @extends('layout.contentLayoutMaster')

@section('title', 'Student | Information Form')

@section('content')
    <h5 class="py-3">
        <span class="text-muted fw-light">Student /</span> Information

    </h5>

    <x-form.information 
        :data="$student"
        formURL="http://localhost/information"
        formTitle="Student Information"
        cancelURL="{{ route('student.decline') }}"
        cancelText="Decline"
        :cancelVisible="true"
    ></x-form.information>
@endsection --}}
@extends('layout.contentLayoutMaster')

@section('title', 'Student | Information Form')

@section('content')
<div class="py-3">
    <span class="text-muted fw-light">Student /</span> Information
</div>

<div class="row justify-content-center">
    <div class="col-md-10" >
        <form action="" method="post">
           
            <div class="mb-3">
                <label for="studentNumber" class="form-label">Student Number:</label>
                <input type="text" class="form-control" id="studentNumber" value="{{ $student->student_number }}" readonly>
            </div>

            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lastName" value="{{ $student->last_name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="firstName" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="firstName" value="{{ $student->first_name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="middleName" class="form-label">Middle Name:</label>
                <input type="text" class="form-control" id="middleName" value="{{ $student->middle }}" readonly>
            </div>

            <div class="mb-3">
                <label for="suffix" class="form-label">Suffix:</label>
                <input type="text" class="form-control" id="suffix" value="{{ $student->suffix }}" readonly>
            </div>

            <div class="mb-3">
                <label for="sex" class="form-label">Sex:</label>
                <input type="text" class="form-control" id="sex" value="{{ $student->sex }}" readonly>
            </div>

            <div class="mb-3">
                <label for="contactNumber" class="form-label">Contact Number:</label>
                <input type="text" class="form-control" id="contactNumber" value="{{ $student->contact_number }}" readonly>
            </div>

            <div class="mb-3">
                <label for="birthDate" class="form-label">Birth Date:</label>
                <input type="text" class="form-control" id="birthDate" value="{{ $student->birth_date }}" readonly>
            </div>

            <div class="mb-3">
                <label for="birthPlace" class="form-label">Birth Place:</label>
                <input type="text" class="form-control" id="birthPlace" value="{{ $student->birth_place }}" readonly>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" class="form-control" id="address" value="{{ $student->address }}" readonly>
            </div>

            <div class="mb-3">
                <label for="degree" class="form-label">Degree/Course:</label>
                <input type="text" class="form-control" id="degree" value="{{ $student->degree }}" readonly>
            </div>

            <div class="mb-3">
                <label for="major" class="form-label">Major:</label>
                <input type="text" class="form-control" id="major" value="{{ $student->major }}" readonly>
            </div>

            <div class="mb-3">
                <label for="dateEnrolled" class="form-label">Date Enrolled:</label>
                <input type="text" class="form-control" id="dateEnrolled" value="{{ $student->date_enrolled }}" readonly>
            </div>

            <div class="mb-3">
                <label for="yearLevel" class="form-label">Year Level:</label>
                <input type="text" class="form-control" id="yearLevel" value="{{ $student->year_level }}" readonly>
            </div>

            <div class="mb-3">
                <label for="isGraduated" class="form-label">Is Graduate:</label>
                <input type="text" class="form-control" id="isGraduated" value="{{ $student->is_graduated }}" readonly>
            </div>

            <div class="mb-3">
                <label for="dateGraduated" class="form-label">Date Graduated:</label>
                <input type="text" class="form-control" id="dateGraduated" value="{{ $student->date_graduated }}" readonly>
            </div>

            <!-- Decline Button -->
            <a href="{{ route('student.decline') }}" class="btn btn-outline-danger">Decline</a>

            <!-- Save Button -->
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>
@endsection