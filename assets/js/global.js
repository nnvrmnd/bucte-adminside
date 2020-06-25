$(function () {
	/* Display current user */
	WhoAmI('topnav');

	/* Set cookie for fileDownload */
	// document.cookie = 'fileDownload=true; path=/';

	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Accounts.php',
		data: { priv: $('#whoiam').val() },
		success: function (res) {
			if (res === 'true') {
				$('ul#sidenav').append(`
					<li class="nav-item">
						<a class="nav-link Accounts" href="./accounts.php">
							<i class="far fa-user text-purple"></i>
							<span class="nav-link-text">Accounts Management</span>
						</a>
					</li>
					`);

				if (documenttitle.match(/\b(\w*Account\w*)\b/g)) {
					$('.Accounts')
						.addClass('font-weight-bold active')
						.attr('aria-expanded', 'true');
				}
			}
		}
	});

	/* Signout */
	$('#sudo_exit').click(function (e) {
		e.preventDefault();
		$.post(
			'./assets/hndlr/AuthSignin.php',
			{
				sudo_exit: 'y'
			},
			function (res) {
				location.reload();
			}
		);
	});

	/* Reset modal forms on close */
	$('div.modal').on('hidden.bs.modal', function () {
		$(this).find('form').trigger('reset');
	});

	/* Sidebar active tab */
	let documenttitle = document.title;
	if (documenttitle.match(/\b(\w*Welcome\w*)\b/g)) {
		$('.Dashboard').addClass('font-weight-bold active');
	} else if (documenttitle.match(/\b(\w*Records\w*)\b/g)) {
		$('.Records').addClass('font-weight-bold active');
	} else if (documenttitle.match(/\b(\w*E-LET\w*)\b/g)) {
		$('.E-learning').addClass('font-weight-bold active');
	} else if (documenttitle.match(/\b(\w*Events\w*)\b/g)) {
		$('.Events').addClass('font-weight-bold active');
	} else if (documenttitle.match(/\b(\w*Assessment\w*)\b/g)) {
		$('.Events').addClass('font-weight-bold active');
	} else if (documenttitle.match(/\b(\w*Home\w*)\b/g)) {
		$('.Pages')
			.addClass('font-weight-bold active')
			.attr('aria-expanded', 'true');
		$('#Pages').addClass('show').find('#pages_home').addClass('active');
	} else if (documenttitle.match(/\b(\w*About\w*)\b/g)) {
		$('.Pages')
			.addClass('font-weight-bold active')
			.attr('aria-expanded', 'true');
		$('#Pages').addClass('show').find('#pages_about').addClass('active');
	} else if (documenttitle.match(/\b(\w*Documents\w*)\b/g)) {
		$('.Records')
			.addClass('font-weight-bold active')
			.attr('aria-expanded', 'true');
		$('#Records')
			.addClass('show')
			.find('#records_documents')
			.addClass('active');
	} else if (documenttitle.match(/\b(\w*Archives\w*)\b/g)) {
		$('.Records')
			.addClass('font-weight-bold active')
			.attr('aria-expanded', 'true');
		$('#Records').addClass('show').find('#records_archives').addClass('active');
	} else if (documenttitle.match(/\b(\w*Library\w*)\b/g)) {
		$('.Library')
			.addClass('font-weight-bold active')
			.attr('aria-expanded', 'true');
	}
});

/* *************************************************** */

/* Display who */
function WhoAmI(location) {
	let regex = /^\s*$/,
		whoiam = $('#whoiam').val();
	if (!whoiam.match(regex) === true) {
		$.post('./assets/hndlr/Global.php', { who: whoiam }, function (res) {
			let el = res != 'INTRUDER!' ? JSON.parse(res) : '';
			switch (location) {
				case 'topnav':
					$('#topnav-who').html(`${el.given}`);
					$('#topnav-avatar').attr('src', `./assets/img/${el.gender}.png`);
					break;

				default:
					break;
			}
		});
	}
}

/* Fetch id of username */
function AuthorId(form_id) {
	let currentauthor = $('#whoiam').val();

	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Global.php',
		data: { username: currentauthor },
		success: function (res) {
			let input_name = $('body').find(`${form_id} [name="author"]`),
				input_class = $('body').find(`${form_id} .author`);
			$.each(input_name, function (idx, el) {
				el.value = res;
			});
			$.each(input_class, function (idx, el) {
				el.value = res;
			});
		}
	});
}

/* Fetch name of id */
function AuthorName(id) {
	let name;

	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Global.php',
		data: {
			userid: id
		},
		async: false,
		success: function (res) {
			name = res;
		}
	});

	return name;
}

/* *************************************************** */

let timer = null; // for timeouts

function WaitModal(timeout, msg = 0, redirect = 0) {
	let message = msg === 0 ? 'Processing...' : msg;

	if (redirect !== 0) {
		$('#WaitModal').on('hidden.bs.modal', function () {
			window.location.href = redirect;
		});
	}

	$('.modal').modal('hide');
	window.clearTimeout(timer);
	$('#wait-modal-msg').html(message);
	$('#WaitModal').modal('show');
	$('#SuccessModal, #ErrorModal').on('shown.bs.modal', function () {
		$('#WaitModal').modal('hide');
	});

	timer = setTimeout(() => {
		$('#wait-modal-msg').html('');
		$('#WaitModal').modal('hide');
		timer = null;
	}, timeout - 1000);
}

function SuccessModal(msg, timeout, redirect = 0) {
	if (redirect !== 0) {
		$('#SuccessModal').on('hidden.bs.modal', function () {
			window.location.href = redirect;
		});
	}

	window.clearTimeout(timer);
	$('#success-modal-msg').html(msg);
	setTimeout(() => {
		$('.modal').modal('hide');
		$('#SuccessModal').modal('show');
	}, 1000);

	timer = setTimeout(() => {
		$('#success-modal-msg').html('');
		$('#SuccessModal').modal('hide');
		timer = null;
	}, timeout - 500);
}

function ErrorModal(timeout, msg = 0, redirect = 0) {
	let message = msg === 0 ? 'Something went wrong.' : msg;

	if (redirect !== 0) {
		$('#SuccessModal').on('hidden.bs.modal', function () {
			window.location.href = redirect;
		});
	}

	window.clearTimeout(timer);
	$('#error-modal-msg').html(message);
	setTimeout(() => {
		$('.modal').modal('hide');
		$('#ErrorModal').modal('show');
	}, 1000);

	timer = setTimeout(() => {
		$('#error-modal-msg').html('');
		$('#ErrorModal').modal('hide');
		timer = null;
	}, timeout - 1000);
}

function PromptModal(timeout, action, id, msg, redirect = 0) {
	$('#yes_prompt').attr('data-action', action).attr('data-target', id);

	if (redirect !== 0) {
		$('#PromptModal').on('hidden.bs.modal', function () {
			window.location.href = redirect;
		});
	}

	window.clearTimeout(timer);
	$('#prompt-modal-msg').html(msg);
	$('.modal').modal('hide');
	$('#PromptModal').modal('show');

	timer = setTimeout(() => {
		$('#prompt-modal-msg').html('');
		$('#PromptModal').modal('hide');
		timer = null;
	}, timeout - 1000);
}

function PromptConfirm(msg, url) {
	function Confirmed(msg, url, action, id) {
		return new Promise((resolve, reject) => {
			$.post(url, { action, id }, function (res) {
				switch (res) {
					case 'true':
						SuccessModal(msg, 5000);
						resolve('true');
						break;

					default:
						reject('err:confirm');
						break;
				}
			});
		});
	}

	async function ConfirmPrompt(msg, url, action, id) {
		try {
			const confirmRes = await Confirmed(msg, url, action, id);
		} catch (e) {
			console.error('ERR', e.message);
			ErrorModal(5000);
		}
	}

	$('#prompt_form #yes_prompt').click(function (e) {
		e.preventDefault();

		WaitModal(5000);

		let action = $(this).attr('data-action'),
			id = $(this).attr('data-target');

		ConfirmPrompt(msg, url, action, id);
	});
}

/* *************************************************** */

/* Window ready */
function DocumentReady() {
	setTimeout(() => {
		$('.loader').fadeOut('slow');
		$('#preloader').delay(400).fadeOut('slow');
	}, 1000);
}

/* Encrpyt */
function Encrypt(param) {
	return CryptoJS.AES.encrypt(param, "In JESUS' Name!").toString();
}
/* Decrypt */
function Decrypt(param) {
	return CryptoJS.AES.decrypt(param, "In JESUS' Name!").toString(
		CryptoJS.enc.Utf8
	);
}

/* ASCII code to Unicode */
function unicode(name) {
	let this_name = $(`[name="${name}"]`).val();

	this_name
		.replace(/\!/g, '&#33;')
		.replace(/"/g, '&#34;')
		.replace(/\#/g, '&#35;')
		.replace(/\$/g, '&#36;')
		.replace(/\%/g, '&#37;')
		.replace(/&/g, '&#38;')
		.replace(/'/g, '&#39;')
		.replace(/\(/g, '&#40;')
		.replace(/\)/g, '&#41;')
		.replace(/\*/g, '&#42;')
		.replace(/\+/g, '&#43;')
		.replace(/,/g, '&#44;')
		.replace(/-/g, '&#45;')
		.replace(/./g, '&#46;')
		.replace(/\//g, '&#47;')
		.replace(/:/g, '&#58;')
		.replace(/;/g, '&#59;')
		.replace(/\</g, '&#60;')
		.replace(/\=/g, '&#61;')
		.replace(/\>/g, '&#62;')
		.replace(/\?/g, '&#63;')
		.replace(/\@/g, '&#64;')
		.replace(/\[/g, '&#91;')
		.replace(/\\/g, '&#92;')
		.replace(/\]/g, '&#93;')
		.replace(/\^/g, '&#94;')
		.replace(/_/g, '&#95;')
		.replace(/`/g, '&#96;')
		.replace(/\{/g, '&#123;')
		.replace(/|/g, '&#124;')
		.replace(/\}/g, '&#125;')
		.replace(/~/g, '&#126;');
}

/* Filedownload */
function fileDownload(dir, file) {
	console.log(dir, file);
	/* fetch(dir)
		.then((resp) => resp.blob())
		.then((blob) => {
			const url = window.URL.createObjectURL(blob);
			const a = document.createElement('a');
			a.style.display = 'none';
			a.href = url;
			// the filename you want
			a.download = file;
			document.body.appendChild(a);
			a.click();
			window.URL.revokeObjectURL(url);
			// alert('Your file is being downloaded.'); // or you know, something with better UX...
		})
		.catch(() => alert('File does not exist anymore!')); */
}

/* *************************************************** */

/* Validate username */
function ValidateUsername(formId, nameProp, account = 0) {
	return new Promise((resolve, reject) => {
		let ctrl = true,
			$element = $(`#${formId} [name=${nameProp}]`),
			$msg = $(`small.${nameProp}`),
			input = $element.val(),
			required = !input.match(/^\s*$/) ? true : false,
			length = input.length >= 5 ? true : false,
			regex = new RegExp(/^[a-z0-9_]{5,16}$/gi);

		function UsernameAvailability(input, account) {
			$.ajax({
				type: 'POST',
				url: './assets/hndlr/Accounts.php',
				data: { id: account, username: input },
				success: function (res) {
					if (res == 'true') {
						resolve('true'); // available
						$element.removeClass('is-invalid');
						$msg
							.removeClass('text-danger')
							.addClass('text-success')
							.html('Available');
						setTimeout(() => {
							$msg.empty();
						}, 2000);
					} else if (res == 'false') {
						resolve('false');
						$element.addClass('is-invalid');
						$msg
							.removeClass('text-success')
							.addClass('text-danger')
							.html('Username not available.');
					} else {
						reject({
							where: 'UsernameAvailability',
							message: res
						});
					}
				}
			});
		}

		switch (false) {
			case required:
				$element.addClass('is-invalid');
				$msg
					.removeClass('text-success')
					.addClass('text-danger')
					.html('Field required.');
				resolve('false');
				break;
			case length:
				$element.addClass('is-invalid');
				$msg
					.removeClass('text-success')
					.addClass('text-danger')
					.html('Use at least 5 characters or more for your username.');
				resolve('false');
				break;
			case regex.test(input):
				$element.addClass('is-invalid');
				$msg
					.removeClass('text-success')
					.addClass('text-danger')
					.html('You can use letters, numbers & underscores.');
				resolve('false');
				break;

			default:
				UsernameAvailability(input, account);
				// $element.removeClass('is-invalid');
				// $msg.removeClass('text-success').addClass('text-danger').empty();
				break;
		}
	});
}

/* Validate email */
function ValidateEmail(formId, nameProp, account = 0) {
	return new Promise((resolve, reject) => {
		let ctrl = true,
			$element = $(`#${formId} [name=${nameProp}]`),
			$msg = $(`small.${nameProp}`),
			input = $element.val(),
			required = !input.match(/^\s*$/) ? true : false,
			regex = new RegExp(
				/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/gi
			);

		function EmailAvailability(input, account) {
			$.ajax({
				type: 'POST',
				url: './assets/hndlr/Accounts.php',
				data: { id: account, email: input },
				success: function (res) {
					if (res == 'true') {
						resolve('true'); // available
						$element.removeClass('is-invalid');
						$msg
							.removeClass('text-danger')
							.addClass('text-success')
							.html('Available');
						setTimeout(() => {
							$msg.empty();
						}, 2000);
					} else if (res == 'false') {
						resolve('false');
						$element.addClass('is-invalid');
						$msg
							.removeClass('text-success')
							.addClass('text-danger')
							.html('Email already registered.');
					} else {
						reject({
							where: 'EmailAvailability',
							message: res
						});
					}
				}
			});
		}

		switch (false) {
			case required:
				$element.addClass('is-invalid');
				$msg
					.removeClass('text-success')
					.addClass('text-danger')
					.html('Field required.');
				resolve('false');
				break;
			case regex.test(input):
				$element.addClass('is-invalid');
				$msg
					.removeClass('text-success')
					.addClass('text-danger')
					.html('Not a valid email address.');
				resolve('false');
				break;

			default:
				EmailAvailability(input, account);
				break;
		}
	});
}

/* Validate title input */
function ValidateTitle(form_id, name) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr = formid + `[name="${name}"]`,
		input = $(name_attr).val(),
		regex = new RegExp(/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/g),
		required = input.length != 0 ? true : false;

	switch (false) {
		case required:
			$(name_attr).addClass('is-invalid');
			$(formid + 'small.' + name)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('Field required.');
			ctrl = false;
			break;
		case regex.test(input):
			$(name_attr).addClass('is-invalid');
			$(formid + 'small.' + name)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('Not a valid name.');
			ctrl = false;
			break;

		default:
			$(name_attr).removeClass('is-invalid');
			$(formid + 'small.' + name)
				.removeClass('text-success')
				.html('');
			break;
	}

	return ctrl;
}

/* Validate required input */
function ValidateRequired(form_id, name) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr = formid + `[name="${name}"]`,
		input = $(name_attr).val(),
		regex = /^\s*$/,
		required = !input.match(regex) ? true : false;

	switch (false) {
		case required:
			$(name_attr).addClass('is-invalid');
			$(formid + 'small.' + name)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('Field required.');
			ctrl = false;
			break;

		default:
			unicode(name);
			$(name_attr).removeClass('is-invalid');
			$(formid + 'small.' + name)
				.removeClass('text-success')
				.html('');
			break;
	}

	return ctrl;
}

/* Validate CKEDITOR required */
function ValidateCKE(form_id, name) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr = formid + `[name="${name}"]`,
		input = $(name_attr).val(),
		regex = /^\s*$/,
		required = !input.match(regex) ? true : false;

	switch (false) {
		case required:
			$(formid)
				.find('#cke_' + name)
				.css('border-color', '#fb6340');
			$(formid + 'small.' + name)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('Field required.');
			ctrl = false;
			break;

		default:
			$(formid)
				.find('#cke_' + name)
				.removeAttr('style');
			$(formid + 'small.' + name)
				.removeClass('text-success')
				.html('');
			break;
	}

	return ctrl;
}

/* Validate required input */
function ValidateDatetime(form_id, name) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr = formid + `[name="${name}"]`,
		input = $(name_attr).val(),
		regex = /^\s*$/,
		required = !input.match(regex) ? true : false;

	switch (false) {
		case required:
			$(name_attr).addClass('is-invalid');
			$(formid + 'small.' + name)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('Invalid or incomplete input.');
			ctrl = false;
			break;

		default:
			$(name_attr).removeClass('is-invalid');
			$(formid + 'small.' + name)
				.removeClass('text-success')
				.html('');
			break;
	}

	return ctrl;
}
