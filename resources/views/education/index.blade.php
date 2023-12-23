@extends('layout.contentLayoutMaster')

@section('title', 'Education Master list')

@section('page-styles')

    <style>
        #search-btn {
            padding: 0;
            margin: 0;
            border: none;
            background-color: transparent !important;
        }
    </style>

@endsection

@section('content')

    <h5 class="py-3">
        <span class="text-muted fw-light">Education /</span> List
    </h5>

    <div class="row">
        <div class="col-12">
            
            <div class="card">
                <div class="card-body">
                    <h5>Education Master List</h5>                    
                </div>
                <div class="table-responsive">
                    <a href="{{ route('education.setup.create') }}" class="btn btn-primary ms-3"><i class='bx bx-plus'></i> Add Education Level</a>
                    <div class="px-3 pb-3 float-end d-flex align-items-center gap-3">
                        <!-- <div>
                            <button class="btn btn-outline-secondary">
                                <i class='bx bx-filter-alt'></i>
                            </button>
                        </div> -->
                        <form action="{{ route('education.setup.index') }}" method="get">

                            <div class="input-group input-group-merge">
                                <input type="search" name="search" class="form-control" id="search" placeholder="Search" value="{{ $search }}">
                                <span class="input-group-text cursor-pointer" id="search-icon">
                                    <button id="search-btn"><i class='bx bx-search-alt'></i></button>
                                </span>
                            </div>
                        </form>
                    </div>

                    <table class="table table-striped">
                        <thead class="border-top">
                            <tr>
                                <th>Action</th>
                                <th>Education Level</th>
                                <th>Sub Level / Major</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($educations->isEmpty()) 
                                <tr>
                                    <td colspan="3" class="text-center">No Data Found!</td>
                                </tr>
                            @endif
                            @foreach ($educations as $education)
                                <tr>
                                    <td><a href="{{ route('education.setup.view', cryptor($education->id)) }}"><i class='bx bx-edit'></i></a></td>
                                    <td>{{ $education->name }}</td>
                                    <td>{{ implode(', ', $education->majors->pluck('name')->toArray())}}</td>
                                    <!-- <td>{{ mb_strimwidth(implode(', ', $education->majors->pluck('name')->toArray()), 0, 50, '...') }}</td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-3 pt-3 float-end">
                        {{ $educations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection