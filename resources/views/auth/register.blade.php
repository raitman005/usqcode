@extends('layouts.app')
@section('title', 'Agent Sign Up')
@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form method="POST" action="{{ route('register') }}" class="user">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="email" class="form-control form-control-user {{ $errors->has('email') ? ' is-invalid' : '' }}" id="exampleInputEmail" name="email" required placeholder="Email Address">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user {{ $errors->has('password') ? ' is-invalid' : '' }}" id="exampleInputPassword" name="password" required placeholder="Password">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" name="password_confirmation" required placeholder="Repeat Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user {{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" id="txtboxfirstname" required placeholder="First Name">
                                    @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user {{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" id="txtboxlastname" required placeholder="Last Name">
                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" id="txtboxphone_number" required placeholder="Phone Number">
                                    @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user {{ $errors->has('real_estate_license_number') ? ' is-invalid' : '' }}" id="exampleInputEmail" name="real_estate_license_number" required placeholder="Real Estate License Number">
                                    @if ($errors->has('real_estate_license_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('real_estate_license_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                            Register Account
                            </button>
                            <hr>
                        </form>
                        <div class="text-center">
                        <a class="small" href="{{ url('/') }}">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
