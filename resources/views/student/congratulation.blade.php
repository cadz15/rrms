@extends('layout.contentLayoutMaster')

@section('title', 'Student | Create Successful')


@section('content')
<div class="container-xxl">

    <div class="row">

        <div class="col-lg-8 offset-lg-2 col-md-12 mt-4">
            <div class="card  card-border-shadow-success">
            

                    <div class="card-body">
                        <div class="text-center" style="text-align: center">
    
                            <i class='bx bx-smile text-success' style="font-size: 8rem;"></i>
                            <p class="fs-1">Create Successful 🎉</p>
                            <br>
                            <p class="fs-5">The student successfully created. Do you to view the list of students?</p>
                        </div>
                    
                        <div class="d-flex justify-content-center" style="gap: 3rem;">
                            <a href="{{route('students.index')}}" class="btn btn-primary">Yes</a>
                            <a href="{{route('student.create.form')}}" class="btn btn-secondary">No</a>
                        </div>
                    </div>

            </div>            
        </div>
        
    </div>

</div>
@endsection