@extends('layout.contentLayoutStudent')

@section('title', 'Educations')


@section('content')

    <h5 class="py-3">
        <span class="text-muted fw-light"> Educations </span>
    </h5>

    
    <div class="row">

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Education Background List</h5>
                </div>
                <div class="table-responsive">
                    
                    <table class="table table-striped">
                        <thead class="border-top">
                            <tr>
                                <th>Education Level</th>
                                <th>Major</th>
                                <th>Year Level</th>
                                <th>Year Start</th>
                                <th>Year End</th>
                                <th>Is Graduate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($educations as $education)
                                <tr>
                                    <td>{{ $education->major->educationLevel->name }}</td>
                                    <td>{{ $education->major->name }}</td>
                                    <td>{{ $education->year_level ?? '-' }}</td>
                                    <td>{{ $education->year_start ?? '-' }}</td>
                                    <td>{{ $education->year_end ?? '-' }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill bg-label-success">{{ $education->prettyIsGraduated() }}</span>
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
                        {{ $educations->links() }}
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection