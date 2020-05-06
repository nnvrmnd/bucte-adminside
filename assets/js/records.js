'use_strict';

/* Fetch list */
function RenderList() {
	// change thumbnail according to file format
	function file_format(format) {
		if (format.match(/\b(\w*image\w*)\b/gi)) {
			return 'jpg.png';
		} else if (format.match(/\b(\w*presentation\w*)\b/gi)) {
			return 'ppt.png';
		} else if (format.match(/\b(\w*word\w*)\b/gi)) {
			return 'doc.png';
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

	$.post(
		'./assets/hndlr/Records.php',
		{
			fetchrecords: 'all'
		},
		function (res) {
			$('.records-container').html('');

			if (!res.match(/\b(\w*err:fetch\w*)\b/g)) {
				$.each(JSON.parse(res), function (idx, el) {
					let dir = el.doctype == 'record' ? 'records' : el.doctype,
						attachment_title = el.title,
						attachment_format = el.attachment,
						attachment_filename;

					attachment_title = attachment_title.replace(/[^A-Za-z0-9_.-]/g, '_');
					attachment_format = attachment_format.split('.');
					attachment_filename = `${attachment_title}.${attachment_format[1]}`;

					$('.records-container').append(`
					<div class="col-sm-5 col-md-4 col-lg-3 record-card">
						<div class="card card-shadow">

							<div class="custom-control custom-checkbox m-2">
								<input type="checkbox" class="custom-control-input checkboxes" id="check_${
									el.doc_id
								}"
									data-id="${el.doc_id}">
								<label class="custom-control-label" for="check_${
									el.doc_id
								}" title="Select to archive file/s..."></label>
							</div>

							<div class="d-flex align-items-center justify-content-center pointer-here readmore"
								data-target="${el.doc_id}" title="Click to read more...">
								<img class="card-img-top mx-auto mt-4"
									src="./assets/img/file_format/${file_format(
										el.format
									)}" alt="Filetype thumbnail">
							</div>

							<div class="card-body pb-1">
								<p class="font-weight-bold card-title text-truncate mb-0 pointer-here readmore"
									data-id="${
										el.doc_id
									}" data-target="${el.doc_id}" title="${el.title}">${el.title}</p>
								<small class="text-muted">by ${AuthorName(
									el.author
								)} on ${el.uploaded_at}</small> <br>
								<a href="./files/${dir}/${el.attachment}" download="${attachment_filename}"
									class="btn btn-link px-0 float-right download_file" title="Download file...">
									<i class="fas fa-cloud-download-alt fa-lg"></i>
								</a>
							</div>
						</div>
					</div>
				`);
				});
			} else {
				if ($('body').hasClass('modal-open') === true) {
					$('.modal').on('shown.bs.modal', function () {
						let modalid = $(this).attr('id');
						if (modalid == 'SuccessModal') {
							$('#SuccessModal').on('hidden.bs.modal', function () {
								ErrorModal('List is empty.', 0, 10000);
							});
						}
					});
				} else {
					if ($('body').hasClass('modal-open') === true) {
						$('.modal').on('shown.bs.modal', function () {
							let modalid = $(this).attr('id');
							if (modalid == 'SuccessModal') {
								$('#SuccessModal').on('hidden.bs.modal', function () {
									ErrorModal('List is empty.', 0, 10000);
								});
							}
						});
					} else {
						ErrorModal('List is empty.', 0, 10000);
					}
				}
			}
		}
	);
}

$(function () {
	RenderList();

	$('.records-container').on('click', '.download_file', function (e) {
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
			$('small.select_file, small.title, small.description, small.archive_name').html('');

			// ClearCKE();
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
				form_data.append('select_file', file);
				$.each(form, function (key, input) {
					form_data.append(input.name, input.value);
				});

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Records.php',
					data: form_data,
					contentType: false,
					processData: false,
					success: function (res) {
						switch (res) {
							case 'true':
								SuccessModal('Uploaded new document.', 0, 5000);
								RenderList();
								console.log('true', res);
								break;

							default:
								ErrorModal(0, 0, 5000);
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
	$('.edit_record').click(function (e) {
		let record = $(this).attr('data-target');

		$('#EditRecord')
			.modal('show')
			.on('shown.bs.modal', function () {
				let formid = $(this).find('form').attr('id');

				$.post(
					'./assets/hndlr/Records.php',
					{
						record
					},
					function (res) {
						if (res != 'err:fetch') {
							$.each(JSON.parse(res), function (idx, el) {
								$(`#${formid} [name="record_id"]`).val(el.record_id);
								$(`#${formid} [name="edt_title"]`).val(el.title);
								$(`#${formid} [name="edt_description"]`).val(el.description);
							});
						} else {
							console.log('err:fetch', res);
						}
					}
				);
			});
	});

	/* Edit record */
	$('#edit_form').submit(function (e) {
		e.preventDefault();

		let empty = /^\s*$/,
			form = $(this).serialize();

		switch (false) {
			case ValidateRequired('edit_form', 'edt_title'):
				$('.modal').animate({ scrollTop: $('#edt_title').offset().top }, 500 );
				break;

			default:
				$.post('./assets/hndlr/Records.php', form, function (res) {
					switch (res) {
						case 'true':
							SuccessModal('Updated record.', 0, 5000);
							RenderList();
							break;

						default:
							ErrorModal(0, 0, 5000);
							console.log('ERR', res);
							break;
					}
				});
				break;
		}
	});

	/* Delete record */
	$('.delete_record').click(function (e) {
		e.preventDefault();

		let del = $(this).attr('data-target');
		PromptModal(
			'Are you deleting this record?',
			0,
			10000,
			'delete_record',
			del
		);
		PromptConfirm('Record deleted.', './assets/hndlr/Records.php');
	});

	/* Read more */
	$('.records-container').on('click', '.readmore', function (e) {
		e.preventDefault();

		let id = $(this).attr('data-target');

		if (!e.ctrlKey) {
			e.stopPropagation();
			$.post(
				'./assets/hndlr/Records.php',
				{
					record: id
				},
				function (res) {
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
							id = el.record_id;
							title = el.title;
							dir = el.doctype == 'record' ? 'records' : el.doctype;
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

						$('#ReadMore').modal('show');

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
									.attr('href', `./files/${dir}/${attachment}`)
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
						console.log(res);
					}
				}
			);
		}
	});
}); // ready function

$(function () {
	$('.records-container').on('click', '.record-card', function (e) {
		let checkbox = $(this).find('.checkboxes'),
			archive = () => {
				$('.checkboxes:checked').length > 0
					? $('#archive_btn').removeClass('d-none')
					: $('#archive_btn').addClass('d-none');
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

	$('#archive_btn').click(function (e) {
		$('#ArchiveFile').modal('show');
	});

	$('#archival_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serialize(),
		checked = $('.records-container').find('.checkboxes:checked'),
			checked_data = $.map(checked, function (el) {
				return $(el).data('id');
			}),
			archive_json = {};

		archive_json['files'] = checked_data;

		switch (false) {
			case ValidateRequired('archival_form', 'archive_name'):
				break;

			default:
				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Records.php',
					data: form,
					success: function (res) {
						archive_json['archive_id'] = parseInt(res);

						switch (res) {
							case 'true':
								SuccessModal('Updated record.', 0, 5000);
							break;

							default:
								break;
						}

						$.ajax({
							type: 'POST',
							url: './assets/hndlr/Records.php',
							data: { archive: JSON.stringify(archive_json) },
							success: function (res) {
								console.log(res);
							}
						});

					}
				});
				break;
		}
	});
});

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
