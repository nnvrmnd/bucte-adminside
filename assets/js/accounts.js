function RenderList() {
	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Accounts.php',
		data: { fetchaccounts: 'all' },
		success: function (res) {
			$('.accounts-container').html('');

			try {
				$('.accts-container').find('.card').removeClass('d-none');

				$.each(JSON.parse(res), function (idx, el) {
					let status = el.status == 1 ? 'Active' : 'Deactivated';

					$('.accounts-container').append(`
					<tr class="table-row pointer-here">
						<td class="text-truncate mx-5 px-5" colspan="2" title="${el.given} ${el.surname}">
							<img class="avatar mr-3" src="./assets/img/${el.gender}.png" alt="Avatar thumbnail">
							<b>${el.given} ${el.surname}</b>
						</td>
						<td title="${el.username}">${el.username}</td>
						<td class="text-truncate" title="${el.email}">${el.email}</td>
						<td>${el.type}</td>
						<td>${status}</td>
						<td class="table-actions">
							<a href="#" class="btn btn-sm btn-secondary text-primary update_acct" data-target="${el.account_id}" title="Update account...">
								<i class="fas fa-edit"></i>
							</a>
							<a href="#" class="btn btn-sm btn-secondary text-red delete_acct d-none" title="Delete account...">
								<i class="fas fa-trash"></i>
							</a>
						</td>
					</td>
					`);
				});
			} catch (e) {
				console.error('ERR', res);
				$('.accts-container').find('.card').addClass('d-none').html(`
					<div class="col notfound mb-5 pb-5">
						<div class="d-none d-sm-block notfound-404">
							<h1>Oops!</h1>
						</div>
						<h2 class="ml-2">Oops! List is empty</h2>
						<p class="ml-2">No items to display</p>
					</div>
					`);
			}
		}
	});
}

$(function () {
	RenderList();

	/* Priv */
	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Accounts.php',
		data: { priv: $('#whoiam').val() },
		success: function (res) {
			if (res === 'false') {
				$('#sudo_exit').click();
			}
		}
	});

	$('#UpdateAcct, #NewAcct')
		.on('hidden.bs.modal', function () {
			$('input.is-invalid').removeClass('is-invalid');
			$('small.msg').empty();
		})
		.on('shown.bs.modal', function () {
			let formid = 'form#' + $(this).find('form').attr('id');

			AuthorId(formid);
		});

	$('input.gender').click(function (e) {
		e.preventDefault();

		let gender = $(this).attr('data-gender'),
			change_gender = gender == 'f' ? 'm' : 'f',
			change_value = gender == 'f' ? 'Male' : 'Female';

		$(this).attr('data-gender', change_gender).val(change_value);
	});

	$('input.status').click(function (e) {
		e.preventDefault();

		let status = $(this).attr('data-status'),
			new_status = status == 1 ? 0 : 1,
			new_value = status == 1 ? 'Deactivate' : 'Activate';

		$(this).attr('data-status', new_status).val(new_value);
	});

	/* New account */
	$('#new_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serializeArray(),
			formid = $(this).attr('id'),
			gender = $('[name=gender]').attr('data-gender'),
			status = $('[name=status]').attr('data-status');
		form.push(
			{ name: 'gender2', value: gender },
			{ name: 'status2', value: status }
		);

		function Submit(createForm) {
			return new Promise((resolve, reject) => {
				WaitModal(5000);

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Accounts.php',
					data: createForm,
					success: function (res) {
						console.log(createForm);

						if (res === 'true') {
							resolve('created');
							SuccessModal('Account created.', 5000);
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

		async function Process(formId, usernameProp, emailProp, createForm) {
			try {
				const usernameRes = await UsernameAvailability(formId, usernameProp);
				const emailRes = await EmailAvailability(formId, emailProp);
				if (usernameRes != 'false' && emailRes != 'false') {
					const submitRes = await Submit(createForm);
				}
			} catch (e) {
				console.error(`${e.where}\n${e.message}`);
				ErrorModal(5000);
			}
		}

		switch (false) {
			case ValidateRequired(formid, 'given'):
			case ValidateRequired(formid, 'surname'):
			case ValidateUsername(formid, 'username'):
			case ValidateEmail(formid, 'email'):
				break;

			default:
				Process(formid, 'username', 'email', form);
				break;
		}
	});

	/* Fetch data for update */
	$('.accounts-container').on('click', '.update_acct', function () {
		let id = $(this).attr('data-target');

		$.ajax({
			type: 'POST',
			url: './assets/hndlr/Accounts.php',
			data: { fetchaccount: id },
			success: function (res) {
				$.each(JSON.parse(res), function (idx, el) {
					let status = el.status == 1 ? 'Active' : 'Deactivated';
					$('[name=account]').val(el.account_id);
					$('#reset_btn').attr('data-target', el.username);
					$('[name=edt_given]').val(el.given);
					$('[name=edt_surname]').val(el.surname);
					$('[name=edt_username]').val(el.username);
					$('[name=edt_email]').val(el.email);
					$('[name=edt_status]').val(status).attr('data-status', el.status);
				});

				$('[name="edt_status"]').click(function (e) {
					e.preventDefault();

					let status = $(this).attr('data-status'),
						new_status = status == 1 ? 0 : 1,
						new_value = status == 1 ? 'Deactivate' : 'Activate';

					$(this).attr('data-status', new_status).val(new_value);
				});
			}
		});

		$('#UpdateAcct').modal('show');
	});

	/* Update account */
	$('#edit_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serializeArray(),
			formid = $(this).attr('id'),
			status = $('[name=edt_status]').attr('data-status'),
			account = $('[name=account]').val();
		form.push({ name: 'edt_status2', value: status });

		function Submit(updateForm) {
			return new Promise((resolve, reject) => {
				WaitModal(5000);

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Accounts.php',
					data: updateForm,
					success: function (res) {
						if (res === 'true') {
							resolve('updated');
							SuccessModal('Account updated.', 5000);
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
				const usernameRes = await UsernameAvailability(
					formId,
					usernameProp,
					account
				);
				const emailRes = await EmailAvailability(formId, emailProp, account);
				if (usernameRes != 'false' && emailRes != 'false') {
					const submitRes = await Submit(updateForm);
				}
			} catch (e) {
				if (e.message == 'err:update') {
					ErrorModal(5000, 'No changes applied.');
				} else {
					console.error(`${e.where}\n${e.message}`);
					ErrorModal(5000);
				}
			}
		}

		switch (false) {
			case ValidateRequired(formid, 'edt_given'):
			case ValidateRequired(formid, 'edt_surname'):
			case ValidateUsername(formid, 'edt_username'):
			case ValidateEmail(formid, 'edt_email'):
				break;

			default:
				Process(formid, 'edt_username', 'edt_email', account, form);
				break;
		}
	});

	$('#reset_btn').click(function (e) {
		e.preventDefault();
		let reset = $(this).attr('data-target');
		PromptModal(10000, 'reset', reset, 'Reset password?');
		PromptConfirm('Password has been reset.', './assets/hndlr/Accounts.php');
	});

	DocumentReady();
});
