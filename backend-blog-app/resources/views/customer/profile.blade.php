
@extends('customer.layouts.app')

@push('css')

<style>
    .navbar {
        margin-bottom: 0px;
    }
    .navbar-nav {
        flex-direction: inherit;
    }

    .login-block .auth-box {
        margin: 20px auto 0 auto;
        max-width: 450px;
    }

    .card {
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 20px 0 rgb(69 90 100 / 8%);
        box-shadow: 0 1px 20px 0 rgb(69 90 100 / 8%);
        border: none;
        margin-bottom: 30px;
        background-color: #fff;
    }

    .login-block {
        padding: 30px 0;
        margin: 0 auto;
        background: #353C4E;
        background-size: cover;
        min-height: 100vh;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .card-block {
        padding: 1.25rem;
    }
    .m-b-20 {
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 1.25em;
    }
    .form-control {
        font-size: 16px;
        border-radius: 2px;
        border: 1px solid #ccc;
    }

    .pcoded[theme-layout="vertical"][vertical-layout="wide"] .pcoded-container {
        width: 100%;
        margin: 0 auto;
    }

    .pcoded[theme-layout="vertical"] .pcoded-container {
        overflow: hidden;
        position: relative;
        margin: 0 auto;
    }

    @media (min-width: 576px){
        .col-sm-12 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endpush

@section('content')

@include('admin.layouts.partials.preloader')

<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        @include('flash::message')
        <section class="login-block">
            <!-- Container-fluid starts -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Authentication card start -->

                        <form method="POST" action="{{ route('profile.update', auth()->user()->id) }}" class="md-float-material form-material">
                            @csrf
                            <div class="text-center">
                                <h2 style="color: #fff">Profile Information</h2>
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">{{ auth()->user()->name }}</h3>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Your Full Name" value="{{ auth()->user()->name }}" required autocomplete="off" autofocus>
                                        <span class="form-bar"></span>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Your Email Address" value="{{ auth()->user()->email }}" required autocomplete="off">
                                        <span class="form-bar"></span>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" placeholder="Your Location Latitude" value="{{ auth()->user()->latitude }}" required autocomplete="off">
                                        <span class="form-bar"></span>
                                        @error('latitude')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" placeholder="Your Location Longitude" value="{{ auth()->user()->longitude }}" required autocomplete="off">
                                        <span class="form-bar"></span>
                                        @error('longitude')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Update Info</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('profile.changePassword', auth()->user()->id) }}" class="md-float-material form-material">
                            @csrf
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Change Password</h3>
                                        </div>
                                    </div>
                                    @if($errors->any())
                                        {!! implode('', $errors->all('<div style="text-align: left; color: red; font-size: 16px; margin-bottom: 20px;">:message</div>')) !!}
                                    @endif
                                    <div class="form-group form-primary">
                                        <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Enter Old Password" required autocomplete="off">
                                        <span class="form-bar"></span>
                                        @error('old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter New Password" required autocomplete="off">
                                        <span class="form-bar"></span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password" required autocomplete="off">
                                        <span class="form-bar"></span>
                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Change Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- end of col-sm-12 -->
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container-fluid -->
        </section>
    </div>
</div>

@endsection

@push('scripts')

@include('admin.layouts.partials._footer-script')

@endpush

