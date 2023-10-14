@extends('layout.contentLayoutMaster')

@section('title', 'Request Timeline')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light"> Request / Status /</span>  {{ $slug }}
    </h5>

    <!-- hide this form if request is approved -->
    <div class="row mb-3">
        <form action="">
            <div class="col-6">

                <div class="card">

                    <h5 class="card-header">Requested Item</h5>

                    <div class="card-body">
                        <div class="row gy-3">

                            <div class="col-4 align-items-center d-flex">
    
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                     name="item-1" id="item-1" checked="">
                                    <label class="form-check-label" for="item-1">
                                        TOR
                                    </label>
                                </div>
                            </div>
                            <div class="col-8">
    
                                <div class="form-group">
                                    <label for="item-1-price">Price</label>
                                    <input type="number" class="form-control" name="item-1-price" 
                                    id="item-1-price">
                                </div>
                            </div>


                            <div class="col-4 align-items-center d-flex">
    
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                     name="item-2" id="item-2" checked="">
                                    <label class="form-check-label" for="item-1">
                                        Certified Good Moral
                                    </label>
                                </div>
                            </div>
                            <div class="col-8">
    
                                <div class="form-group">
                                    <label for="item-2-price">Price</label>
                                    <input type="number" class="form-control" name="item-2-price" 
                                    id="item-2-price">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary float-end mt-3">Approve</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="row">

        <div class="col-12">

            <div class="card">

                <h5 class="card-header">{{ $slug }}</h5>

                <div class="card-body">

                    <ul class="timeline pt-3">

                        <!-- if task is completed, change the following; -->
                        <!-- timeline-item-danger -> timeline-item-primary -->
                        <!-- timeline-indicator-danger -> timeline-indicator-primary -->
                        <!-- uncomment the check-circle icon -->
                        <li class="timeline-item pb-4 timeline-item-primary border-left-dashed">
                            <span class="timeline-indicator-advanced timeline-indicator-primary">
                                <!-- <i class='bx bx-user-pin'></i> -->
                                <i class='bx bxs-check-circle'></i>
                            </span>
                            <div class="timeline-event">
                                <div class="timeline-header border-bottom mb-3">
                                    <h6 class="mb-0">Request Approved</h6>
                                    <span class="text-muted">3rd October</span>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div>
                                        <h6>Item requested</h6>
                                    </div>
                                    <div>
                                        <span>6:30 AM</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                    <ul>
                                        <li>Transcript of Records (TOR) - ₱150</li>
                                        <li>Certified Good Moral - ₱80</li>
                                        <li>Form 137 - ₱350</li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                        
                        <li class="timeline-item pb-4 timeline-item-danger border-left-dashed">
                            <span class="timeline-indicator-advanced timeline-indicator-danger">
                                <i class='bx bx-credit-card'></i>
                                <!-- <i class='bx bxs-check-circle'></i> -->
                            </span>
                            <div class="timeline-event">
                                <div class="timeline-header border-bottom mb-3">
                                    <h6 class="mb-0">Pending Payment</h6>
                                    <span class="text-muted">4th October</span>
                                </div>

                                <p>
                                    Your balance is <b>₱580</b>. This can be paid for with Gcash. Please see the information below.
                                </p>
                                <div class="d-flex flex-wrap">
                                    <div>
                                        <h5>Gcash Information</h5>
                                        <p class="py-0 my-0"><span class="fw-bold">Name:</span> Registrar Gcash</p>
                                        <p class="py-0 my-0"><span class="fw-bold">Gcash #:</span> 09876543210</p>
                                    </div>                                    
                                </div>
                            </div>
                        </li>
                        <li class="timeline-end-indicator">
                            <i class="bx bx-check-circle"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
    </div>

@endsection