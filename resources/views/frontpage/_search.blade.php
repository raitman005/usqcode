<div class="mb-5">
@if (count($apartments) > 0)
	@foreach ($apartments as $apartment)
		<div class="row mt-2">
			<div class="offset-md-1 col-md-10 dynamic-col mb-3 mt-3" data-lat="{{ $apartment->latitude }}" data-lng="{{ $apartment->longitude }}">
				<div class="card">
					<a href="{{ route('listing', $apartment->id) }}">
						@if(isset($apartment->apartmentPhotos[0]))
							<div class="fotorama{{$page}}" data-width="100%" >
							
								<img data-scr="{{ asset('img/lazyload.png') }}" src="{{ $apartment->apartmentPhotos[0]->photo }}" class="card-img-top card-listing-image-big" alt="...">
							
							</div>
						@else
							<div class="" >
								<img data-scr="{{ asset('img/lazyload.png') }}" src="{{ asset('img/no-image.jpg') }}" class="card-img-top card-listing-image-big" alt="...">
							</div>
						@endif
					</a>
					<div class="card-body pt-2">
						<div class="flex-lr">
							<div class="left">
								<a class="" href="{{ route('listing', $apartment->id) }}">
									<span class=" search-title">{{ $apartment->street }} -  # {{ $apartment->apartment_number }}</span>
								</a>
							</div>
							<div class="right">
								<a class="" href="{{ route('listing', $apartment->id) }}">
									<span class="search-price float-right">$ {{ number_format($apartment->price, 2) }}</span>
								</a>
							</div>
						</div>
						
						<div class="row search-text-caption">
							<div class="col-md-6">
								<a class="" href="{{ route('listing', $apartment->id) }}">{!! $apartment->neighborhood->neighborhood ?? '<i>Neighborhood not set</i>' !!}</a>
							</div>
							<div class="col-md-6 text-right search-br-text">
								<a class="" href="{{ route('listing', $apartment->id) }}">
									{{ $apartment->bedrooms == 'studio' ? 'Studio' : $apartment->bedrooms . ' bedroom' }},
									{{ $apartment->bathrooms . ' bathroom' }}
								</a>
							</div>
						</div>	
						<p class="card-text"></p>
					</div>
				</div>
			</div>
		</div>
	@endforeach
@elseif ($page == 1)
	<div class="notice notice-warning">No listings found.</div>
@else
	<div class="notice notice-warning">End of the result.</div>
@endif
</div>