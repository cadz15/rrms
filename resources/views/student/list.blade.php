@extends('layout.contentLayoutMaster')

@section('title', 'Student | List')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Student /</span> List
    </h5>

    <div class="row">

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Student List</h5>
                </div>
                <div class="table-responsive">

                    <div class="px-3 pb-3 float-end d-flex align-items-center gap-3">
                        <div>
                            <button class="btn btn-outline-secondary">
                                <i class='bx bx-filter-alt'></i>
                            </button>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="search" class="form-control" id="search" placeholder="Search">
                            <span class="input-group-text cursor-pointer" id="search-icon">
                                <i class='bx bx-search-alt'></i>
                            </span>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead class="border-top">
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Level</th>
                                <th>Course</th>
                                <th>Is Graduate</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td>{{ $student->id_number }}</td>
                                <td>{{ $student->fullName() }}</td>
                                <td>{{ $student->educations->last()?->level ?? '-' }}</td>
                                <td>{{ $student->educations->last()?->degree ?? '-' }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-label-success">{{ $student->educations->last()?->prettyIsGraduated() }}</span>
                                </td>
                                <td>
                                    <a href="/student/information" class="text-primary fs-5">
                                        <i class='bx bx-show'></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="px-3 pt-3 float-end">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
