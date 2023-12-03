@extends('layout.contentLayoutMaster')

@section('title', 'Education Create')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Education / List / </span> Create
    </h5>

    <div class="row">

        <div class="col-6">
            <div class="card  card-border-shadow-primary">
            
                <!-- Add form action here -->
                <form action="{{ route('education.store') }}" method="post"> 
                    @csrf
                    <div class="card-body">
                        <div class="text-center">
    
                            <p class="fs-5">Enter Education Level Name</p>
                        </div>
                    
                        <input 
                        type="text" 
                        class="form-control form-control-lg {{ $errors->has('education_level') ? 'is-invalid' : '' }}" 
                        name="education_level" 
                        id="education_level" 
                        placeholder="Educaton Level"
                        >
                        <div class="invalid-feedback">
                            {{ $errors->first('education_level') }}
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg ms-4">Create</button>
                    </div>
                </form>

            </div>            
        </div>
        
    </div>

@endsection