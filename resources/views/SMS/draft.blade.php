@extends('layout.contentLayoutMaster')

@section('title', 'SMS')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Admin / SMS /</span> Send a message
    </h5>

    <div class="row">

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Send A Message</h5>

                    <div class="alert alert-primary" role="alert">
                        <i class='bx bx-info-circle'></i> A phone number must start with 63 instead of 0, for example, 639123456789 instead of 09123456789.
                        <br>
                        <i class='bx bx-info-circle'></i> For multiple recipient, separate the numbers with ',' without space, for example, 639123456789,639987654321.
                        <br>
                        <i class='bx bx-info-circle'></i> A single message credit can have a maximum of 160 characters. 
                    </div>
                    <div class="row">
                        
                        <form action="{{ route('sms.send') }}" method="post">
                            @csrf
    
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="phone_numbers">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone_numbers" id="phone_numbers" class="form-control" placeholder="Phone number e.g. 639123456789,639987654321">
                                </div>
                            </div>
                            <div class="col-12 mt-2">                                
                                <div class="form-group">
                                    <label for="message">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>

                            <button class="btn btn-primary mt-2">
                                <i class='bx bx-send'></i> Send
                            </button>
                        </form>
                    </div>
                </div>                
            </div>
        </div>


    </div>

@endsection
