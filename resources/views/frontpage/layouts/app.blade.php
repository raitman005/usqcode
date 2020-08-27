<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        <title>@yield('title') - {{ config('app.name') }}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
		<link href="{{ asset('css/homepage.css') }}" rel="stylesheet" />
		<link href="{{ asset('css/homepage2.css') }}" rel="stylesheet" />
		<link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
		<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
		
	</head>
	<body>y
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark pb_navbar pb_scrolled-light scrolled awake" id="templateux-navbar">
				<div class="container text-dark">
					<a class="navbar-brand" href="{{ url('/') }}">
						<img width="70%" src="{{ asset('img/logo.png') }}" alt="logo">
					</a>
					<div class="site-menu-toggle js-site-menu-toggle ml-auto aos-init aos-animate" data-aos="fade" data-toggle="collapse" data-target="#templateux-navbar-nav" aria-controls="templateux-navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</div>
					<div class="collapse navbar-collapse" id="templateux-navbar-nav">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('listing.create') }}">Submit your listings</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
							</li>
							@if (\Auth::user() == false)
							<li class="nav-item">
								<a class="nav-link" data-toggle="modal" data-target="#login-modal" role="button" href="#">Sign in / Register</a>
							</li>
							@else
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Hi {{ Auth::user()->firstname }}!
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									@if (Helper::passwordNotSet())
										<a class="dropdown-item"  data-toggle="modal" data-target="#set-password-modal" href="#">Set Password</a>
										<div class="dropdown-divider"></div>
									@endif
									<a class="dropdown-item" href="{{ route('user.profile') }}">My Profile</a>
									@if (Auth::user()->user_type_id == Helper::getUserType('agent')->id)
									<a class="dropdown-item" href="{{ route('agent.listings') }}">My Listings</a>
									<a class="dropdown-item" href="{{ route('admin.info') }}">All Accounts</a>
									@endif
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</div>
							</li>
							@endif
						</ul>
					</div>
				</div>
			</nav>
		</header>
		
        <main class="{{ \Request::is('/') ? 'homepage' : '' }}">
			@yield('content')
			@if (\Auth::user() == false)
				@include('auth._login_register')
			@endif
			@if (Helper::passwordNotSet())
				@include('auth._set_password')
			@endif
        </main>
		
		<footer class="footer  text-center">
				<div class="row mb-2">
					<div class="col-md-12">
						<a class="footer-link" href="{{ route('contact') }}">Contact Us</a> | 
						<a class="footer-link" href="{{ route('listing.create') }}">Submit Your Listings</a> | 
						<a class="footer-link" href="{{ route('terms') }}">Privacy and Terms</a>  
					</div>
				</div>
				<hr>

				<div class="container">
					<div class="row mt-2">
						<div class="col-md-12">
							<span class="">Copyright &copy; 2019. 123nofee.com, All rights reserved.</span>
						</div>
					</div>
				</div>
		</footer>

		<script src="{{ asset('js/choices.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
		<script src="{{ asset('js/app.js') }}"></script>
		@if (\Auth::user() == false)
			<script src="{{ asset('js/auth.js') }}"></script>
		@endif
		@if (isset($passwordFormPopup) && $passwordFormPopup)
		<script>
			document.onreadystatechange = function () {
				$('#set-password-modal').modal('show');
			}
		</script>
		@endif
		@if (Helper::passwordNotSet())
			<script src="{{ asset('js/set-password.js') }}"></script>
		@endif
		<script>
			@if(Session::has('toast_success'))
			iziToast.success({
				title: 'Success',
				message: '{{ Session::get("toast_success") }}',
				position: 'topCenter'
			});
			@endif
			@if(Session::has('status'))
			iziToast.success({
				title: 'Success',
				message: '{{ Session::get("status") }}',
				position: 'topCenter'
			});
			@endif
		</script>
        @section('extra_scripts')
        @show
	</body>
</html>
