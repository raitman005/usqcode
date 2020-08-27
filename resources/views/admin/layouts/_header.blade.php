<nav class="navbar navbar-expand navbar-light bg-success-dark topbar mb-4 static-top shadow">
	<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="GET" action="{{ route('admin.search') }}">
		<div class="input-group">
			<input type="text" value="{{ $keyword ?? '' }}" class="form-control bg-light border-0 small" placeholder="Search lead..." name="keyword" aria-label="Search" aria-describedby="basic-addon2">
			<div class="input-group-append">
				<button class="btn btn-success" type="button">
					<i class="fas fa-search fa-sm"></i>
				</button>
			</div>
		</div>
	</form>
	<!-- Sidebar Toggle (Topbar) -->
	<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
		<i class="fa fa-bars"></i>
	</button>
	<!-- Topbar Navbar -->
	<ul class="navbar-nav ml-auto">
	<!-- Nav Item - User Information -->
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="mr-2 d-none d-lg-inline text-white small">{{ \Auth::user()->firstname . " " . \Auth::user()->lastname }}</span>
				<img class="img-profile rounded-circle" src="{{ asset('img/user.jpg') }}">
			</a>
			<!-- Dropdown - User Information -->
			<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
				<a class="dropdown-item" href="#">
					<i class="fas fa-cogs fa-sm fa-fw mr-2 text-white"></i>
					Settings
				</a>
				<a class="dropdown-item" href="{{ url('logs') }}">
					<i class="fas fa-list fa-sm fa-fw mr-2 text-white"></i>
					App Logs
				</a>
				<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
					<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
					Logout
					<form id="frm-logout" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
					    {{ csrf_field() }}
					</form>
				</a>
			</div>
		</li>
	</ul>
</nav>