<nav class="navbar navbar-expand navbar-light bg-success-dark topbar mb-4 static-top shadow">
	<!-- Topbar Navbar -->
	<ul class="navbar-nav ml-auto">
	<!-- Nav Item - User Information -->
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="mr-2 d-none d-lg-inline text-white small">{{ \Auth::user()->firstname . " " . \Auth::user()->lastname }}</span>
				<img class="img-profile rounded-circle" src="{{ asset('img/user.jpg') }}">
			</a>
			<!-- Dropdown - User Information -->
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
	</ul>
</nav>