@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="main content">
	<div class="container-fluid text-white">
		@foreach (['danger', 'warning', 'success'] as $msg)
            @if(Session::has($msg))
				<div class="row mb-3">
					<div class="col-md-12">
						<div class="notice notice-{{ $msg }}">
							<strong>{{ ucfirst($msg) }}:</strong> {{ Session::get($msg) }}
						</div>
					</div>
				</div>
			@endif
		@endforeach
		<div class="card">
		</div>
	</div>
</div>
@endsection