<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
		<div class="sidebar-brand-icon rotate-n-15">
		  <i class="fas fa-home"></i>
		</div>
		<div class="sidebar-brand-text mx-3">Aptviewer</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
		<a class="nav-link" href="{{ route('admin') }}">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span>
		</a>
	</li>

	<li class="nav-item {{ Request::is('admin/followup/leads') ? 'active' : '' }}">
		<a class="nav-link" href="{{ route('admin.followup.leads') }}">
		<i class="fas fa-fw fa-users"></i>
		<span>Followup Leads</span></a>
	</li>

	<li class="nav-item {{ Request::is('admin/agent') ? 'active' : '' }}">
		<a class="nav-link" href="{{ route('admin.agents') }}">
		<i class="fas fa-fw fa-users"></i>
		<span>Agents</span></a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="http://leads.usqprop.com/apartments" target="_blank">
		<i class="fas fa-fw fa-building"></i>
		<span>Apartments</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>
<!-- End of Sidebar -->
