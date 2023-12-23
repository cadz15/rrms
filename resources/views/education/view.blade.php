@extends('layout.contentLayoutMaster')

@section('title', 'Education Create')

@section('content')

    <h5 class="py-3">
        <span class="text-muted fw-light">Education / List / </span> {{ $education->name }}
    </h5>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            
            <div class="card">
                <div class="card-body">
                    <h5>Sub Level / Major Master list</h5>
                    <div class="alert alert-success {{ empty(session('successDeleteMajor')) ? 'd-none' : '' }}" role="alert">
                        Sub Level / Major successfully deleted!
                    </div>
                </div>
                <table class="table table-striped">
                    <thead class="border-top">
                        <tr>
                            <th>Action</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(empty($education->majors))
                            <tr>
                                <td colspan="2">No Data Found!</td>
                            </tr>
                        @endif

                        @foreach ($education->majors as $major)
                            <tr>
                                <td><a href="{{ route('education.setup.major.destroy', cryptor($major->id)) }}" class="text-danger"><i class='bx bx-trash'></i></a></td>
                                <td>{{ $major->name }}</td>
                            </tr>                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div class="col-md-6 col-sm-12">
            
            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">                           

                            <form action="{{ route('education.setup.update') }}" method="post">
                                <input type="hidden" name="id_s" value="{{ cryptor($education->id) }}">
                                @csrf
                                <div class="alert alert-success {{ empty(session('successLevel')) ? 'd-none' : '' }}" role="alert">
                                    Education Level successfully updated!
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="education_level">Education Level <span class="text-danger">*</span></label>
                                        <input type="text" 
                                        name="education_level" 
                                        id="education_level" 
                                        class="form-control {{ $errors->has('education_level')? 'is-invalid' : '' }} " 
                                        placeholder="Education Level"
                                        value="{{ $education->name }}"
                                        required
                                        >
                                        <div class="invalid-feedback">
                                            {{ $errors->first('education_level') }}
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-outline-primary col-3 mt-2"><i class='bx bx-save' ></i> Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('education.setup.major.store')}}" method="post">
                                <input type="hidden" name="id_e" value="{{ cryptor($education->id) }}">
                                @csrf
                                <div class="alert alert-success {{ empty(session('successMajor')) ? 'd-none' : '' }}" role="alert">
                                    Sub Level / Major successfully added!
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="education_level">Sub Level / Major <span class="text-danger">*</span></label>
                                        <input type="text" 
                                        name="major"
                                        id="major"
                                        class="form-control {{ $errors->has('major')? 'is-invalid' : '' }}" 
                                        placeholder="Sub Level / Major"
                                        value="{{ old('major') }}"
                                        required
                                        >
                                        <div class="invalid-feedback">
                                            {{ $errors->first('major') }}
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary col-3 mt-2"><i class='bx bx-plus'></i> Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection