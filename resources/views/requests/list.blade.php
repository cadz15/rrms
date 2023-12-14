@extends('layout.contentLayoutMaster')

@section('title', 'Request List')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Request /</span> List
    </h5>

    <div class="row">

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Request List</h5>
                </div>

                <form action="" method="get">
                    <div class="px-3 pb-3 float-end d-flex align-items-center gap-3">

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class='bx bx-filter-alt'></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="mt-2 px-2">
                                    <select name="filter_status" id="filter_status" class="form-select">
                                        <option value="" {{ is_null($filterStatus) ? 'selected': '' }}>Request Status</option>
                                        @foreach ($statuses as $status)
                                            <option 
                                            value="{{ $status['value'] }}"
                                            @if($filterStatus == $status['value'])
                                             selected
                                            @endif
                                            >
                                                {{ $status['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="px-2">
                                    <button type="submit" class="btn btn-success w-100 text-center">Filter</button>
                                </li>
                            </ul>
                        </div>
                        <!-- <div>
                            <button class="btn btn-outline-secondary">
                                <i class='bx bx-filter-alt'></i>
                            </button>
                        </div> -->
                        <div class="input-group input-group-merge">
                            <input type="search" class="form-control" name="search" id="search" placeholder="Search" value="{{ $search }}">
                            <span class="input-group-text cursor-pointer" id="search-icon">
                                <i class='bx bx-search-alt'></i>
                            </span>
                        </div>
                    </div>
                </form>

                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="border-top">
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <!-- <th>Course</th> -->
                                <!-- <th>Is Graduate</th> -->
                                <th>Requested Item</th>
                                <th>Status</th>
                                <th></th>
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

                    <div class="px-3 pt-3 float-end">
                    {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
