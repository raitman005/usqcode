@extends('frontpage.layouts.app')
@section('title',  $apartment->street )
@section('content')
<link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet"> 
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"  integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>

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
		
		<div class="row">
			<div class="col-md-8">
				<div id="listing-images" >
					@foreach($apartment->apartmentPhotos as $photo)
						<img width="1" src="{{ $photo->photo }}">
					@endforeach
				</div>

				<div class="row mb-2 mt-4">
					<div class="col-sm-7">
						<p>{{ $apartment->neighborhood->neighborhood ?? '' }}, {{ $apartment->neighborhood->section ?? '' }}</p>	
						<p>
							{{ $apartment->bedrooms }} <i class="fas fa-bed">&nbsp;</i> 
							<span class="separator"></span>  &nbsp;
							{{ $apartment->bathrooms }}  <i class="fas fa-bath">&nbsp;</i>
						</p>	

						<p>Listed {{ \Carbon\Carbon::parse($apartment->created_at)->diffForHumans() }}.</p>	
					</div>
					<div class="col-sm-5 text-right">
						Available on: {{ \Carbon\Carbon::parse($apartment->available_date)->format('M d, Y') }}
					</div>
				</div>

				<div class="row mb-4">
					<div class="col-sm-12 apartment-section">
						<h4 class="listing-section">Description</h4>
						<p class="listing-text listing-description">
							{!! $apartment->description == "" ? '<i>No description available</i>' : $apartment->description !!}
						</p>
					</div>
				</div>

				@if ($apartment->features->count() > 0)
					<div class="row mb-4">
						<div class="col-sm-12 apartment-section">
							<h4 class="listing-section">Features</h4>
						</div>
					</div>

					<div class="row mb-4">
						@foreach($apartment->features as $feature) 
							<div class="col-md-4 listing-text">
								<p class="listing-text">
									{!! $feature->icon !!} {{ $feature->feature }}
								</p>
							</div>
						@endforeach
					</div>
				@endif
				
			</div>
			<div class="col-md-4 mb-4">
				<div class="mb-2">
					<div class="row mb-1 mt-1">
						<div class="col-sm-12">
							<p class="listing-title">{{ $apartment->street }} - # {{ $apartment->apartment_number }} </p>
						</div>
					</div>
					<div class="row mb-1 mt-1">
						<div class="col-sm-12">
							<p class="listing-price">${{ number_format($apartment->price, 2) }}</p>
						</div>
					</div>
				</div>
				<hr>

				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12">
								<p class="pnomargin small bold">CHECK AVAILABILITY:</span>
							</div>
						</div>
						<hr>
						<form action="{{ route('listing.send') }}" method="POST">
							<div class="form-group">
								<input type="text" name="name" class="form-control form-line-only {{ $errors->has('name') ? ' is-invalid' : '' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name" value="{{ \Auth::user()->firstname ?? '' }}{{ isset(\Auth::user()->lastname)  ? ' ' . \Auth::user()->lastname : '' }}">
								@if ($errors->has('name'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group">
								<input type="email" name="email" class="form-control form-line-only {{ $errors->has('email') ? ' is-invalid' : '' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" value="{{ \Auth::user()->email ?? '' }}">
								@if ($errors->has('email'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group">
								<input type="text" name="phone" class="form-control form-line-only {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Phone Number" value="{{ \Auth::user()->phone_number ?? '' }}">
								@if ($errors->has('phone'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('phone') }}</strong>
									</span>
								@endif
							</div>

							<div class="form-group">
								<textarea name="body" class="form-control form-line-only {{ $errors->has('body') ? ' is-invalid' : '' }}" id="" rows="4" placeholder="Hello, I am interested in {{ $apartment->street }}">{{ old('body') }}</textarea>
								@if ($errors->has('body'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('body') }}</strong>
									</span>
								@endif
							</div>

							<div class="form-group text-info">
								<small id="emailHelp" class="form-text text-muted">We'll never share your email and phone number.</small>
							</div>

							<input type="hidden" name="id" value="{{ encrypt($apartment->id) }}">
							@csrf
							<button type="submit" class="btn btn-primary btn-block">Send a Message</button>
						</form>
					</div>
				</div>

				<div class="card mt-4">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12">
								<p class="pnomargin small bold">LISTED BY:</span>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-lg-4 text-center">
								<div class="img-square-wrapper mb-3">
									<img class="rounded-circle"  height="80px" width="80px" src="{{ Helper::agentAvatar($apartment->user) }}" alt="Card image cap">
								</div>
							</div>
							<div class="col-lg-8 ">
								<h6 class="card-title"> {{ $apartment->user->firstname }} {{ $apartment->user->lastname }}</h6>
								<p class="small"><i class="fas fa-briefcase">&nbsp;</i> {{ $apartment->user->company }} <br/>
									<!-- <i class="fas fa-envelope">&nbsp;</i> {{ $apartment->user->email }} <br/>
									<i class="fas fa-phone">&nbsp;</i> {{ $apartment->user->phone_number }} -->
								</p>
							</div>
						</div>
					</div>
				</div>
					
			</div>
		</div>

		<div class="row mb-4">
			<div class="col-sm-12">
				<h4 class="listing-section">Map</h4>
				@if ($apartment->latitude == "" || $apartment->longitude == "")
					<div>
					<i>Map not set.</i>
					</div>
				@else
				<div id="map">
					
				</div>
				@endif
			</div>
		</div>
		
		@if (count($nearbyApartments) > 0)
			<div class="row">
				<div class="col-md-12">
					<h4 class="listing-section">Nearby apartments</h4>
				</div>
			</div>
			<div class="row mb-5 mt-3">
				@foreach($nearbyApartments as $nearbyApartment)
					<?php 
						$apartmentPhoto = $nearbyApartment->apartmentPhotos[0]->photo ?? asset('img/no-image.jpg')
					?>
					<div class="col-md-3">
						<div class="card">
							<a href="{{ route('listing', $nearbyApartment->id) }}">
								<img src="{{ $apartmentPhoto }}" class="card-img-top card-img-top-nearby" alt="...">
							</a>
							<div class="card-body lessspace">
								<p class="nospace small">${{ number_format($nearbyApartment->price, 2) }} <span class="separator"></span> By: {{ $nearbyApartment->user->firstname }} {{ $nearbyApartment->user->lastname }}</p>
								<h5 class="card-title"><a href="{{ route('listing', $nearbyApartment->id) }}"> {{ $nearbyApartment->apartment_number }} - {{ $nearbyApartment->street }}</a></h5>
								<p class="small nearby-text-description">
									{!! $nearbyApartment->description ? substr($nearbyApartment->description, 0, 75) : '<i>No description</i>' !!}
								</p>
								<hr>
								<p class="small">
									{{ $nearbyApartment->neighborhood->neighborhood ?? '' }}, {{ $nearbyApartment->neighborhood->section ?? '' }}
								</p>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		@endif
	</div>
</div>
@endsection

@section('extra_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script> 
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
<script>
	
	$(function() {
		var lat = '{{ $apartment->latitude  ? $apartment->latitude : 0 }}';
		var lng = '{{ $apartment->longitude  ? $apartment->longitude : 0 }}';

		if (lat != 0 && lng != 0) {
			var osmUrl = 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png',
			osmAttrib = '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			osm = L.tileLayer(osmUrl, {
				maxZoom: 20,
				attribution: osmAttrib
			});

			var map = L.map('map').setView([40.758896, -73.985130], 12).addLayer(osm);

			var layerGroup = L.layerGroup().addTo(map);

			if (lat && lng) {
				var marker = L.marker([lat, lng]).addTo(layerGroup)
			}
		}

		$('#listing-images').fotorama({
			shadows: false,
			swipe: true,
			maxwidth: "100%",
			nav: "thumbs",
			width: "100%",
			ratio: "400/250",
			allowfullscreen: "true",
		});
	});

	
	

</script>
@endsection
