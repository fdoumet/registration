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

	function gtag(){
		dataLayer.push(arguments);
	}

	$.getScript("https://www.googletagmanager.com/gtag/js?id=AW-780087164");
	window.dataLayer = window.dataLayer || [];

	gtag('js', new Date());
	gtag('config', 'AW-780087164');

	$("#submit").click(function () {
		gtag_report_conversion();
	});
});