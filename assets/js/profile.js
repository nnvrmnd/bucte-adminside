function RenderList() {
	let who = $('#whoiam').val();
	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Profile.php',
		data: { fetchaccount: who },
		success: function (res) {
			try {
				$.each(JSON.parse(res), function (idx, el) {
					$('[name="account"]').val(el.id);
					$('[name="given"]').val(el.given);
					$('[name="surname"]').val(el.surname);
					$('[name="email"]').val(el.email);
					$('[name="username"]').val(el.username);
					$('#profile-avatar').attr('src', `./assets/img/${el.gender}.png`);
					$('#name').html(el.given + '&nbsp;' + el.surname);
					$('#position').html(el.position);
				});
			} catch (e) {
				console.error('ERR', res);
				$('#SuccessModal').on('hidden.bs.modal', function () {
					$('#ErrorModal').on('hidden.bs.modal', function () {
						$('#sudo_exit').click();
					});
					ErrorModal(5000, 'Due to changes you have to re-login.');
				});
			}
		}
	});
}

$(function () {
	RenderList();

	/* Change buttons' states */
	$('#edit_btn')
		.css('cursor', 'pointer')
		.click(function (e) {
			e.preventDefault();

			$('#form_btns').removeClass('d-none');
			$('.profileform').removeAttr('readonly');
			$('[name="username"]').select();
			$(this).addClass('d-none');
		});

	$('#cancel_btn').click(function (e) {
		e.preventDefault();

		RenderList();
		$('#form_btns').addClass('d-none');
		$('.profileform')
			.attr('readonly', true)
			.removeClass('is-invalid')
			.removeClass('is-valid');
		$('.msg').empty();
		$('#edit_btn').removeClass('d-none').focus();
		$('#submit_btn').attr('disabled', true);
	});

	$('.profileform').keydown(function (e) {
		$('#submit_btn').removeAttr('disabled');
	});

	$('#submit_btn').click(function (e) {
		e.preventDefault();
		$('#profile_form').submit();
	});

	/* Update account */
	$('#profile_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serialize(),
			formid = $(this).attr('id'),
			account = $('[name=account]').val();

		function Submit(updateForm) {
			return new Promise((resolve, reject) => {
				WaitModal(5000);

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Profile.php',
					data: updateForm,
					success: function (res) {
						if (res === 'true') {
							resolve('updated');
							SuccessModal('Changes applied.', 5000);
							RenderList();
						} else {
							reject({
								where: 'Submit',
								message: res
							});
						}
					}
				});
			});
		}

		async function Process(
			formId,
			usernameProp,
			emailProp,
			account,
			updateForm
		) {
			try {
				const usernameRes = await ValidateUsername(
					formId,
					usernameProp,
					account
				);
				const emailRes = await ValidateEmail(formId, emailProp, account);
				if (usernameRes != 'false' && emailRes != 'false') {
					const submitRes = await Submit(updateForm);
				}
			} catch (e) {
				if (e.message == 'err:update') {
					ErrorModal(3000, 'No changes applied.');
				} else {
					console.error(`${e.where}\n${e.message}`);
					ErrorModal(5000);
				}
			}
		}

		switch (false) {
			case ValidateRequired(formid, 'given'):
			case ValidateRequired(formid, 'surname'):
				break;

			default:
				Process(formid, 'username', 'email', account, form);
				break;
		}
	});

	$('#ChangePassword').on('hidden.bs.modal', function () {
		$(this).find('form .msg').empty();
		$(this).find('form input').removeClass('is-invalid');
	});

	/* Change password */
	$('#pass_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serializeArray(),
			formid = $(this).attr('id'),
			account = $('#whoiam').val();

		form.push({ name: 'account', value: account });

		function Submit(updateForm) {
			return new Promise((resolve, reject) => {
				WaitModal(5000);

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Profile.php',
					data: updateForm,
					success: function (res) {
						if (res === 'true') {
							resolve('updated');
							SuccessModal('Password changes.', 5000);
							RenderList();
						} else {
							reject({
								where: 'Submit',
								message: res
							});
						}
					}
				});
			});
		}

		function Current(formId, currentProp, account) {
			return new Promise((resolve, reject) => {
				let $element = $(`#${formId} [name=${currentProp}]`),
					input = $element.val(),
					$msg = $(`small.${currentProp}`);

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Profile.php',
					data: { id: account, current: input },
					success: function (res) {
						if (res === 'true') {
							resolve('true');
							$element.removeClass('is-invalid');
							$msg.removeClass('text-danger').empty();
						} else if (res === 'false') {
							resolve('false');
							$element.addClass('is-invalid');
							$msg
								.removeClass('text-success')
								.addClass('text-danger')
								.html('Incorrect password.');
						} else {
							reject({
								where: 'Current',
								message: res
							});
						}
					}
				});
			});
		}

		function ValidatePassword(formId, nameProp1, nameProp2) {
			let ctrl = true,
				$element1 = $(`#${formId} [name=${nameProp1}]`),
				$element2 = $(`#${formId} [name=${nameProp2}]`),
				input1 = $element1.val(),
				input2 = $element2.val(),
				$msg1 = $(`small.${nameProp1}`),
				$msg2 = $(`small.${nameProp2}`),
				regex = new RegExp(input1);

			switch (true) {
				case input1.length <= 4:
					$element1.addClass('is-invalid');
					$msg1
						.removeClass('text-success')
						.addClass('text-danger')
						.html('Enter a combination of at least 5 characters.');
					ctrl = false;
					break;
				case !regex.test(input2):
					$element1.addClass('is-invalid');
					$element2.addClass('is-invalid');
					$msg1.addClass('text-danger');
					$msg2.addClass('text-danger').html('Passwords do not match.');
					ctrl = false;
					break;

				default:
					$element1.removeClass('is-invalid');
					$element2.removeClass('is-invalid');
					$msg1.empty();
					$msg2.empty();
					break;
			}

			return ctrl;
		}

		async function Process(formId, currentProp, account, updateForm) {
			try {
				const currentRes = await Current(formId, currentProp, account);
				if (currentRes == 'true') {
					const submitRes = await Submit(updateForm);
				}
			} catch (e) {
				console.error(`${e.where}\n${e.message}`);
				ErrorModal(5000);
			}
		}

		switch (false) {
			case ValidateRequired(formid, 'current'):
			case ValidateRequired(formid, 'new'):
			case ValidateRequired(formid, 'confirm'):
			case ValidatePassword(formid, 'new', 'confirm'):
				break;

			default:
				Process(formid, 'current', account, form);
				break;
		}
	});

	DocumentReady();
});
