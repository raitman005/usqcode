var frmLoginRegister = document.getElementById('frm-login-register');
var frmLoginPassword = document.getElementById('frm-login-password');

var loginRegisterUrl = '/registerlogin';
var loginPasswordUrl = '/login';
var forgotPasswordUrl = '/password/email';

/**
 * Login or register
 */
frmLoginRegister.addEventListener('submit', (event) => {
	document.getElementById('btn-submit-login-reg').setAttribute("disabled", "");

	var data = {
		email: document.getElementById('txtbox-auth-email').value,
		_token: document.getElementById('csrf-auth-token').value
	};

	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xhr.open('POST', loginRegisterUrl);
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200) { 
			loginRegisterRender(JSON.parse(xhr.responseText)); 
		} else if (xhr.readyState>3 && xhr.status==422) { 
			loginRegisterRenderError(JSON.parse(xhr.responseText)); 
		}
	};
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.send(JSON.stringify(data));
	
	event.preventDefault();
	return false;
}, true);

/**
 * Password based
 */
document.addEventListener('submit',function(e){
	if(e.target && e.target.id== 'frm-login-password'){
		var txtboxEmailElement = document.getElementById('txtbox-login-password');
		txtboxEmailElement.classList.remove('is-invalid');

		document.getElementById('btn-submit-login-password').setAttribute("disabled", "");
		var data = {
			email: document.getElementById('txtbox-login-email').value,
			password: document.getElementById('txtbox-login-password').value,
			_token: document.getElementById('csrf-login-password-token').value
		};

		var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
		xhr.open('POST', loginPasswordUrl);
		xhr.onreadystatechange = function() {
			if (xhr.readyState>3 && xhr.status==200) { 
				loginPasswordRender(JSON.parse(xhr.responseText)); 
			} else if (xhr.readyState>3 && xhr.status==422) { 
				loginPasswordRenderError(JSON.parse(xhr.responseText)); 
			} else {
				loginPasswordRenderError(); 
			}
		};
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('Content-Type', 'application/json');
		xhr.send(JSON.stringify(data));
		
		event.preventDefault();
		return false;
	}
});

document.addEventListener('click',function(e){
	if(e.target && e.target.id== 'link-forgot-password'){
		event.preventDefault(); 
		setTimeout(function(){
			document.getElementById('div-forgot-password-msg').classList.remove('d-none');
			document.getElementById('div-password-form').classList.add('d-none');
		}, 800);
		
		
		var data = {
			email: document.getElementById('txtbox-forgotpassword-email').value,
			_token: document.getElementById('csrf-forgotpassword-token').value
		};
		var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
		xhr.open('POST', forgotPasswordUrl);
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('Content-Type', 'application/json');
		xhr.send(JSON.stringify(data));

		return false;
	}
});

function loginRegisterRender(data)
{
	var contentWrapper = document.getElementById('login-register-content');
	if (data.status == 1) {
		location.reload();
	} else if(data.status == 2) {
		contentWrapper.innerHTML = data.html;
	} else if(data.status == 3) {
		contentWrapper.innerHTML = data.html;
		document.getElementById('txtbox-login-password').focus();
	}
}

function loginRegisterRenderError(data)
{
	if(data.hasOwnProperty('errors') ){
		if (data.errors.hasOwnProperty('email')) {
			var txtboxEmailElement = document.getElementById('txtbox-auth-email');
			document.getElementById('txt-email-error').innerHTML = data.errors.email[0];
			txtboxEmailElement.classList.add('is-invalid');
		}
	}
	document.getElementById('btn-submit-login-reg').removeAttribute("disabled");
}




function loginPasswordRender(data)
{
	if (data.result) {
		location.reload();
	} else {
		var txtboxEmailElement = document.getElementById('txtbox-login-password');
		document.getElementById('txt-password-error').innerHTML = "Incorrect password!";
		txtboxEmailElement.classList.add('is-invalid');
	}
}

function loginPasswordRenderError(data = {})
{
	if(data.hasOwnProperty('errors') ){
		if (data.errors.hasOwnProperty('password')) {
			var txtboxEmailElement = document.getElementById('txtbox-login-password');
			document.getElementById('txt-password-error').innerHTML = data.errors.password[0];
			txtboxEmailElement.classList.add('is-invalid');
		}
	} else {
		document.getElementById('txt-password-error').innerHTML = "An error occured!";
	}
	document.getElementById('btn-submit-login-password').removeAttribute("disabled");
}