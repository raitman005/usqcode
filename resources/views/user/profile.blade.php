@extends('frontpage.layouts.app')
@section('title', 'Profile')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css">

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
			@if ($user->user_type_id == Helper::getUserType('agent')->id)
				<div class="col-sm-4">
					<div class="card" style="">
						<div class="card-img-caption-profile">
							<div class="card-text-profile">
								<p class="card-text-profile-name">{{ $user->firstname }} {{ $user->lastname }}</p>
								<p class="card-text-profile-company">{{ $user->company }}</p>
							</div>
							<img class="card-img-top" src="{{ Helper::agentAvatar($user) }}" alt="Card image cap">
						</div>
							
						<div class="card-body">
							<p class="card-text text-right no-margin"> 
								<small>
									<label id="a-upload-avatar">
										<input type="file" name="avatar" id="file-upload-avatar"/>
										<span class="far fa-image"></span>	change photo
									</label>
								
									</small>
							</p>
							<p class="card-text"> <span class="fa fa-envelope mr-3"></span> {{ $user->email }}.</p>
							<p class="card-text"> <span class="fa fa-phone mr-3"></span> {{ $user->phone_number ? $user->phone_number : '---' }}</p>
						</div>
					</div>
				</div>
			@endif
			<div class="{{ ($user->user_type_id != Helper::getUserType('agent')->id) ? 'offset-md-2 ' : '' }} col-sm-8">
				<div class="card mb-4 card-profile">
					<div class="card-body">
						<a data-toggle="collapse" href="#collapse-profile" aria-expanded="true" aria-controls="collapse-profile" id="heading-example" class="d-block card-profile-title">
							<i class="fa fa-chevron-down float-right"></i>
							Edit Profile
						</a>
						<div id="collapse-profile" class="collapse show " aria-labelledby="heading-example">
							<form method="POST" action="{{ route('user.profile.update') }}" id="frm-edit-profile">
								<div class="form-group mt-3">
									<label for="txtbox-firstname">First name</label>
									<input type="text" class="form-control form-line-only" id="txtbox-firstname" name="firstname" value="{{ $user->firstname }}">
								</div>
								
								<div class="form-group mt-3">
									<label for="txtbox-lastname">Last name</label>
									<input type="text" class="form-control form-line-only" id="txtbox-lastname" name="lastname" value="{{ $user->lastname }}">
								</div>

								<div class="form-group mt-3">
									<label for="txtbox-phone_number">Phone number</label>
									<input type="text" class="form-control form-line-only" id="txtbox-phone_number" name="phone_number" value="{{ $user->phone_number }}">
								</div>

								@if ($user->user_type_id == Helper::getUserType('agent')->id)
									<div class="form-group mt-3">
										<label for="txtbox-company">Company</label>
										<input type="text" class="form-control form-line-only" id="txtbox-company" name="company" value="{{ $user->company }}">
									</div>
									<div class="form-group mt-3">
										<label for="txtbox-real-estate-license-number">Real estate license number</label>
										<input type="text" class="form-control form-line-only" id="txtbox-real-estate-license-number" name="real_estate_license_number" value="{{ $user->real_estate_license_number }}">
									</div>
								@endif

								<div class="form-group mt-5 text-center">
									@csrf
									<button type="submit" class="btn btn-outline-primary">Save Profile</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="card mb-2 card-profile">
					<div class="card-body">
						<a data-toggle="collapse" href="#collapse-change-password" aria-expanded="true" aria-controls="collapse-change-password" id="heading-example" class="d-block card-profile-title">
							<i class="fa fa-chevron-down float-right"></i>
							Change password
						</a>
						<div id="collapse-change-password" class="collapse show" aria-labelledby="heading-example">
							<form method="POST" action="{{ route('user.password.change') }}" id="frm-change-password">
								<div class="form-group mt-3">
									<label for="txtbox-current-password">Current password</label>
									<input type="password" class="form-control form-line-only {{ $errors->has('current_password') ? ' is-invalid' : '' }}" id="txtbox-current-password" name="current_password">
									@if ($errors->has('current_password'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('current_password') }}</strong>
										</span>
									@endif
								</div>
								
								<div class="form-group mt-3">
									<label for="txtbox-new-password">New password</label>
									<input type="password" class="form-control form-line-only {{ $errors->has('new_password') ? ' is-invalid' : '' }}" id="txtbox-new-password" name="new_password">
									@if ($errors->has('new_password'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('new_password') }}</strong>
										</span>
									@endif
								</div>

								<div class="form-group mt-3">
									<label for="txtbox-new-passowrd">Confirm New password</label>
									<input type="password" class="form-control form-line-only" id="txtbox-new-passowrd" name="new_password_confirmation">
								</div>

								<div class="form-group mt-5 text-center">
									@csrf
									<button type="submit" class="btn btn-outline-primary">Change Password</button>
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal" id="upload-avatar-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><span class="fa fa-times"></span></span>
				</button>
				<div class=" px-5 py-5" id="change-avatar-content">
					<div class="row mt-3">
						<div class="col-md-12 text-center">
							<h5 class="login-reg-title">CROP YOUR PHOTO</h5>
						</div>
					</div>

					<div class="row mt-4">
						<div class="col-md-12 text-center">
							<div id="upload-wrapper" class="center-block"></div>
						</div>
					</div>

					<div class="row mt-3 mb-1">
						<div class="col-md-12 text-center">
							@csrf
							<button type="button" id="btn-upload" class="btn btn-primary">UPLOAD PHOTO</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('extra_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js"></script>

<script>
var $uploadCrop,
tempFilename,
rawImg,
imageId;
var uploadAvatarUrl = "{{ route('user.profile.update.avatar') }}";
var csrfToken = "{{ csrf_token() }}";

function readFile(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			rawImg = e.target.result;
			$('#upload-avatar-modal').modal('show');
		}
		reader.readAsDataURL(input.files[0]);
	}
	else {
		alet("Sorry - you're browser doesn't support the FileReader API");
	}
}

$uploadCrop = $('#upload-wrapper').croppie({
	viewport: {
		width: 250,
		height: 250,
	},
	boundary: { 
		width: 600, height: 400 
	},
	enableExif: true
});

$('#upload-avatar-modal').on('shown.bs.modal', function(){
	$uploadCrop.croppie('bind', {
		url: rawImg
	}).then(function(){
		console.log('jQuery bind complete');
	});
});

$('#file-upload-avatar').on('change', function () { 
	imageId = $(this).data('id'); 
	tempFilename = $(this).val();
	$('#cancelCropBtn').data('id', imageId); 
	readFile(this); 
});

$('#btn-upload').on('click', function() {
	$uploadCrop.croppie('result', {
		type: 'base64',
		size: {width: 250, height: 250}
	}).then(function (resp) {
		$.ajax({
            type:'POST',
            url: uploadAvatarUrl,
            data: {
				data: resp,
				_token: csrfToken,
			},
			beforeSend: function() {
				$('#btn-upload').prop("disabled", "disabled");
			},
            success: function(data) {
				$('#btn-upload').prop("disabled", false);
                location.reload();
            },
            error: function(data) {
				$('#btn-upload').prop("disabled", false);
                iziToast.error({
					title: 'Error',
					message: 'Error uploading',
					position: 'topCenter'
				});
            }
        });
	});
})
</script>
@endsection
