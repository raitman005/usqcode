var frmSetPassword = document.getElementById('frm-set-password');
var setPasswordUrl = '/setpassword';


frmSetPassword.addEventListener('submit', (event) => {
	document.getElementById('btn-submit-set-password').setAttribute("disabled", "");

	var data = {
		password: document.getElementById('txtbox-set-password').value,
		_token: document.getElementById('csrf-set-password-token').value
	};

	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xhr.open('POST', setPasswordUrl);
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200) { 
			setPasswordRender(JSON.parse(xhr.responseText)); 
		} else if (xhr.readyState>3 && xhr.status==422) { 
			setPasswordRenderError(JSON.parse(xhr.responseText)); 
		}
	};
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.send(JSON.stringify(data));
	
	event.preventDefault();
	return false;
}, true);

function setPasswordRender(data)
{
	if (data.result) {
		location.reload();
	} 
}

function setPasswordRenderError(data)
{
	if(data.hasOwnProperty('errors') ){
		if (data.errors.hasOwnProperty('password')) {
			var txtboxSetPassword = document.getElementById('txtbox-set-password');
			document.getElementById('txt-password-error').innerHTML = data.errors.password[0];
			txtboxSetPassword.classList.add('is-invalid');
		}
	}
	else {
		var txtboxSetPassword = document.getElementById('txtbox-set-password');
		document.getElementById('txt-password-error').innerHTML = "Error!";
		txtboxSetPassword.classList.add('is-invalid');
	}
	document.getElementById('btn-submit-set-password').removeAttribute("disabled");
}

