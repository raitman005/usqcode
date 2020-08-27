<div class="card shadow pt-2 mb-4 text-gray-800">
    <div class="card-body">
		<div class="" id="div-new-apartment-features">
			<div class="form-row mb-3">
				<div class="col-md-12 optional-field-group">
					<h5><a class="collapsed" data-toggle="collapse" href="#collapse-feature">Features</a></h5>
				</div>
			</div>

			<div id="collapse-feature" class="collapse show">
				<div class="form-row">
					@foreach($features as $feature)
						<div class="form-group col-sm-3">
							<span class="switch">
							<input {{ isset($apartmentFeatures) && $apartmentFeatures->search($feature->id) !== false ? 'checked' : '' }} type="checkbox" name="features[{{ $feature->id }}]" class="switch" id="switch-id-{{ $feature->id }}" value="Yes">
							<label for="switch-id-{{ $feature->id }}">{{ $feature->feature }}</label>
							</span>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>