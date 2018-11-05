/* global OC */

/**
 * Copyright (c) 2011, Robin Appelman <icewind1991@gmail.com>
 *               2013, Morris Jobke <morris.jobke@gmail.com>
 *               2016, Christoph Wurst <christoph@owncloud.com>
 *               2017, Arthur Schiwon <blizzz@arthur-schiwon.de>
 *               2017, Thomas Citharel <tcit@tcit.fr>
 * This file is licensed under the Affero General Public License version 3 or later.
 * See the COPYING-README file.
 */

$(document).ready(function () {

	let removeloader = function () {
		setTimeout(function(){
			if ($('.password-state').length > 0) {
				$('.password-state').remove();
			}
		}, 5000)
	};

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(String(email).toLowerCase());
	}

	$("#referbutton").click(function () {
		let email = $('#email').val();
		if (email !== '' && validateEmail(email)) {
			// Serialize the data
			let post = $("#passwordform").serialize();
			$("#referbutton").attr('disabled', 'disabled');
			$("#referbutton").after("<span class='password-loading icon icon-loading-small-dark password-state'></span>");
			// Ajax foo
			$.post(OC.generateUrl('/apps/registration/referral'), post, function (data) {
				if (data.status === "success") {
					$("#referbutton").after("<span class='checkmark icon icon-checkmark password-state'></span>");
					removeloader();
					$('#email').val('').change();
				}
				if (!data.data.message.includes('not sent')) {
					OC.msg.finishedSaving('#refer-error-msg', data);
					// Append new row to table
					let markup = "<tr> <td>" + email + "</td> <td>Pending</td></tr>";
					$("table tbody").append(markup);
				} else {
					OC.msg.finishedSaving('#refer-error-msg',
						{
							'status' : 'error',
							'data' : data.data
						}
					);
				}
				$(".password-loading").remove();
				$("#referbutton").removeAttr('disabled');
			});
			return false;
		} else {
			OC.msg.finishedSaving('#refer-error-msg',
				{
					'status' : 'error',
					'data' : {
						'message' : t('settings', 'Unable to refer friend')
					}
				}
			);
			return false;
		}
	});

	$("#toggleReferrerStatus").click(function () {
		let x = document.getElementById("referral-status");
		if (x.style.display === "none") {
			x.style.display = "block";
			this.textContent = 'Hide Referral Status'
		} else {
			x.style.display = "none";
			this.textContent = 'View Referral Status'
		}
	});
});