/* Fetch list */
function RenderList(sortBy = 'post', orderBy = 'desc', search = 0) {
	// change thumbnail according to file format
	function file_format(format) {
		if (format.match(/\b(\w*image\w*)\b/gi)) {
			return 'jpg.png';
		} else if (format.match(/\b(\w*presentation\w*)\b/gi)) {
			return 'ppt.png';
		} else if (format.match(/\b(\w*word\w*)\b/gi)) {
			return 'res.png';
		} else if (format.match(/\b(\w*zip\w*)\b/gi)) {
			return 'zip.png';
		} else if (format.match(/\b(\w*text\w*)\b/gi)) {
			return 'txt.png';
		} else if (format.match(/\b(\w*spreadsheet\w*)\b/gi)) {
			return 'xls.png';
		} else if (format.match(/\b(\w*pdf\w*)\b/gi)) {
			return 'pdf.png';
		}
	}

	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Resource.php',
		data: { fetchresources: 'all' },
		success: function (res) {
			$('.resources-container').empty();
			try {
				let resources = JSON.parse(res),
					search_regex = new RegExp(search, 'gi');

				resources.sort((a, b) => {
					let A, B, arg;

					switch (sortBy) {
						case 'title':
							A = a.title;
							B = b.title;
							break;
						case 'type':
							A = a.format;
							B = b.format;
							break;

						default:
							A = a.uploaded_at;
							B = b.uploaded_at;
							break;
					}

					arg = orderBy == 'desc' ? A < B : A > B;

					if (arg) {
						return 1;
					} else {
						return -1;
					}
				});

				if (search != 0) {
					resources = resources.filter(resource => {
						if (resource.title.match(search_regex)) {
							return true;
						}
					});

					if (resources.length == 0) {
						$('.resources-container').html(`
						<div class="col notfound mb-5 pb-5">
							<div class="d-none d-sm-block notfound-404">
								<h1>Oops!</h1>
							</div>
							<h2 class="ml-2">No results found</h2>
							<p class="ml-2">No items to display</p>
						</div>
						`);
					}
				}

				$.each(resources, function (idx, el) {
					let dir = el.restype == 'resource' ? 'resources' : el.restype,
						attachment_title = el.title,
						attachment_format = el.attachment,
						attachment_filename,
						uploaded_date,
						uploaded_time,
						uploaded_at;

					attachment_title = attachment_title.replace(/[^A-Za-z0-9_.-]/g, '_');
					attachment_format = attachment_format.split('.');
					attachment_filename = `${attachment_title}.${attachment_format[1]}`;

					uploaded_date = moment(el.uploaded_at).format('Do MMM YYYY');
					uploaded_time = moment(el.uploaded_at).format('h:mm A');
					uploaded_at = `${uploaded_date} at ${uploaded_time}`;

					async function Render() {
						try {
							let Author = await AuthorName(el.author);

							$('.resources-container').append(`
								<div class="col-sm-6 col-md-4 col-lg-3 resource-card">
									<div class="card card-shadow">

										<div class="custom-control custom-checkbox m-2">
											<input type="checkbox" class="custom-control-input checkboxes" id="check_${
												el.res_id
											}"
												data-id="${el.res_id}">
											<label class="custom-control-label" for="check_${
												el.res_id
											}" title="Select to archive or delete file/s..."></label>
										</div>

										<div class="d-flex align-items-center justify-content-center pointer-here readmore"
											data-target="${el.res_id}" title="Click to read more...">
											<img class="card-img-top mx-auto mt-4"
												src="./assets/img/file_format/${file_format(
													el.format
												)}" alt="Filetype thumbnail">
										</div>

										<div class="card-body pb-1">
											<p class="font-weight-bold card-title text-truncate mb-0 pointer-here readmore"
												data-id="${
													el.res_id
												}" data-target="${el.res_id}" title="${el.title}">${el.title}</p>
											<small class="text-muted">by ${Author} on ${uploaded_at}</small> <br>
											<a href="../files/library/${el.attachment}" download="${attachment_filename}"
												class="btn btn-link px-0 float-right download_file" title="Download file...">
												<i class="fas fa-cloud-download-alt fa-lg"></i>
											</a>
										</div>
									</div>
								</div>
								`);
						} catch (e) {
							console.error('ERR', e.message);
						}
					}

					Render();
				});
			} catch (e) {
				console.error('ERR', e.message);
				$('.resources-container').html(`
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

/* Filter form */
let form, sortby, orderby, search;
function UpdateFilter() {
	form = $('form.filter').serializeArray();
	sortby = form[1].value;
	orderby = $('.filter #order').attr('data-state');
	search = form[0].value;
	search = search.match(/^\s*$/) ? 0 : search;
}

$(function () {
	RenderList();
	$('form.filter').trigger('reset');

	/* Sort */
	$('.filter [name=sort]').change(function (e) {
		e.preventDefault();

		UpdateFilter();
		RenderList(sortby, orderby, search);
		not_checked();
	});

	/* Order */
	$('.filter #order').click(function (e) {
		e.preventDefault();

		UpdateFilter();

		switch (orderby) {
			case 'desc':
				RenderList(sortby, 'asc', search);
				not_checked();
				$(this)
					.attr('data-state', 'asc')
					.attr('title', 'Ascending order')
					.html('<span class="fas fa-long-arrow-alt-up"></span>');
				break;

			default:
				RenderList(sortby, 'desc', search);
				not_checked();
				$(this)
					.attr('data-state', 'desc')
					.attr('title', 'Descending order')
					.html('<span class="fas fa-long-arrow-alt-down"></span>');
				break;
		}
	});

	/* Search */
	let typingtimer;
	function DoneTyping() {
		RenderList(sortby, orderby, search);
		not_checked();
	}

	$('.filter [name=search]')
		.keyup(function (e) {
			UpdateFilter();
			clearTimeout(typingtimer);
			typingtimer = setTimeout(DoneTyping, 1000);
		})
		.keydown(function () {
			$('.resources-container').empty();
			clearTimeout(typingtimer);
		});

	$('.resources-container').on('click', '.download_file', function (e) {
		e.stopPropagation();
	});

	/* On modal open/close */
	$('#UploadFile, #EditFile, #ArchiveFile')
		.on('shown.bs.modal', function () {
			let formid = 'form#' + $(this).find('form').attr('id');

			AuthorId(formid);
		})
		.on('hidden.bs.modal', function () {
			let formid = 'form#' + $(this).find('form').attr('id');
			$(formid + ' .form-control').removeClass('is-invalid is-valid');
			$(formid).find('.cke_1').removeAttr('style');
			$(
				'small.select_file, small.title, small.description, small.archive_name'
			).html('');
		});

	$('#dummy, [name="edit_dummy"]').click(function (e) {
		e.preventDefault();
		let file_input = $(this).attr('data-target');
		$(`[name="${file_input}"]`).click();
	});

	/* Display file name for new event */
	$('.file_select').on('change', function () {
		let regex = /[\/\\]([\w\d\s\'\.\,\-\(\)]+)$/,
			target_dummy = $(this).attr('data-target'),
			dummy = $(`[name="${target_dummy}"]`),
			fakepath = $(this).val(),
			filename,
			selected = () => {
				if (fakepath.match(regex) != null) {
					filename = fakepath.match(regex)[1];

					if (filename.length >= 12) {
						// if file name is long
						return (
							filename.substr(0, 11) +
							'...' +
							filename.substr(filename.length - 11)
						);
					} else {
						return filename;
					}
				} else {
					return 'invalid';
				}
			};

		if (fakepath) {
			let slctd = selected();
			switch (slctd) {
				case 'invalid':
					dummy.val('').addClass('is-invalid');
					$('small.select_file')
						.addClass('text-danger')
						.html('Invalid filename. Rename file.');
					$(this).val('');
					break;

				default:
					dummy.val(slctd);
					dummy.removeClass('is-invalid');
					$('small.select_file').html('');
					break;
			}
		} else {
			// clear dummy if empty
			dummy.val('');
			dummy.removeClass('is-invalid');
			$('small.select_file').html('');
		}
	});

	/* Add new event */
	$('#upload_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serializeArray(),
			form_data = new FormData(),
			file = $('#select_file')[0].files[0];

		switch (false) {
			case ValidateRequired('upload_form', 'title'):
			case ValidateAttachment('upload_form', 'select_file', 'dummy'):
				break;

			default:
				WaitModal(5000);

				form_data.append('select_file', file);
				$.each(form, function (key, input) {
					form_data.append(input.name, input.value);
				});

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Resource.php',
					data: form_data,
					contentType: false,
					processData: false,
					success: function (res) {
						switch (res) {
							case 'true':
								SuccessModal('Uploaded new resource.', 5000);
								RenderList(sortby, orderby, search);
								not_checked();
								break;

							default:
								ErrorModal(5000);
								console.log(res);
								break;
						}
					}
				});
				break;
		}
	});

	$('#upload_form [name="select_file"]').change(function (e) {
		e.preventDefault();
		ValidateAttachment('upload_form', 'select_file', 'dummy');
	});

	/* Fetch event for edit modal */
	$('.edit_resource').click(function (e) {
		let resource = $(this).attr('data-target');

		$.ajax({
			type: 'POST',
			url: './assets/hndlr/Resource.php',
			data: { resource },
			success: function (res) {
				if (res != 'err:fetch') {
					$.each(JSON.parse(res), function (idx, el) {
						$(`#edit_form [name="resource_id"]`).val(el.resource_id);
						$(`#edit_form [name="edt_title"]`).val(el.title);
						$(`#edit_form [name="edt_description"]`).val(el.description);
					});
				} else {
					ErrorModal(5000);
					console.error('ERR', res);
				}
			},
			complete: function () {
				$('#EditResource').modal('show');
			}
		});
	});

	/* Edit resource */
	$('#edit_form').submit(function (e) {
		e.preventDefault();

		let empty = /^\s*$/,
			form = $(this).serialize();

		switch (false) {
			case ValidateRequired('edit_form', 'edt_title'):
				$('.modal').animate({ scrollTop: $('#edt_title').offset().top }, 500);
				break;

			default:
				WaitModal(5000);

				$.post('./assets/hndlr/Resource.php', form, function (res) {
					switch (res) {
						case 'true':
							SuccessModal('Updated resource.', 5000);
							RenderList(sortby, orderby, search);
							not_checked();
							break;

						default:
							ErrorModal(5000);
							break;
					}
				});
				break;
		}
	});

	/* Delete resource */
	$('.delete_resource').click(function (e) {
		e.preventDefault();

		let del = $(this).attr('data-target');
		PromptModal(
			10000,
			'delete_resource',
			del,
			'Are you deleting this resource?'
		);
		PromptConfirm('Resource deleted.', './assets/hndlr/Resource.php');
		$('#SuccessModal, #ErrorModal').on('hidden.bs.modal', function () {
			RenderList(sortby, orderby, search);
		});
	});

	/* Read more */
	$('.resources-container').on('click', '.readmore', function (e) {
		e.preventDefault();

		let id = $(this).attr('data-target');

		if (!e.ctrlKey) {
			e.stopPropagation();

			$.ajax({
				type: 'POST',
				url: './assets/hndlr/Resource.php',
				data: { resource: id },
				success: function (res) {
					if (res != 'err:fetch') {
						let id,
							title,
							description,
							dir,
							attachment,
							attachment_title,
							attachment_format,
							attachment_filename;

						$.each(JSON.parse(res), function (idx, el) {
							id = el.resource_id;
							title = el.title;
							dir = el.restype == 'resource' ? 'resources' : el.restype;
							attachment = el.attachment;
							attachment_title = el.title;
							attachment_format = el.attachment;
							description = el.description;
						});

						attachment_title = attachment_title.replace(
							/[^A-Za-z0-9_.-]/g,
							'_'
						);
						attachment_format = attachment_format.split('.');
						attachment_filename = `${attachment_title}.${attachment_format[1]}`;
						description = !description.match(/^\s*$/)
							? description.replace(/&nbsp;/g, ' ')
							: '<p><i>No description...</i></p>';

						$('#ReadMore')
							.on('shown.bs.modal', function () {
								$(this)
									.find('.modal-title')
									.html(
										'<i class="text-muted">Read more:</i><br>&emsp;' + title
									);
								$(this).find('.modal-body').html(description);
								$(this).find('blockquote').addClass('blockquote');
								$(this).find('.edit_delete').attr('data-target', id);
								$(this)
									.find('.download_btn')
									.attr('href', `../files/${dir}/${attachment}`)
									.attr('download', attachment_filename);
							})
							.on('hidden.bs.modal', function () {
								$(this).find('.modal-title').html('');
								$(this).find('.modal-body').html('');
								$(this).find('blockquote').addClass('blockquote');
								$(this).find('.edit_delete').removeAttr('data-target');
								$(this)
									.find('.download_btn')
									.removeAttr('href')
									.removeAttr('download');
							});
					} else {
						console.error('ERR', res);
					}
				},
				complete: function () {
					$('#ReadMore').modal('show');
				}
			});
		}
	});
}); // ready function

$(function () {
	/* Show arhive & delete button */
	$('.resources-container').on('click', '.resource-card', function (e) {
		let checkbox = $(this).find('.checkboxes'),
			archive = () => {
				$('.checkboxes:checked').length > 0
					? $('#delete_btn').removeClass('d-none')
					: $('#delete_btn').addClass('d-none');
			};

		if (e.ctrlKey) {
			checkbox.is(':checked')
				? checkbox.prop('checked', false)
				: checkbox.prop('checked', true);
			archive();
		} else {
			archive();
		}
	});

	/* Open archive name modal */
	$('#delete_btn').click(function (e) {
		let checked = $('.resources-container').find('.checkboxes:checked'),
			checked_data = $.map(checked, function (el) {
				return $(el).data('id');
			});

		function Confirmed(data) {
			return new Promise((resolve, reject) => {
				$.post(
					'./assets/hndlr/Resource.php',
					{ delete: JSON.stringify(data) },
					function (res) {
						if (res === 'true') {
							SuccessModal('Files deleted.', 5000);
							not_checked();
							resolve('true');
						} else {
							reject('err:confirm');
						}
					}
				);
			});
		}

		async function ConfirmPrompt(data) {
			try {
				const confirmRes = await Confirmed(data);
			} catch (e) {
				console.error('ERR', e.message);
				ErrorModal(5000);
			}
		}

		PromptModal(5000, 'delete_selected', 0, 'Delete selected file/s?');
		$('#prompt_form #yes_prompt')
			.off()
			.click(function (e) {
				WaitModal(5000);
				ConfirmPrompt(checked_data);
				$('#SuccessModal, #ErrorModal').on('hidden.bs.modal', function () {
					RenderList(sortby, orderby, search);
				});
			});
	});

	DocumentReady();
});

function not_checked() {
	$('#archive_btn, #delete_btn').addClass('d-none');
}

function ValidateZipname(form_id, name) {
	let empty = /^\s*$/,
		formid = `form#${form_id} `,
		name_attr = formid + `[name="${name}"]`,
		input = $(name_attr).val();

	return new Promise((resolve, reject) => {
		if (!input.match(empty)) {
			$.post(
				'./assets/hndlr/Resource.php',
				{ new_archivename: input },
				function (res) {
					if (res === 'false') {
						$(name_attr).removeClass('is-invalid');
						$('small.' + name)
							.removeClass('text-danger')
							.html('');
						resolve(true);
					} else if (res === 'true') {
						$(name_attr).addClass('is-invalid');
						$('small.' + name)
							.removeClass('text-success')
							.addClass('text-danger')
							.html(`An archive alreay contain the name '${input}.'`);
						resolve(false);
					} else {
						ErrorModal(5000);
						// console.error('ERR', res);
						reject({
							where: 'ValidateZipname',
							message: res
						});
					}
				}
			);
		} else {
			$(name_attr).addClass('is-invalid');
			$('small.' + name)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('Field required.');
		}
	});
}

function ValidateAttachment(form_id, name, dummy_name) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr = formid + `[name="${name}"]`,
		dummy = formid + `[name="${dummy_name}"]`,
		valid = (dummy, name) => {
			$(dummy).removeClass('is-invalid');
			$('small.' + name)
				.removeClass('text-danger')
				.html('');
		};

	if ($(name_attr).val().length >= 1) {
		let file_format = $(name_attr)[0].files[0].type;

		if (file_format.match(/\b(\w*text\w*)\b/gi)) {
			$('[name="file_format"]').val('text');
			valid(dummy, name);
		} else if (file_format.match(/\b(\w*image\w*)\b/gi)) {
			$('[name="file_format"]').val('image');
			valid(dummy, name);
		} else if (file_format.match(/\b(\w*pdf\w*)\b/gi)) {
			$('[name="file_format"]').val('pdf');
			valid(dummy, name);
		} else if (file_format.match(/\b(\w*word\w*)\b/gi)) {
			$('[name="file_format"]').val('word');
			valid(dummy, name);
		} else if (file_format.match(/\b(\w*presentationml\w*)\b/gi)) {
			$('[name="file_format"]').val('presentation');
			valid(dummy, name);
		} else if (file_format.match(/\b(\w*spreadsheetml\w*)\b/gi)) {
			$('[name="file_format"]').val('spreadsheet');
			valid(dummy, name);
		} else if (file_format.match(/\b(\w*ms-excel\w*)\b/gi)) {
			$('[name="file_format"]').val('spreadsheet');
			valid(dummy, name);
		} else if (file_format.match(/\b(\w*zip\w*)\b/gi)) {
			$('[name="file_format"]').val('zip');
			valid(dummy, name);
		} else {
			ctrl = false;
			$(dummy).addClass('is-invalid');
			$('small.' + name)
				.removeClass('text-success')
				.addClass('text-danger')
				.html(
					'Invalid file format. (zip, image, text, pdf, word, presentation, spreadsheet)'
				);
		}
	} else {
		ctrl = false;
		$(dummy).addClass('is-invalid');
		$('small.' + name)
			.removeClass('text-success')
			.addClass('text-danger')
			.html('Select a file.');
	}

	return ctrl;
}
