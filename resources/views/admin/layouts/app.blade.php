<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sb-admin-2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vanillatoasts.css') }}">
</head>
<body id="page-top" class="">
    <div id="wrapper">
        @include('admin.layouts._sidebar_backup')
        <div id="content-wrapper" class="d-flex flex-column bg-gradient-success">
            <div id="content">
                @include('admin.layouts._header_backup')
                @yield('content')
            </div>
            <footer class="sticky-footer bg-success-dark text-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>
                        Copyright ©  2019 <br/><br/>
                       
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/vanillatoasts.js') }}"></script>
    
    @section('extra_scripts')
    @show
</body>
</html>
