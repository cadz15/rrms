@extends('layout.contentLayoutMaster')

@section('title', 'Accounts | List')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Accounts /</span> List
    </h5>

    <div class="row">

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('account.create.user') }}" class="btn btn-primary float-end"> Add User</a>
                    <h5 class="card-title">Accounts List</h5>
                </div>
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show m-2" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-2" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="border-top">
                            <tr>
                                <th>User</th>
                                <th>Name</th>
                                <th>Account Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id_number }}</td>
                                    <td>{{ $user->full_name_last_name_first }}</td>
                                    
                                    @if($user->isAdmin())

                                        <td>
                                            <span class="badge rounded-pill bg-label-primary">
                                                Admin
                                            </span>
                                        </td>
                                    @elseif ($user->isRegistrar())
                                        
                                        <td>
                                            <span class="badge rounded-pill bg-label-success">
                                                Registrar
                                            </span>
                                        </td>
                                    @endif
                                    
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('account.setting', $user->id) }}" title="Show Information"
                                            class="text-primary fs-5">
                                            <i class='bx bx-cog'></i>
                                        </a>
                                        <a href="{{ route('account.delete', $user->id) }}"
                                            title="Delete account" class="text-danger fs-5">
                                            <i class='bx bx-trash'></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Data Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="px-3 pt-3 float-end">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
