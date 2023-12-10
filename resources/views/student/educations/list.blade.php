@extends('layout.contentLayoutMaster')

@section('title', 'Education Background | List')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Student / {{ request('id') }} / Education Background /</span> List
    </h5>

    <div class="row">

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Education Background List</h5>
                </div>
                <div class="table-responsive">

                    <div class="px-3 pb-3 float-end d-flex align-items-center gap-3">
                        <div>
                            <a class="btn btn-outline-primary"
                                href="{{ route('educations.create', ['id' => request('id')]) }}">
                                <i class='bx bx-plus'></i>
                            </a>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead class="border-top">
                            <tr>
                                <th>Education Level</th>
                                <th>Major</th>
                                <th>Year Level</th>
                                <th>Year Start</th>
                                <th>Year End</th>
                                <th>Is Graduate</th>
                                <th></th>
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
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('educations.show', ['id' => request('id'), 'educationId' => $education->id]) }}"
                                            title="Show Information" class="text-primary fs-5">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        <form
                                            action="{{ route('educations.delete', ['id' => request('id'), 'educationId' => $education->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Education Background"
                                                class="text-danger fs-5 border-0 bg-transparent">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
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
