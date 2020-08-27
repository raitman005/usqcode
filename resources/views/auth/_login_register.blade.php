<div class="modal " id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><span class="fa fa-times"></span></span>
				</button>
				<div class=" px-5 py-5" id="login-register-content">
					<form action="#" method="POST" id="frm-login-register">
						<div class="row mt-3">
							<div class="col-md-12 text-center">
								<h5 class="login-reg-title">SIGN IN / REGISTER</h5>
							</div>
						</div>

						<div class="row mt-1 mb-1">
							<div class="col-md-12 text-center">
								<span class="vertical-separator"></span>
							</div>
						</div>

						<div class="row mt-1 mb-1">
							<div class="col-md-12 text-center">
								<p class="small">For added benefits and to make 123nofee easier to use: </p>
							</div>
						</div>

						<div class="form-row mt-2 mb-3">
							<div class="col-md-12 text-center">
								<input type="email" required class="form-control form-line-only" placeholder="Enter your email" name="email" id="txtbox-auth-email">
								<span class="invalid-feedback" role="alert"> <strong id="txt-email-error"></strong></span>
							</div>
						</div>

						<div class="row mt-3 mb-1">
							<div class="col-md-12 text-center">
								<input type="hidden" name="_token" id="csrf-auth-token" value="{{ csrf_token() }}">
								<button id="btn-submit-login-reg" class="btn btn-primary btn-block">SUBMIT</button>
							</div>
						</div>

						<div class="row mt-1 mb-1">
							<div class="col-md-12 text-center">
								<p class="small">I have read and agree to the <a href="{{ route('terms') }}"> Terms and Conditions. </a></p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
