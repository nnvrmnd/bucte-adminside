

$(function () {
	/* Display current user */
	WhoAmI('topnav');

	/* Set cookie for fileDownload */
	document.cookie = 'fileDownload=true; path=/';

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
	if (documenttitle.match(/\b(\w*Dashboard\w*)\b/g)) {
		$('.Dashboard').addClass('font-weight-bold active');
	} else if (documenttitle.match(/\b(\w*Records\w*)\b/g)) {
		$('.Records').addClass('font-weight-bold active');
	} else if (documenttitle.match(/\b(\w*E-LET\w*)\b/g)) {
		$('.E-learning').addClass('font-weight-bold active');
	} else if (documenttitle.match(/\b(\w*Events\w*)\b/g)) {
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
		$('#Records').addClass('show').find('#records_documents').addClass('active');
	} else if (documenttitle.match(/\b(\w*Archives\w*)\b/g)) {
		$('.Records')
			.addClass('font-weight-bold active')
			.attr('aria-expanded', 'true');
		$('#Records').addClass('show').find('#records_archives').addClass('active');
	} else if (documenttitle.match(/\b(\w*Resource\w*)\b/g)) {
		$('.Resource')
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
			let input_name = $('body').find(form_id + ' [name="author"]'),
				input_class = $('body').find(form_id + ' .author');
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

var timer = null; // for timeouts

function WaitModal(msg, redirect, timeout) {
	if (redirect !== 0) {
		$('#WaitModal').on('hidden.bs.modal', function () {
			window.location.href = redirect;
		});
	}

	$('.modal').modal('hide');
	window.clearTimeout(timer);
	$('#SuccessModal, #ErrorModal').on('shown.bs.modal', function () {
		$('#WaitModal').modal('hide');
	});
	$('#wait-modal-msg').html(msg);
	$('#WaitModal').modal('show');


	timer = setTimeout(() => {
		$('#wait-modal-msg').html('');
		$('#WaitModal').modal('hide');
		timer = null;
	}, timeout - 1000);
}

function SuccessModal(msg, redirect, timeout) {
	if (redirect !== 0) {
		$('#SuccessModal').on('hidden.bs.modal', function () {
			window.location.href = redirect;
		});
	}

	$('.modal').modal('hide');
	window.clearTimeout(timer);
	$('#success-modal-msg').html(msg);
	$('#SuccessModal').modal('show');

	timer = setTimeout(() => {
		$('#success-modal-msg').html('');
		$('#SuccessModal').modal('hide');
		timer = null;
	}, timeout - 1000);
}

function ErrorModal(msg, redirect, timeout) {
	let message = msg === 0 ? 'Something went wrong.' : msg;

	if (redirect !== 0) {
		$('#SuccessModal').on('hidden.bs.modal', function () {
			window.location.href = redirect;
		});
	}

	$('.modal').modal('hide');
	window.clearTimeout(timer);
	$('#error-modal-msg').html(message);
	$('#ErrorModal').modal('show');

	timer = setTimeout(() => {
		$('#error-modal-msg').html('');
		$('#ErrorModal').modal('hide');
		timer = null;
	}, timeout - 1000);
}

function PromptModal(msg, redirect, timeout, action, id) {
	$('#yes_prompt').attr('data-action', action).attr('data-target', id);

	if (redirect !== 0) {
		$('#PromptModal').on('hidden.bs.modal', function () {
			window.location.href = redirect;
		});
	}

	window.clearTimeout(timer);
	$('#prompt-modal-msg').html(msg);
	/* $('.modal').modal('hide'); */
	$('#PromptModal').modal('show');

	timer = setTimeout(() => {
		$('#prompt-modal-msg').html('');
		$('#PromptModal').modal('hide');
		timer = null;
	}, timeout - 1000);
}

function PromptConfirm(msg, url) {
	$('#prompt_form #yes_prompt').click(function (e) {
		e.preventDefault();

		WaitModal('Processing...', 0, 5000);

		let action = $(this).attr('data-action'),
		id = $(this).attr('data-target');

		$.post(url, { action, id }, function (res) {
			switch (res) {
				case 'true':
					SuccessModal(msg, 0, 5000);
					RenderList();
					break;

				default:
					console.error('ERR', res);
					ErrorModal(0, 0, 5000);
					break;
			}
		});
	});
}

/* *************************************************** */

/* Window ready */
function DocumentReady() {
	$('.loader').fadeOut('slow');
	$('#preloader').delay(400).fadeOut('slow');
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
