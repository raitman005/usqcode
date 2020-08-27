@extends('frontpage.layouts.app')
@section('title', 'Edit Apartment Listing')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/fileinput.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/switch.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
  integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
  crossorigin=""/>
<link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style>
    #map {
        height: 500px;
    }
    label {
        font-size: 14px;
    }
</style>

<div class="main content">
	<div class="container">
		@foreach (['danger', 'warning', 'success', 'info'] as $msg)
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
		
		<div class="row pb-5">
			<div class="col-md-12">
				<form method="POST" action="{{ route('agent.listings.update') }}"  enctype="multipart/form-data" id="frm-new-apartment">
					@csrf
					{{ method_field('PUT') }}
					@include('agent._form_details')
					<hr/>
					@include('agent._form_features')
					<hr/>
					@include('agent._form_photos')
					<hr/>
					@include('agent._form_maps')
					<hr/>
					<div class="form-row">
						<div class="col-md-12 text-center">
							<input  type="hidden" name="id" value="{{ $apartment->id }}" />
							<button type="submit" class="btn btn-primary btn-lg">Update Apartment</button>
						</div>
					</div>
					<hr/>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('extra_scripts')
<script>
    var csrfToken = "{{ csrf_token() }}";
    var updateApartmentUrl = "{{ route('agent.listings.update') }}";
    var ajaxStoreApartmentUrl = "{{ route('agent.listings.store') }}";
    var photoUploadUrl = "{{ route('agent.listings.photos.upload') }}";
    var reorderUrl = "{{ route('agent.listings.photos.reorder') }}";
    var latitude = false;
    var longitude = false;
    var map = null;
    var layerGroup = null;
</script>
<script src="{{ asset('js/purify.min.js') }}"></script>
<script src="{{ asset('js/sortable.min.js') }}"></script>
<script src="{{ asset('js/piexif.min.js') }}"></script>
<script src="{{ asset('js/fileinput.js') }}"></script>
<script src="{{ asset('js/fileinput-theme.min.js') }}"></script>
<script src="{{ asset('js/fileinput-theme-fas.min.js') }}"></script>
<script src="{{ asset('js/fileinput-theme-explorer-fas.js') }}"></script>
<script src="{{ asset('js/map.js') }}"></script>
<script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    var csrfToken = "{{ csrf_token() }}";
    var updateApartmentUrl = "{{ route('agent.listings.update') }}";
    var photoUploadUrl = "{{ route('agent.listings.photos.upload') }}";
    var reorderUrl = "{{ route('agent.listings.photos.reorder') }}";
    var latitude = "{{ $apartment->latitude }}";
    var longitude = "{{ $apartment->longitude }}";
    var map = null;
    var layerGroup = null;
    var currentPhotos = @json($photos);
    var currentPhotosConfig = @json($config);
</script>
<script src="{{ asset('js/edit-apartment.js') }}"></script>
@endsection
