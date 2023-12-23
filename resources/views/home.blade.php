@extends('layout.contentLayoutMaster')

@section('title', 'Dashboard')

@section('content')

    <div class="row">

    
        
        <div class="col-12  mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Good Day {{ ucwords(auth()->user()->last_name) }}! 🎉</h5>
                    <p class="mb-4">Welcome to Bato Institute of Science and Technology - RRMS</p>

                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body">
                            <h6 class="card-title mb-4 text-nowrap">Total Student</h6>

                            <h5 class="card-title text-primary mb-4">{{ number_format($totalStudent) }}</h5>

                            <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary ">View Students</a>
                        </div>
                    </div>
                    <div class="col-5 pt-3 ps-0">
                        <img src="{{ asset('img/total-student.png') }}" width="140" height="140" class="rounded-start" alt="View Sales">
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 col-lg-4 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body">
                            <h6 class="card-title mb-4 text-nowrap">Total Request</h6>
                            <h4 class="card-title text-nowrap mb-2">{{ number_format($totalRequest) }}</h4>
                            
                            <a href="{{ route('requests.list-web') }}" class="btn btn-sm text-primary ">View Requests</a>
                        </div>
                    </div>
                    <div class="col-5 pt-3 ps-0">
                        <img src="{{ asset('img/total-request.png') }}" width="130" height="140" class="rounded-start" alt="View Sales">
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 col-lg-4 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body">
                            <h6 class="card-title mb-4 text-nowrap">Pending Requestor</h6>
                            <h4 class="card-title text-nowrap mb-2">{{ number_format($pendingRequestor) }}</h4>
                            
                            <a href="{{ route('requestors.list') }}" class="btn btn-sm text-warning ">View Requestors</a>
                        </div>
                    </div>
                    <div class="col-5 pt-3 ps-0">
                        <img src="{{ asset('img/student scan.png') }}" width="140" height="140" class="rounded-start" alt="View Sales">
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="card">
                <h5 class="card-title m-4">Active Request</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Requested Item</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($requests as $request)
                            <tr>
                                <td>{{ $request->user->id_number }}</td>
                                <td>{{ $request->user->full_name_last_name_first }}</td>
                                <!-- <td>BSCrim</td> -->
                                <!-- <td>
                                    <span class="badge rounded-pill bg-label-success">Yes</span>
                                </td> -->
                                <td>
                                    {{ implode(', ', $request->requestItems->pluck('item_name')->toArray()) }}
                                </td>
                                <td>
                                    
                                    @if ($request->status == App\Enums\RequestStatusEnum::PENDING_REVIEW->value)

                                        <span class="badge rounded-pill bg-label-secondary">Pending Review</span>
                                    @elseif ($request->status == App\Enums\RequestStatusEnum::PENDING_PAYMENT->value)

                                        <span class="badge rounded-pill bg-label-warning">Pending Payment</span>
                                    @elseif ($request->status == App\Enums\RequestStatusEnum::FOR_PICK_UP->value)

                                        <span class="badge rounded-pill bg-label-primary">For pickup</span>
                                    @elseif ($request->status == App\Enums\RequestStatusEnum::WORKING_ON_REQUEST->value)

                                        <span class="badge rounded-pill bg-label-primary">Working on request</span>
                                    @elseif ($request->status == App\Enums\RequestStatusEnum::DECLINED->value)

                                        <span class="badge rounded-pill bg-label-danger">Declined</span>
                                    @elseif ($request->status == App\Enums\RequestStatusEnum::COMPLETED->value)

                                        <span class="badge rounded-pill bg-label-success">Completed</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="/requests/history/{{ $request->id }}" class="text-primary fs-5">
                                        <i class='bx bx-show'></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-3 pt-3 float-end">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>


        

@endsection