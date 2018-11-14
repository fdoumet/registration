$(document).ready(function() {
	function gtag_report_conversion(url) {
		let callback = function () {
			if (typeof(url) != 'undefined') {
				window.location = url;
			}
		};
		gtag('event', 'conversion', {
			'send_to': 'AW-780087164/ZQ2tCI2_gI8BEPze_PMC',
			'event_callback': callback
		});
		return false;
	}

	$("#submit").click(function () {
		gtag_report_conversion();
	});
});