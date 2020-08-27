<div class="card shadow pt-4 mb-4 text-gray-800">
    <div class="card-body">
        <div class="mt-2" id="div-new-apartment-details">
            @if (isset($apartment))
            <h4 class="mt-2 mb-2 text-center">Edit Apartment Listing</h4>
            @else
            <h4 class="mt-2 mb-2 text-center">New Apartment Listing</h4>
            @endif
            <div class="form-row mb-2">
                <div class="col-md-12">
                    <h5>Apartment Details</h5>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="">Number of beds</label>
                    <select name="bedrooms" class="form-control form-line-only form-control-sm {{ $errors->has('bedrooms') ? ' is-invalid' : '' }}" id="dropdown-bedrooms" required>
                        <option value="">Choose...</option>
                        <option {{ isset($apartment->bedrooms) && $apartment->bedrooms == "studio" ? 'selected' : '' }} value="studio">Studio</option>
                        <option {{ isset($apartment->bedrooms) && $apartment->bedrooms == "1" ? 'selected' : '' }} value="1">1 Bedroom</option>
                        <option {{ isset($apartment->bedrooms) && $apartment->bedrooms == "2" ? 'selected' : '' }} value="2">2 Bedrooms</option>
                        <option {{ isset($apartment->bedrooms) && $apartment->bedrooms == "3" ? 'selected' : '' }} value="3">3 Bedrooms</option>
                        <option {{ isset($apartment->bedrooms) && $apartment->bedrooms == "4" ? 'selected' : '' }} value="4">4 bedrooms</option>
                        <option {{ isset($apartment->bedrooms) && $apartment->bedrooms == "5" ? 'selected' : '' }} value="5+">5+ Bedrooms</option>
                    </select>
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bedrooms') }}</strong>
                    </span>
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Price</label>
                    <input type="text" name="price" class="form-control form-line-only form-control-sm {{ $errors->has('price') ? ' is-invalid' : '' }}" id="txtbox-price" required  value="{{ $apartment->price ?? '' }}" />
                    @if ($errors->has('price'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Move-in date</label>
                    <input type="text" name="date" class="form-control form-line-only form-control-sm {{ $errors->has('date') ? ' is-invalid' : '' }}" id="txtbox-date" required value="{{ isset($apartment->available_date) ? \Carbon\Carbon::parse($apartment->available_date)->format('Y-m-d') : ''}}"/>
                    @if ($errors->has('date'))
                        <span class="invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $errors->first('date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="">Street</label>
                    <input type="text" id="address" name="street" class="form-control form-line-only form-control-sm {{ $errors->has('street') ? ' is-invalid' : '' }}" id="txtbox-street" required value="{{ isset($apartment->street) ? $apartment->street : '' }}"/>
                    @if ($errors->has('street'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('street') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="">Apartment Number</label>
                    <input type="text" name="apartment_number" class="form-control form-line-only form-control-sm {{ $errors->has('apartment_number') ? ' is-invalid' : '' }}" id="txtbox-apartment_number" required value="{{ $apartment->apartment_number ?? '' }}"/>
                    @if ($errors->has('apartment_number'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('apartment_number') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="">Neighborhood</label>
                    <select name="neighborhood_id" class="form-control form-line-only form-control-sm {{ $errors->has('neighborhood_id') ? ' is-invalid' : '' }}" id="dropdown-neighborhood_id"  >
                        <option value="">Choose...</option>
                            @foreach ($neighborhoods as $section => $neighborhoodSec)
                                <optgroup label="{{ str_replace('_', ' ', $section) }}">
                                    @foreach($neighborhoodSec as $neighborhood)
                                        <option {{ isset($apartment->neighborhood_id) && $apartment->neighborhood_id == $neighborhood['id'] ? 'selected' : '' }}  value="{{ $neighborhood['id'] }}">{{ $neighborhood['neighborhood'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                    </select>
                    @if ($errors->has('neighborhood_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('neighborhood_id') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group col-md-4">
                    <label for="">Zip Code</label>
                    <input type="text" name="zip_code" class="form-control form-line-only form-control-sm {{ $errors->has('zip_code') ? ' is-invalid' : '' }}" id="txtbox-zip_code" value="{{ $apartment->zip_code ?? '' }}"/>
                    @if ($errors->has('zip_code'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('zip_code') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group col-sm-4">
                    <label for="">Number of bathrooms</label>
                    <select name="bathrooms" class="form-control form-line-only form-control-sm {{ $errors->has('bathrooms') ? ' is-invalid' : '' }}" id="dropdown-bathrooms">
                        <option {{ isset($apartment->bathrooms) && $apartment->bathrooms == "1" ? 'selected' : '' }} value="1">1 Bathroom</option>
                        <option {{ isset($apartment->bathrooms) && $apartment->bathrooms == "2" ? 'selected' : '' }} value="2">2 Bathrooms</option>
                        <option {{ isset($apartment->bathrooms) && $apartment->bathrooms == "3" ? 'selected' : '' }} value="3">3 Bathrooms</option>
                        <option {{ isset($apartment->bathrooms) && $apartment->bathrooms == "4" ? 'selected' : '' }} value="4">4 Bathrooms</option>
                        <option {{ isset($apartment->bathrooms) && $apartment->bathrooms == "5" ? 'selected' : '' }} value="5+">5+ Bathrooms</option>
                    </select>
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bathrooms') }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="">Description</label>
                    <textarea type="text" name="description" class="form-control form-line-only form-control-sm {{ $errors->has('description') ? ' is-invalid' : '' }}" id="txtbox-description" rows="3">{{ $apartment->description ?? ''}}</textarea>
                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>