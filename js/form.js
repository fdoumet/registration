// var instead of let/const for better older browsers compatibility
var passwordTextField;
function togglePasswordTextFieldVisibility() {
    if (passwordTextField.attr('type') == "password") {
        passwordTextField.attr('type', 'text');
    } else {
        passwordTextField.attr('type', 'password');
    }
}

$(document).ready(function() {
    passwordTextField = $("#password");
    $("#show").change(togglePasswordTextFieldVisibility);
    $("#showadminpass").change(togglePasswordTextFieldVisibility);
});

//Set button disabled
$("input[type=submit]").prop('disabled', true);

//Append a change event listener to you inputs
$('#terms').change(function(){
	let privacyChecked = $('#privacy').is(":checked");
	let enableSubmit = this.checked && privacyChecked;
	$('#submit')[ enableSubmit? 'addClass' : 'removeClass' ]('enabled').prop('disabled', !enableSubmit);
});

//Append a change event listener to you inputs
$('#privacy').change(function(){
	let termsChecked = $('#terms').is(":checked");
	let enableSubmit = this.checked && termsChecked;
	$('#submit')[ enableSubmit? 'addClass' : 'removeClass' ]('enabled').prop('disabled', !enableSubmit);
});