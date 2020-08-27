<form method="POST" action="{{ url('login') }}" class="user">
    @csrf
    <div class="form-group">
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-user" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter Email Address...">
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-control-user" name="password" required placeholder="Password">
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <div class="custom-control custom-checkbox small">
            <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block">
        Login
    </button>
    <hr>
</form>
<div class="text-center">
    <a class="small" href="forgot-password.html">Forgot Password?</a>
</div>
<div class="text-center">
    <span>&copy; 2019 Union Square Property Management</span> <br/>
    <a class="small" href="forgot-password.html">Terms</a> |
    <a class="small" href="forgot-password.html">Privacy Policy</a>
</div>