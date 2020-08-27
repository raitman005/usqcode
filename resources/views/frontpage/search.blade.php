@extends('frontpage.layouts.app')
@section('title', 'Apartment Search Result')
@section('content')
<meta http-equiv="Cache-control" content="no-cache">
<link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"  integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
<link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">


<div class="main content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h4 class="text-counts d-none notbold">You found <span class="span-listing-cnt "></span> apartments</h4>
			</div>
		</div>
		<hr>
		<div class="row mb-1 mt-4">
			<div class="col-md-3">
				<button class="btn btn-outline-primary btn-block btn-sm big" id="btn-refine-search">Refine Search</button>
				
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-3 d-none pt-4" id="div-refine-search">
				<div class="mt-4 mb-4">
					<h5>Neighboorhoods</h5>
					<select name="neighborhood_ids" id="" class="form-control dropdown-neighborhood dropdown-choices-neighborhood" multiple>
						@foreach($neighborhoodlist as $neighborhood)
							<option {{ array_search($neighborhood->id, $neighborhoodIds) !== false ? 'selected' : '' }} value="{{ $neighborhood->id }}">{{ $neighborhood->neighborhood }}</option>
						@endforeach
					</select>
				</div>
				<hr>
				<div class="mt-4 mb-4">
					<h5>Price</h5>
					<input type="Min" class="form-control form-line-only" id="txtbox-min-price" placeholder="min" value="{{ $filter['min_price'] == 0 ? '' : $filter['min_price']}}"> 
					<p class="text-center mt-2 mb-2">to</p> 
					<input type="Min" class="form-control form-line-only" id="txtbox-max-price" placeholder="max" value="{{ $filter['max_price'] == 0 ? '' : $filter['max_price']}}">
				</div>
				<hr>
				<div class="mt-4 mb-4">
					<h5>Rooms</h5>
					<select name="rooms" id="" class="form-control dropdown-room dropdown-choices-room" multiple>
						<option value="studio" {{ array_search('studio', $filter['rooms']) !== false ? 'selected' : '' }}>Studio</option>
						<option value="studio/1" {{ array_search('studio/1', $filter['rooms']) !== false ? 'selected' : '' }}>Studio/br</option>
						<option value="1" {{ array_search('1', $filter['rooms']) !== false ? 'selected' : '' }}>1 Bed</option>
						<option value="2" {{ array_search('2', $filter['rooms']) !== false ? 'selected' : '' }}>2 Beds</option>
						<option value="3" {{ array_search('3', $filter['rooms']) !== false ? 'selected' : '' }}>3 Beds</option>
						<option value="4" {{ array_search('4', $filter['rooms'])  !== false ? 'selected' : '' }}>4 Beds</option>
						<option value="5+" {{ array_search('5+', $filter['rooms'])  !== false ? 'selected' : '' }}>5+ Beds</option>
					</select>
				</div>
			</div>
			<div class="col-lg-12" id="div-listing-search">
				<div class="row">
					<div class="col-md-8">
						<div id="div-search-result">
						</div>
						<div class="row div-lazyload-indicator d-none">
							<div class="col-md-12 text-center">
								<img src="{{ asset('img/loading2.gif') }}">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div id="map-preview-wrapper">
							<h5 class="text-center">Map</h5>
							<div id="map-preview"></div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 "></div>
		</div>
	</div>
</div>
@endsection

@section('extra_scripts')
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script>
	var el = document.querySelector('#div-search-result');
	var data = @json($filter);
	var neighborhoodlist = @json($neighborhoodlist);
	var refineSearchCollapsed = false;
	data._token = "{{ csrf_token() }}";
	var searchUrl = '{{ route("listing.search") }}';
	var mapPreview = document.getElementById('map-preview');
	var mapPreviewPos = mapPreview.offsetTop;
	var layerGroup = "";
	var osmUrl = 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
	var map = "";
	var marker = "";
	var newLat = 0;
	var newLng = 0;
	var currentLat = 0;
	var currentLng = 0;
	var page = 1;
	var mutextLazyIsLoading = false;
	var canLazyLoad = true;

	const minPrice = document.getElementById('txtbox-min-price');
	const maxPrice = document.getElementById('txtbox-max-price');
	const btnRefineSearch = document.getElementById('btn-refine-search');
	const dropdownNeighborhood = document.querySelector('.dropdown-neighborhood');
	const dropdownRoom = document.querySelector('.dropdown-room');
	const divLazyLoad = document.querySelector('.div-lazyload-indicator');
</script>

<script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script src="{{ asset('js/search-result.js') }}"></script>
<script type="text/javascript">
	$(function() {
	   $(window).on('scroll',function() {
	      var scrollPosition = $(this).scrollTop();
	      console.log(scrollPosition);
	      localStorage.setItem("scrollPosition", scrollPosition);
	   });
	});
</script>

@endsection
