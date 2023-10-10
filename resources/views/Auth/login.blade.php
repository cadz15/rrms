@extends('layout.contentLayoutFull')

@section('title', 'Login')
@section('content')

<div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="{{ asset('img/boy-with-rocket-light.png') }}" class="img-fluid" alt="Login image" width="700" data-app-dark-img="illustrations/boy-with-rocket-dark.png" data-app-light-img="illustrations/boy-with-rocket-light.png">
            </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-5">
                        <a href="#" class="app-brand-link">
                            <span class="app-brand-logo">
                                <img src="https://rssoncr.psa.gov.ph/sites/default/files/ocrg_new_logo%20copy_0.png" alt="logo"
                                class="">
                            </span>
                            <span class="app-brand-text menu-text fw-bolder ms-2">RRMS</span>
                        </a>

                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">Welcome to RRMS! 👋</h4>
                    <p class="mb-4">Please sign-in to your account</p>

                    <form id="formAuthentication" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('auth.login')}}" method="POST" novalidate="novalidate">
                        @csrf
                        <div class="mb-3 fv-plugins-icon-container">
                            <label for="email" class="form-label">Username</label>
                            <input type="text" class="form-control" id="email" name="email-username" placeholder="Enter your email or username" autofocus="">
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                        </div>
                        <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                                <a href="#">
                                    <small>Forgot Password?</small>
                                </a>
                            </div>
                            <div class="form-group has-validation">
                                <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                                <!-- <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span> -->
                            </div>
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember-me">
                            <label class="form-check-label" for="remember-me">
                                Remember Me
                            </label>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100">
                            Sign in
                        </button>
                        <input type="hidden">
                    </form>
                </div>
            </div>
            <!-- /Login -->
        </div>
      </div>
    </div>

    <!-- / Content -->


@endsection