@extends('layout.contentLayoutMaster')

@section('title', 'Sample Design')

@section('content')

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Congratulations John! 🎉</h5>
                    <p class="mb-4">You have done <span class="fw-medium">72%</span> more sales today. Check your new badge in your profile.</p>

                    <a href="#" class="btn btn-sm btn-label-primary">View Badges</a>

                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sample Table Design</h5>
                    <p>
                        Please refer 
                        <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/tables-basic.html">Tables</a>
                        for more details
                    <p>
                </div>
                <div class="table-responsive">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>Juan Dela Cruz</td>
                                <td>20</td>
                                <td>2030</td>
                            </tr>
                            <tr>
                                <td>Juan Dela Cruz</td>
                                <td>20</td>
                                <td>2030</td>
                            </tr>
                            <tr>
                                <td>Juan Dela Cruz</td>
                                <td>20</td>
                                <td>2030</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sample Form</h5>
                    <p>
                        Please refer 
                        <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/form-layouts-vertical.html">Forms</a>
                        for more details
                    <p>

                    <h6>1. Account Details</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="multicol-email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="multicol-email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="multicol-email2">
                                    <span class="input-group-text" id="multicol-email2">@example.com</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mx-n4">

                    
                    <h6>2. About</h6>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="about-me" class="form-label">Description</label>
                            <textarea name="about-me" id="about-me" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection