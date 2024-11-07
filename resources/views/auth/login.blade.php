@extends('layouts.login_master')

<style>
    img{
width: 70px;
margin-bottom:20px;
    };
    .logincard {
  margin-right: 2px;
  transition: margin 0.2s ease-in-out, margin-top 0.2s ease-in-out;
  background-color: gray;
}

.logincard:hover {
  margin-top: -10px; /* Added 'px' unit */
}

</style>
@section('content')
    <div class="page-content login-cover">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content d-flex justify-content-center align-items-center">

                <!-- Login card -->
                <form class="login-form " method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="card logincard mb-0">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="/global_assets/images/user icon/user.png" alt="User Icon">
                                <h5 class="mb-0">Login to your account</h5>
                                <span class="d-block text-muted">Enter your login Info</span>
                            </div>

                                @if ($errors->any())
                                <div class="alert alert-danger alert-styled-left alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                    <span class="font-weight-semibold">Oops!</span> {{ implode('<br>', $errors->all()) }}
                                </div>
                                @endif


                            <div class="form-group ">
                                <input type="text" class="form-control" name="identity" value="{{ old('identity') }}" placeholder="Login ID or Email">
                            </div>

                            <div class="form-group ">
                                <input required name="password" type="password" class="form-control" placeholder="{{ __('Password') }}">

                            </div>

                            <div class="form-group d-flex align-items-center">
                                <div class="form-check mb-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="remember" class="form-input-styled" {{ old('remember') ? 'checked' : '' }} data-fouc>
                                        Remember
                                    </label>
                                </div>

                                <a href="{{ route('password.request') }}" class="ml-auto">Forgot password?</a>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-block" style="background:rgb(0, 110, 255); color:white">Sign in <i class="icon-circle-right2 ml-2"></i></button>
                            </div>

                           {{-- <div class="form-group">
                                <a href="#" class="btn btn-light btn-block"><i class="icon-home"></i> Back to Home</a>
                            </div>--}}


                        </div>
                    </div>
                </form>

            </div>


        </div>

    </div>
    @endsection
