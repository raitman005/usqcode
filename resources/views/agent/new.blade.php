@extends('frontpage.layouts.app')
@section('title', 'Create Apartment Listing')
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
				<form method="POST" action="{{ route('agent.listings.store') }}"  enctype="multipart/form-data" id="frm-new-apartment">
					@csrf
					@include('agent._form_details')
					<hr/>
					@include('agent._form_features')
					<hr/>
					@include('agent._form_photos')
					<hr/>
					@include('agent._form_maps')
					<hr/>
					<input type="hidden" name="latitude" id="map-latitude" value="">
                    <input type="hidden" name="longitude" id="map-longitude" value="">
					<div class="form-row">
						<div class="col-md-12 text-center">
							<button type="submit" class="btn btn-primary btn-lg">Create Apartment</button>
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
    var latitude = null;
    var longitude = null;
    var map = null;
    var layerGroup = null;
</script>
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/geocoder.js') }}"></script>
<script src="{{ asset('js/purify.min.js') }}"></script>
<script src="{{ asset('js/sortable.min.js') }}"></script>
<script src="{{ asset('js/piexif.min.js') }}"></script>
<script src="{{ asset('js/fileinput.js') }}"></script>
<script src="{{ asset('js/fileinput-theme.min.js') }}"></script>
<script src="{{ asset('js/fileinput-theme-fas.min.js') }}"></script>
<script src="{{ asset('js/fileinput-theme-explorer-fas.js') }}"></script>
<!-- <script src="{{ asset('js/map.js') }}"></script> -->
<script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{ asset('js/new-listing.js') }}"></script>
<script type="text/javascript">
$(function() {
    var osmUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    osm = L.tileLayer(osmUrl, {
      maxZoom: 20,
      attribution: osmAttrib
    });

    if (latitude && longitude) {
        map = L.map('map').setView([latitude, longitude], 12).addLayer(osm);
    } else {
        map = L.map('map').setView([40.758896, -73.985130], 12).addLayer(osm);
    }

    map.on('click', addMarker);
    $('#address').on("focusout", addSearch);
    layerGroup = L.layerGroup().addTo(map);

    // if (latitude && longitude) {
    //     layerGroup.clearLayers();
    //     new L.marker([latitude, longitude]).addTo(layerGroup);
    // }

    function addMarker(e){
        // Add marker to map at click location; add popup window
        $('#map-latitude').val(e.latlng.lat);
        $('#map-longitude').val(e.latlng.lng);
        
        layerGroup.clearLayers();
        var newMarker = new L.marker(e.latlng).addTo(layerGroup);
    }

    function addSearch(){
        // var geocoder = new google.maps.Geocoder();
        var street = $('#address').val();
        var address = street +", New York";
        // var bingGeocoder = new GeocoderJS.createGeocoder({provider: 'bing', apiKey: 'As11PsBXYvAoGEXmz59ZWl93T8_OACdXi2QnRKWMRIUK6hzOXgN3BcZHnbKyPZYo'});
        var mapQuestGeocoder = new GeocoderJS.createGeocoder({provider: 'mapquest', apiKey: 'Fmjtd%7Cluurnu6al1%2Cbg%3Do5-9wbg94'});
         mapQuestGeocoder.geocode(address, function(result) {
            var firstres = result[0];
         var js = JSON.parse(JSON.stringify(firstres));
         // $('#pricer').val(js.latitude);
         $('#map-latitude').val(js.latitude);
         $('#map-longitude').val(js.longitude);
         // console.log(js.latitude+":"+js.longitude);
         layerGroup.clearLayers();
         var newMarker = new L.marker([js.latitude, js.longitude]).addTo(layerGroup);
         // alert($('#pricer'));
         // console.log($('#map.latitude').val());
         // console.log($('#map.longitude').val());
         document.getElementById('map-latitude').value = js.latitude;
         document.getElementById('map-longitude').value = js.longitude;
          });
    }

    window.setInterval(function(){
    	var street = $('#address').val();
        var address = street +", New York";
        // var bingGeocoder = new GeocoderJS.createGeocoder({provider: 'bing', apiKey: 'As11PsBXYvAoGEXmz59ZWl93T8_OACdXi2QnRKWMRIUK6hzOXgN3BcZHnbKyPZYo'});
        var mapQuestGeocoder = new GeocoderJS.createGeocoder({provider: 'mapquest', apiKey: 'Fmjtd%7Cluurnu6al1%2Cbg%3Do5-9wbg94'});
         mapQuestGeocoder.geocode(address, function(result) {
            var firstres = result[0];
         var js = JSON.parse(JSON.stringify(firstres));
         // $('#pricer').val(js.latitude);
         $('#map-latitude').val(js.latitude);
         $('#map-longitude').val(js.longitude);
         // console.log(js.latitude+":"+js.longitude);
         layerGroup.clearLayers();
         var newMarker = new L.marker([js.latitude, js.longitude]).addTo(layerGroup);
         // alert($('#pricer'));
         // console.log($('#map.latitude').val());
         // console.log($('#map.longitude').val());
         document.getElementById('map-latitude').value = js.latitude;
         document.getElementById('map-longitude').value = js.longitude;
          });
    },1000);
    $('#collapse-map').on('shown.bs.collapse', function (e) {
        map.invalidateSize(true);
    })
});
</script>
@endsection
