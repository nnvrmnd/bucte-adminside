

$(function () {
	$('#sudo_auth').submit(function (e) {
		e.preventDefault();

		let auth_signin = $(this).serialize();

		$.ajax({
			type: 'POST',
			url: './assets/hndlr/AuthSignin.php',
			data: auth_signin,
			success: function (res) {
				switch (res) {
					case 'true':
						$('#auth-alert').html('');
						$('span.auth-icon')
							.removeClass('text-danger')
							.addClass('text-success');
						$(location).attr('href', 'welcome.php');
						break;

					default:
						console.error('ERR', res);
						$('#auth-alert').html('Incorrect credentials');
						$('[name="sudo_username"]').select();
						$('[name="sudo_password"]').val('');
						$('span.auth-icon')
							.removeClass('text-success')
							.addClass('text-danger');
						break;
				}
			},
			error: function () {
				console.log('err: handling');
			}
		});
	});

	setTimeout(() => {
		$('[name="sudo_username"]').focus();
	}, 500);
});
