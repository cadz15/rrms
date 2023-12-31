@extends('layout.contentLayoutMaster')

@section('title', 'SMS')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Admin /</span> SMS
    </h5>

    <div class="row">

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Message List</h5>
                </div>

                <form action="" method="post">
                    @csrf
                    <div class="px-3 pb-3 float-end d-flex align-items-center gap-3">
                        <div>
                            <span>Current Balance : <em class="text-primary">{{ number_format($balance['credit_balance']) }}</em></span>
                        </div>
                        <button type="submit" class="btn btn-outline-primary"><i class='bx bx-refresh'></i> Refresh</button>
                    </div>
                </form>
                               
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="border-top">
                            <tr>
                                <th>Phone Number</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($messages as $message)
                            <tr>
                                <td>{{ $message->recipient }}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ date('F j, Y, g:i a', strtotime($message->created_at)) }}</td>
                                <td>
                                    @if($message->status == 'Sent') 
                                        <span class="badge rounded-pill bg-label-success">{{ $message->status }}</span>
                                    @else
                                        <span class="badge rounded-pill bg-label-secondary">{{ $message->status }}</span>                                    
                                    @endif
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
                    {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
