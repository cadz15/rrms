@extends('layout.contentLayoutMaster')

@section('title', 'Student | Information Form')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Student /</span> Information Form
    </h5>

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Student Information</h5>

                    <div class="col-lg-4 col-md-12">

                        <div class="form-group">
                            <label for="id-number">ID Number <span class="text-danger">*</span></label>
                            <input type="text" name="id-number" id="id-number" class="form-control" placeholder="Student's ID Number">
                            <div class="invalid-feedback">
                                This field is required.
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 gy-2">
                        
                        <div class="divider">
                            <div class="divider-text"><h6>Basic Information</h6></div>
                        </div>
                    

                        <div class="col-lg-4 col-md-12">
    
                            <div class="form-group">
                                <label for="last-name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last-name" id="last-name" class="form-control" placeholder="Last Name">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
    
                        <div class="col-lg-4 col-md-12">
    
                            <div class="form-group">
                                <label for="first-name">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first-name" id="first-name" class="form-control" placeholder="First Name">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
    
                        <div class="col-lg-4 col-md-12">
    
                            <div class="form-group">
                                <label for="middle-name">Middle Name</label>
                                <input type="text" name="middle-name" id="middle-name" class="form-control" placeholder="Middle Name">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">

                            <div class="form-group">
                                <label for="suffix">Suffix</label>
                                <input type="text" name="suffix" id="suffix" class="form-control" placeholder="ex. Jr. Sr. III">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">

                            <div class="form-group">
                                <label for="sex">Sex <span class="text-danger">*</span></label>
                                <select name="sex" id="sex" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">

                            <div class="form-group">
                                <label for="contact-number">Contact # <span class="text-danger">*</span></label>
                                <input type="text" name="contact-number" id="contact-number" class="form-control" placeholder="Contact Number">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">

                            <div class="form-group">
                                <label for="birthday">Birthday <span class="text-danger">*</span></label>
                                <input type="date" name="birthday" id="birthday" class="form-control" placeholder="Birthday">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-12">

                            <div class="form-group">
                                <label for="birth-place">Birth Place <span class="text-danger">*</span></label>
                                <input type="text" name="birth-place" id="birth-place" class="form-control" placeholder="Birth Place">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="form-group">
                                <label for="Addrress">Address <span class="text-danger">*</span></label>
                                <input type="text" name="Addrress" id="Addrress" class="form-control" placeholder="Address">
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
                                <select name="degree" id="degree" class="form-control">
                                    <option value="">--Select Degree/Course--</option>
                                </select>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-12">

                            <div class="form-group">
                                <label for="major">Major <span class="text-danger">*</span></label>
                                <select name="major" id="major" class="form-control">
                                    <option value="">--Select Major--</option>
                                </select>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">

                            <div class="form-group">
                                <label for="date-enrolled">Date Enrolled <span class="text-danger">*</span></label>
                                <input type="date" name="date-enrolled" id="date-enrolled" class="form-control">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">

                            <div class="form-group">
                                <label for="year-level">Year Level <span class="text-danger">*</span></label>
                                <input type="number" name="year-level" id="year-level" class="form-control" placeholder="Year Level">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">

                            <div class="form-group">
                                <label for="is-graduate">Is Graduate</label>
                                <select name="is-graduate" id="is-graduate" class="form-control">
                                    <option value="no">No</option>
                                    <option value="no">Yes</option>
                                </select>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-lg-4 col-md-12">

                            <div class="form-group">
                                <label for="date-graduated">Date Graduated</label>
                                <input type="date" name="date-graduated" id="date-graduated" class="form-control">
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer border-top">
                    <button class="btn btn-success"><i class='bx bx-save'></i> Save</button>
                </div>
            </div>
        </div>
        
    </div>

@endsection