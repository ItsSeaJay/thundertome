var login = {
	request: function () {
		var url = $('form#login').attr('action');
		var data = $('form#login').serialize();
		var inputs = $('form#login').find('input');

		inputs.prop('disabled', true);

		var request = $.post(url, data, function(response) {
			$('#csrf_token').val(response.csrf_hash);

			if (respsonse.success) {
				window.location($('form#login').data('destination'));
			} else {
				$('#fail').html(response.message);
			}
		}, 'json');

		request.fail(function(response) {
			console.error(response);
		});

		request.always(function(response) {
			inputs.prop('disabled', false);
		});
	}
}

$(document).ready(function () {
	$('form#login').submit(function(event) {
		event.preventDefault();
		login.request();
	});
});
