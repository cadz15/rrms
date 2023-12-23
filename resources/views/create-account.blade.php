@extends('layout.contentLayoutMaster')

@section('title', 'Account Setting')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Account /</span> Create Account
    </h5>

    <div class="row">

        <div class="col-md-6 col-sm-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Create Account</h5>

                    <form action="{{ route('account.create.information') }}" method="post">
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


                        <div class="row gy-2">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                    name="first_name" 
                                    id="first_name" 
                                    class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                    placeholder="First Name"
                                    value="{{ old('first_name') }}"
                                    >
                                    <div class="invalid-feedback">
                                        {{ $errors->first('first_name') }}
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" 
                                    name="middle_name" 
                                    id="middle_name" 
                                    class="form-control {{ $errors->has('middle_name') ? 'is-invalid' : '' }}"
                                    placeholder="Middle Name"
                                    value="{{ old('middle_name') }}"
                                    >
                                    <div class="invalid-feedback">
                                        {{ $errors->first('middle_name') }}
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                    name="last_name" 
                                    id="last_name" 
                                    class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                    placeholder="Last Name"
                                    value="{{ old('last_name') }}"
                                    >
                                    <div class="invalid-feedback">
                                        {{ $errors->first('last_name') }}
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" 
                                    name="suffix" 
                                    id="suffix" 
                                    class="form-control {{ $errors->has('suffix') ? 'is-invalid' : '' }}"
                                    placeholder="e.g. Jr. Sr."
                                    value="{{ old('suffix') }}"
                                    >
                                    <div class="invalid-feedback">
                                        {{ $errors->first('suffix') }}
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-4">
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="user_name">User Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                    name="user_name" 
                                    id="user_name" 
                                    class="form-control {{ $errors->has('user_name') ? 'is-invalid' : '' }}"
                                    placeholder="User Name"
                                    value="{{ old('user_name') }}"
                                    >
                                    <div class="invalid-feedback">
                                        {{ $errors->first('user_name') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="account_type">Account Type <span class="text-danger">*</span></label>
                                    <select type="text" 
                                    name="account_type" 
                                    id="account_type" 
                                    class="form-control {{ $errors->has('account_type') ? 'is-invalid' : '' }}"
                                    placeholder="User Name"
                                    >
                                        <option value="">Select Type</option>
                                        <option value="1" {{ old('account_type') == 1 ? 'selected' : '' }} >Admin</option>
                                        <option value="2" {{ old('account_type') == 2 ? 'selected' : '' }} >Registrar</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('account_type') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" 
                                    name="password" 
                                    id="password" 
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    placeholder="Password"
                                    >
                                </div>
                            </div>
    
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" 
                                    name="password_confirmation" 
                                    id="password_confirmation" 
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    placeholder="Password Confirmation"
                                    >
                                </div>
                            </div>
                            
                        </div>
    
                        <button class="btn btn-primary mt-4">Create User</button>
                    </form>               
                </div>

                
            </div>
        </div>
        
        

    </div>

@endsection
