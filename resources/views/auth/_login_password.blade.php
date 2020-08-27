<div id="div-password-form">
<form action="#" method="POST" id="frm-login-password">
	<div class="row mt-3">
		<div class="col-md-12 text-center">
			<h5 class="login-reg-title">ENTER YOUR PASSWORD</h5>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-12 text-center">
			<p>Hello {{ $email }}!</p>
		</div>
	</div>

	<div class="row mt-1 mb-1">
		<div class="col-md-12 text-center">
			<span class="vertical-separator"></span>
		</div>
	</div>

	<div class="form-row mt-1 mb-2">
		<div class="col-md-12 text-center">
			<input type="password" required class="form-control form-line-only" placeholder="Password" name="password" id="txtbox-login-password">
			<span class="invalid-feedback" role="alert"> <strong id="txt-password-error"></strong></span>
		</div>
	</div>

	<div class="row mt-3 mb-1">
		<div class="col-md-12 text-center">
			<input type="hidden" name="email" id="txtbox-login-email" value="{{ $email }}">
			<input type="hidden" name="_token" id="csrf-login-password-token" value="{{ csrf_token() }}">
			<button id="btn-submit-login-password" class="btn btn-primary btn-block">SUBMIT</button>
		</div>
	</div>
</form>

<form action="#" method="POST" id="frm-reset-password" action="{{ route('password.email') }}">
	<div class="row mt-3 mb-1">
		<div class="col-md-12 text-center">
			<input type="hidden" name="email" id="txtbox-forgotpassword-email" value="{{ $email }}">
			<input type="hidden" name="_token" id="csrf-forgotpassword-token" value="{{ csrf_token() }}">
				<a class="small" id="link-forgot-password" href="#">Forgot your password?</a>
		</div>
	</div>
</form>
</div>

<div id="div-forgot-password-msg" class="d-none">
	<div class="row text-center">
		<div class="col-md-12">
			<h3 class="notbold">Forgot Password</h3>
		</div>
	</div>
	<div class="row text-center">
		<div class="col-md-12">
			<p>
				To reset your account, Use the link that was sent to <strong>{{ $email }}</strong>
			</p>
		</div>
	</div>
</div>