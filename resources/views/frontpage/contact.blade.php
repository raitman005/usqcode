@extends('frontpage.layouts.app')
@section('title', 'Contact')
@section('content')
<div class="main content">
	<div class="container">
		<div class="row mb-3 page-title">
			<div class="col-md-12">
				<div class="page-header">
					<h3>
						Contact
					</h3>
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
				<form action="{{ route('contact.send') }}" method="POST">
					<div class="form-group">
						<label for="txtbox-name">Name</label>
						<input name="name" type="test" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="txtbox-name" placeholder="Enter your name">
						@if ($errors->has('name'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('name') }}</strong>
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
						<label for="exampleInputPassword1">Phone number</label>
						<input name="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="txtbox-phone" placeholder="Enter your phone #">
						@if ($errors->has('phone'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('phone') }}</strong>
							</span>
						@endif
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Message</label>
						<textarea name="message" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" id="txtarea-message" cols="30" rows="10" placeholder="Message"></textarea>
						@if ($errors->has('message'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('message') }}</strong>
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
