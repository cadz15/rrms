@extends('layout.contentLayoutMaster')

@section('title', 'Account Setting')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Account /</span> Change Password
    </h5>

    <div class="row">

        <div class="col-md-6 col-sm-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Change Password</h5>

                    <form action="" method="post">
                        @csrf
                        <div class="alert alert-danger {{ $errors->has('password') ? '' : 'd-none' }}" role="alert">
                            <ul>
                                @if($errors->has('password'))
                                
                                    @foreach ($errors->get('password') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>


                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session()->get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif


                        <div class="col-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" 
                                name="password" 
                                id="password" 
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                >
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                >
                            </div>
                        </div>
    
                        <button class="btn btn-primary mt-4">Change Password</button>
                    </form>               
                </div>

                
            </div>
        </div>


    </div>

@endsection
