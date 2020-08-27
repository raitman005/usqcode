<div class="modal " id="set-password-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><span class="fa fa-times"></span></span>
				</button>
				<div class=" px-5 py-5" id="set-password-content">
					<form action="#" method="POST" id="frm-set-password">
						<div class="row mt-3">
							<div class="col-md-12 text-center">
								<h5 class="login-reg-title">SET YOUR PASSWORD</h5>
							</div>
						</div>

						<div class="row mt-1 mb-1">
							<div class="col-md-12 text-center">
								<span class="vertical-separator"></span>
							</div>
						</div>

						<div class="row mt-1 mb-1">
							<div class="col-md-12 text-center">
								<p class="small">That way, you can sign in more easily next time</p>
							</div>
						</div>

						<div class="form-row mt-1 mb-2">
							<div class="col-md-12 text-center">
								<input type="password" required class="form-control form-line-only" placeholder="At least 6 characters" name="password" id="txtbox-set-password">
								<span class="invalid-feedback" role="alert"> <strong id="txt-password-error"></strong></span>
							</div>
						</div>

						<div class="row mt-3 mb-1">
							<div class="col-md-12 text-center">
								<input type="hidden" name="_token" id="csrf-set-password-token" value="{{ csrf_token() }}">
								<button id="btn-submit-set-password" class="btn btn-primary btn-block">SUBMIT</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
