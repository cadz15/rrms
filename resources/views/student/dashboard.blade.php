@extends('layout.contentLayoutStudent')

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

    
        <div class="col-12">
            <div class="card">
                <h5 class="card-title m-4">Active Request</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Reference #</th>
                                <th>Requested Item</th>
                                <th>Status</th>
                                <th>Create at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($requests as $request)
                            <tr>
                                <td>{{ $request->reference_number }}</td>
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
                                <td>{{ $request->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{route('student.request.history', $request->id)}}" class="text-primary fs-5">
                                        <i class='bx bx-show'></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Active Request</td>
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