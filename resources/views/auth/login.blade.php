@extends('layouts.app')
@section('title', 'Welcome')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-admin-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h2 text-gray-900 mb-4">AptViewer.com</h1>
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back Admin!</h1>
                                </div>
                                @include('auth._login_form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
