@extends('frontpage.layouts.app')
@section('title', 'Submit Your Listing')
@section('content')
<div class="main content">
	<div class="container">
		<div class="row mb-3 page-title">
			<div class="col-md-12">
				<div class="page-header">
					<h3>
						Submit Your Listing
					</h3>
					<p class="subtext">All accurate listings are allowed from management companies to brokerages as long as it is no fee. Please submit your details below and we will get back to you promptly. </p>
				</div>
			</div>
		</div>
		@foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))
				<div class="row mb-3">
					<div class="col-md-12">
						<div class="notice notice-{{ $msg }}">
							{{ Session::get($msg) }}
						</div>
					</div>
				</div>
			@endif
		@endforeach
		
		@if ($errors->has('g-recaptcha-response'))
			<div class="notice notice-danger mt-1 mb-3" role="alert">
				<strong>Captcha error.</strong>
			</div>
		@endif
		
		<div class="row mt-5 mb-5">
			<div class="col-md-12">
				<form action="{{ route('listing.create.send') }}" method="POST">
					<div class="form-group">
						<label for="txtbox-name">Company</label>
						<input name="company" type="test" class="form-control {{ $errors->has('company') ? ' is-invalid' : '' }}" id="txtbox-company" placeholder="Enter your company">
						@if ($errors->has('company'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('company') }}</strong>
							</span>
						@endif
					</div>
					<div class="form-group">
						<label for="txtbox-email">Email address</label>
						<input name="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="txtbox-email" placeholder="Enter your email">
						@if ($errors->has('email'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Contact Phone number</label>
						<input name="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="txtbox-phone" placeholder="Enter the contact phone #">
						@if ($errors->has('phone'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('phone') }}</strong>
							</span>
						@endif
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">What are some addresses you want to add</label>
						<textarea name="addresses" class="form-control {{ $errors->has('addresses') ? ' is-invalid' : '' }}" id="txtarea-addresses" cols="30" rows="10" placeholder="Addresses one per line"></textarea>
						@if ($errors->has('addresses'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('addresses') }}</strong>
							</span>
						@endif
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Comments</label>
						<textarea name="comment" class="form-control {{ $errors->has('comment') ? ' is-invalid' : '' }}" id="txtarea-comment" cols="30" rows="10" placeholder="Comment"></textarea>
						@if ($errors->has('comment'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('comment') }}</strong>
							</span>
						@endif
					</div>
					<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
					<input type="hidden" name="action" value="validate_captcha">
					@csrf
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('extra_scripts')
<script src="https://www.google.com/recaptcha/api.js?render=6Lfi8qIUAAAAABnRmEZ-iOW3Kv1QPY-Bl1fcjr7G"></script>
<script>
	grecaptcha.ready(function() {
		grecaptcha.execute('6Lfi8qIUAAAAABnRmEZ-iOW3Kv1QPY-Bl1fcjr7G', {action: 'homepage'}).then(function(token) {
			document.getElementById('g-recaptcha-response').value = token;
		});
	});
</script>
@endsection
