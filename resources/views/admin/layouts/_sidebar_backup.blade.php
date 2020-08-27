<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
		<div class="sidebar-brand-icon rotate-n-15">
		  <i class="fas fa-home"></i>
		</div>
		<div class="sidebar-brand-text mx-3">Aptviewer</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<li class="nav-item">
		<a class="nav-link" href="{{ route('admin.listings')}}">
		<i class="fas fa-fw fa-users"></i>
		<span>My Listings</span></a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('admin.accounts')}}">
		<i class="fas fa-fw fa-users"></i>
		<span>User Info</span></a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('admin.user.listings')}}">
		<i class="fas fa-fw fa-building"></i>
		<span>User's Listings</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>
<!-- End of Sidebar -->
