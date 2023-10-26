@extends('layout.contentLayoutMaster')

@section('title', 'Student | Decline')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Student /</span> Decline
    </h5>

    <div class="row">

        <div class="col-12">
            <div class="card  card-border-shadow-danger">
            
                <!-- Add form action here -->
                <form action="" method="post"> 

                    <div class="card-body">
                        <div class="text-center">
    
                            <i class='bx bx-error-circle text-danger' style="font-size: 8rem;"></i>
                            <p class="fs-1">Are you sure?</p>
                            <br>
                            <p class="fs-5">Do you really want to delete these record? This process cannot be undone.</p>
                        </div>
                    
                        <input 
                        type="text" 
                        class="form-control form-control-lg {{ $errors->has('reason') ? 'is-invalid' : '' }}" 
                        name="reason" 
                        id="reason" 
                        placeholder="Please provide a reason."
                        >
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg me-3">Cancel</a>
                        <button type="submit" class="btn btn-danger btn-lg ms-4">Delete</button>
                    </div>
                </form>

            </div>            
        </div>
        
    </div>

@endsection