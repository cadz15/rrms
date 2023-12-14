@extends('layout.contentLayoutMaster')

@section('title', 'Student | Decline')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Items /</span> Confirm Delete
    </h5>

    <div class="row">

        <div class="col-12">
            <div class="card  card-border-shadow-danger">
            
                <!-- Add form action here -->
                <form action="{{ route('item.setup.destroy', $id) }}" method="post"> 
                    @csrf
                    <div class="card-body">
                        <div class="text-center">
    
                            <i class='bx bx-error-circle text-danger' style="font-size: 8rem;"></i>
                            <p class="fs-1">Are you sure?</p>
                            <br>
                            <p class="fs-5">Do you really want to delete this item? This process cannot be undone.</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <a href="{{ route('item.setup.index') }}" class="btn btn-secondary btn-lg me-3">Cancel</a>
                        <button type="submit" class="btn btn-danger btn-lg ms-4">Delete!</button>
                    </div>
                </form>

            </div>            
        </div>
        
    </div>

@endsection