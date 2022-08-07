<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    @include('admin.layouts.partials._head')
</head>

<body>

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

                        <form method="POST" action="{{ route('login') }}" class="md-float-material form-material">
                            @csrf
                            <div class="text-center">
                                <img src="{{ asset('/') }}adminity/files/assets/images/logo.png" alt="logo.png">
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Sign In</h3>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Your Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        <span class="form-bar"></span>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
                                        <span class="form-bar"></span>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="row m-t-25 text-left">
                                        <div class="col-12">
                                            <div class="forgot-phone text-right f-right">
                                                <a href="#" class="text-right f-w-600"> Forgot
                                                    Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign
                                                in</button>
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

@include('admin.layouts.partials._footer-script')

</body>
</html>

