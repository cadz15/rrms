@extends('layout.contentLayoutMaster')

@section('title', 'Request Timeline')

@section('page-styles')

<style>
    .bg-muted {
        background-color: #F8F8F8;
    }

    .loading-livewire {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        border: 1px solid black;
        margin: 0;
        padding: 0;
        left: 0;
        text-align: center;
        display: flex;
        align-items: center;
        background-color: #000;
        opacity: 0.5;
    }
</style>
@endsection

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light"> Request Item /</span>  {{ $request->user->full_name_last_name_first }}
    </h5>

    @if($request->status == App\Enums\RequestStatusEnum::DECLINED->value)
        <div class="alert alert-danger" role="alert">
            Request is <b>declined!</b>
        </div>
    @endif

    @if(session()->has('error_status'))
        <div class="alert alert-warning" role="alert">
            {{session()->get('error_status')}}
        </div>
    @endif
    <!-- hide this form if request is approved -->
    <div class="row mb-3">
        <!-- <form action=""> -->           
        <div class=" col-8">
            <div class="card">
                <h5 class="card-header border-bottom mb-2">Requested Item</h5>
                <div class="card-body pb-0">
                @if($request->status == App\Enums\RequestStatusEnum::PENDING_REVIEW->value)
                    <livewire:request-items :request="$request" />
                @else
                    <div class="d-flex justify-content-between flex-wrap mb-2">
                        <ul>
                            @foreach ($request->requestItems as $item)
                                <li>{{$item->quantity}}x {{$item->item_name}} - ₱ {{ $item->quantity * $item->price }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="float-end d-flex flex-column">
                        <h6 class="m-0 text-center">Total</h6>
                        <div class="text-end "><h5 class="text-primary">₱ {{ number_format((float) $total) }}</h5></div>
                    </div>


                    @if(empty($paidHistory) && !empty($approvedHistory))
                        <form action="{{route('request.force.declined')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$request->id}}">
                            <button class="btn btn-outline-danger col-12 my-2"> Decline Request </button>
                        </form>
                    @endif


                    @if(empty($pickupedHistory) && !empty($workedOnRequestHistory))
                        <form action="{{route('request.mark.forpickup')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$request->id}}">
                            <button class="btn btn-outline-success col-12 my-2"> Ready for pickup </button>
                        </form>
                    @endif

                    @if(!empty($pickupedHistory) && !empty($workedOnRequestHistory) && empty($completedHistory))
                        <form action="{{route('request.mark.completed')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$request->id}}">
                            <button class="btn btn-outline-success col-12 my-2"> Mark as Complete </button>
                        </form>
                    @endif
                @endif
                </div>
            </div>
        </div>
        @if($request->status == App\Enums\RequestStatusEnum::PENDING_REVIEW->value)
            <livewire:add-item :educations="$educations" :requestableItems="$requestableItems" :request="$request" />
        @endif
        <!-- </form> -->
    </div>

    @if(!in_array($request->status, [App\Enums\RequestStatusEnum::PENDING_REVIEW->value, App\Enums\RequestStatusEnum::DECLINED->value]))
        <div class="row">

            <div class="col-12">

                <div class="card">

                    <h5 class="card-header">{{ $request->user->full_name_last_name_first }}</h5>

                    <div class="card-body">

                        <ul class="timeline pt-3">

                            <!-- if task is completed, change the following; -->
                            <!-- timeline-item-danger -> timeline-item-primary -->
                            <!-- timeline-indicator-danger -> timeline-indicator-primary -->
                            <!-- uncomment the check-circle icon -->
                            <li class="timeline-item pb-4 
                            {{ !empty($approvedHistory) && empty($declinedHistory) ? 'timeline-item-success' : ''}}
                            {{ empty($approvedHistory) && empty($declinedHistory) ? 'timeline-item-primary' : ''}}
                            {{ empty($approvedHistory) && !empty($declinedHistory) ? 'timeline-item-danger' : ''}}
                             border-left-dashed">
                                <span class="timeline-indicator-advanced
                                {{ !empty($approvedHistory) && empty($declinedHistory) ? 'timeline-indicator-success' : ''}}
                                {{ empty($approvedHistory) && empty($declinedHistory) ? 'timeline-indicator-primary' : ''}}
                                {{ empty($approvedHistory) && !empty($declinedHistory) ? 'timeline-indicator-danger' : ''}}
                                ">
                                    
                                    @if(empty($declinedHistory) && !empty($approvedHistory))
                                        <i class='bx bxs-check-circle'></i>
                                    @elseif(empty($declinedHistory) && empty($approvedHistory))
                                        <i class='bx bx-user-pin'></i>
                                    @else 
                                        <i class='bx bx-x-circle'></i>
                                    @endif
                                </span>
                                <div class="timeline-event">
                                    <div class="timeline-header border-bottom mb-3">
                                        @if(empty($declinedHistory) && !empty($approvedHistory))
                                        <h6 class="mb-0">Request Approved</h6>
                                        <span class="text-muted">{{ $approvedHistory->formatted_date_completed }}</span>
                                        @elseif(empty($declinedHistory) && empty($approvedHistory))
                                            <h6 class="mb-0">Pending Approval</h6>
                                            <span class="text-muted">{{ date('jS F') }}</span>
                                        @else 
                                            <h6 class="mb-0">Request Declined</h6>
                                            <span class="text-muted">{{ $declinedHistory->formatted_date_completed }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div>
                                            <h6>Item Requested</h6>
                                        </div>
                                        <!-- <div>
                                            <span>6:30 AM</span>
                                        </div> -->
                                    </div>

                                    <div class="d-flex justify-content-between flex-wrap mb-2">
                                        <ul>
                                            @foreach ($request->requestItems as $item)
                                                <li>{{$item->quantity}}x {{$item->item_name}} - ₱ {{ $item->quantity * $item->price }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            @if(!empty($approvedHistory))

                                <li class="timeline-item pb-4
                                {{ !empty($paidHistory) ? 'timeline-item-success' : 'timeline-item-primary'}}
                                border-left-dashed">
                                    <span class="timeline-indicator-advanced 
                                    {{ !empty($paidHistory) ? 'timeline-indicator-success' : 'timeline-indicator-primary'}}
                                    ">
                                        @if(!empty($paidHistory))
                                            <i class='bx bxs-check-circle'></i>
                                        @else
                                            <i class='bx bx-credit-card-front'></i>
                                        @endif
                                        
                                    </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header border-bottom mb-3">
                                            @if(!empty($paidHistory))
                                                <h6 class="mb-0">Payment successful</h6>
                                                <span class="text-muted">{{ $paidHistory->formatted_date_completed }}</span>
                                            @else
                                                <h6 class="mb-0">Pending Payment</h6>
                                                <span class="text-muted">{{ date('jS F') }}</span>
                                            @endif
                                        </div>

                                        @if(!empty($paidHistory) && !empty($workedOnRequestHistory))
                                            <p>
                                                You have successfully paid the balance <b>₱{{ number_format((float) $total) }}</b>.
                                            </p>
                                        @else 

                                            <p>
                                                Your balance is <b>₱{{ number_format((float) $total) }}</b>. To pay click the link below and your reference number is <b class="text-info"><em>{{ $request->reference_number }}</em></b>.
                                            </p>

                                            <a href="{{ $request->checkout_url }}" target="_blank">{{ $request->checkout_url }}</a>
                                        @endif
                                        
                                    </div>
                                </li>
                            @endif

                            @if(!empty($paidHistory))

                                <li class="timeline-item pb-4
                                {{ !empty($pickupedHistory) ? 'timeline-item-success' : 'timeline-item-primary'}}
                                border-left-dashed">
                                    <span class="timeline-indicator-advanced 
                                    {{ !empty($pickupedHistory) ? 'timeline-indicator-success' : 'timeline-indicator-primary'}}
                                    ">
                                        @if(!empty($pickupedHistory))
                                            <i class='bx bxs-check-circle'></i>
                                        @else
                                            <i class='bx bx-credit-card-front'></i>
                                        @endif
                                        
                                    </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header border-bottom mb-3">
                                            @if(!empty($pickupedHistory) && !empty($workedOnRequestHistory))
                                                <h6 class="mb-0">Pickup successful</h6>
                                                <span class="text-muted">{{ $pickupedHistory->formatted_date_completed }}</span>
                                            @elseif(empty($pickupedHistory) && !empty($workedOnRequestHistory))

                                                <h6 class="mb-0">Processing the request</h6>
                                                <span class="text-muted">{{ date('jS F') }}</span>
                                            @else
                                                <h6 class="mb-0">Pending for pickup</h6>
                                                <span class="text-muted">{{ date('jS F') }}</span>
                                            @endif
                                        </div>

                                        @if(!empty($pickupedHistory))
                                            <p>
                                                The requested item have been successfully picked up! This request is completed 🎉
                                            </p>
                                        @elseif(empty($pickupedHistory) && !empty($workedOnRequestHistory))
                                            <p>
                                                The registrar is working on your request. You will receive a text message when your request is ready for pickup.
                                            </p>
                                        @else
                                            <p>
                                                The requested items are ready for pickup!
                                            </p>
                                        @endif

                                    </div>
                                </li>
                            @endif


                            <li class="timeline-end-indicator 
                            {{ !empty($completedHistory) ? 'timeline-item-success' : 'timeline-item-primary'}}
                            ">
                                @if(!empty($completedHistory))
                                <i class='bx bxs-check-circle'></i>
                                @else
                                <i class="bx bx-check-circle"></i>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection