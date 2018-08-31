$('#show-password').click(function () {
	if ( $('#password').attr('type') == "password" ) {
		$('#password').attr('type', 'text');
	} else {
		$('#password').attr('type', 'password');
	}
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