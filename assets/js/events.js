'use_strict';

/* Fetch list */
function RenderList() {
	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Events.php',
		data: { fetchevents: 'all' },
		complete: function (res) {
			$('.desc').each(function (idx, el) {
				let target = $(el).attr('data-target'),
					condition = el.scrollWidth > el.clientWidth;
				if (condition === false) {
					$('.events-container')
						.find('#' + target)
						.html('&nbsp;');
				}
			});
		},
		success: function (res) {
			$('.events-container').html('');

			if (!res.match(/\b(\w*err:fetch\w*)\b/g)) {
				$.each(JSON.parse(res), function (idx, el) {
					let regex = /^\s*$/,
						event_id = el.event_id,
						desc_raw = el.description,
						desc_replace = desc_raw.replace(/<\/?[br|li|ol|ul|p|strong|blockquotes]+\/?>/gim, ''),
						deadline = el.deadline,
						start = el.start,
						end = el.end,
						start_date,
						start_time,
						end_date,
						end_time;

					start_date = moment(start, 'MM/DD/YYYY h:mm A').format('MMM DD');
					start_time = moment(start, 'MM/DD/YYYY h:mm A').format('h:mm A');
					end_date = moment(end, 'MM/DD/YYYY h:mm A').format('MMM DD');
					end_time = moment(end, 'MM/DD/YYYY h:mm A').format('h:mm A');
					deadline = moment(deadline, 'MM/DD/YYYY h:mm A').format(
						'MMM DD h:mm A'
					);

					$('.events-container').append(`
					<div class="card card-shadow" data-id="${event_id}">
						<div class="card-body">
							<div class="row">
								<div class="col-md-4 col-lg-4 d-flex align-items-center justify-content-center">
										<a href="../files/events/${
											el.image
										}" class="fancybox" data-fancybox="events_gallery" data-caption="${el.title}">
											<img alt="Image placeholder" src="../files/events/${
												el.image
											}" class="img-fluid rounded" title="Click to view image">
										</a>
								</div>
								<div class="col-md-8 col-lg-8 d-none d-sm-none d-md-block">
									<button type="button" class="btn btn-sm btn-secondary text-danger float-right delete_event"
										title="Delete event..." data-target="${event_id}">
										<i class="fa fa-trash" aria-hidden="true"></i>
									</button>
									<button type="button" class="btn btn-sm btn-secondary text-purple float-right edit_event"
										title="Edit event..." data-target="${event_id}">
										<i class="fa fa-edit" aria-hidden="true"></i>
									</button>
									<p class="font-weight-bold text-primary">${el.title}</p>
									<small>
										<dl class="row">
											<dt class="col-sm-3">Schedule:</dt>
											<dd class="col-sm-9">${start_date} - ${end_date}</dd>
											<dt class="col-sm-3">Time:</dt>
											<dd class="col-sm-9">${start_time} - ${end_time}</dd>
											<dt class="col-sm-3">Registration deadline:</dt>
											<dd class="col-sm-9">${deadline}</dd>
											<dt class="col-sm-3">Venue:</dt>
											<dd class="col-sm-9">${el.venue}</dd>
											<dt class="col-sm-3">Description:</dt>
											<dd class="col-sm-9 text-truncate desc" data-target="desc_${event_id}">${desc_replace}</dd>
											<dt class="col-sm-3"></dt>
											<dd class="col-sm-9">
												<a href="javascript:void(0)" class="readmore" id="desc_${event_id}" data-target="${event_id}">
													Read more
												</a>
											</dd>
										</dl>
									</small>
									<small class="text-muted">by ${AuthorName(
										el.author
									)} on ${el.created_at}</small>
								</div>
								<div class="col-md-9 mt-3 d-block d-sm-none d-none d-sm-block d-md-none">
									<button type="button" class="btn btn-sm btn-secondary text-danger float-right delete_event"
										title="Delete event..." data-target="${event_id}">
										<i class="fa fa-trash" aria-hidden="true"></i>
									</button>
									<button type="button" class="btn btn-sm btn-secondary text-purple float-right edit_event"
										title="Edit event..." data-target="${event_id}">
										<i class="fa fa-edit" aria-hidden="true"></i>
									</button>
									<p class="font-weight-bold text-primary">${
										el.title
									} </p>
									<small>
										<dl class="row">
											<dt class="col-sm-2">Schedule:</dt>
											<dd class="col-sm-10">${start_date} - ${end_date}</dd>
											<dt class="col-sm-2">Time:</dt>
											<dd class="col-sm-10">${start_time} - ${end_time}</dd>
											<dt class="col-sm-2">Registration deadline:</dt>
											<dd class="col-sm-10">${deadline}</dd>
											<dt class="col-sm-2">Venue:</dt>
											<dd class="col-sm-10">${el.venue}</dd>
											<dt class="col-sm-2">Description:</dt>
											<dd class="col-sm-10 text-truncate">${desc_replace}</dd>
											<dt class="col-sm-2"></dt>
											<dd class="col-sm-10"><a href="javascript:void(0)" class="readmore" data-target="${event_id}">Read more</a></dd>
										</dl>
									</small>
									<small class="text-muted">by ${AuthorName(
										el.author
									)} on ${el.created_at}</small>
								</div>
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
								ErrorModal('List is empty. Create a new event.', 0, 10000);
							});
						}
					});
				} else {
					if ($('body').hasClass('modal-open') === true) {
						$('.modal').on('shown.bs.modal', function () {
							let modalid = $(this).attr('id');
							if (modalid == 'SuccessModal') {
								$('#SuccessModal').on('hidden.bs.modal', function () {
									ErrorModal('List is empty. Create a new event.', 0, 10000);
								});
							}
						});
					} else {
						ErrorModal('List is empty. Create a new event.', 0, 10000);
					}
				}
			}
		}
	});
}

/* Triggers */
$(function () {
	RenderList();

	/* Fancybox */
	$('body').fancybox({
		selector: '[data-fancybox="events_gallery"]',
		buttons: ['zoom', 'thumbs', 'close'],
	});

	/* CKEditor */
	CKEDITOR.disableAutoInline = true;
	let ckwrites = $('body').find('.ckwrite');
	ckwrites.each(function (i, e) {
		CKEDITOR.replace(e.name, {
			customConfig: '/bucte/admin/assets/js/ck_events.js',
		});
	});

	/* Datetime picker */
	$('.datetimepicker').datetimepicker({
		icons: {
			time: 'fa fa-clock',
			date: 'fa fa-calendar-day',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'fa fa-screenshot',
			clear: 'fa fa-trash',
			close: 'fa fa-remove',
		},
		useCurrent: false,
	});

	$('#start_datetime').on('dp.change', function (e) {
		let start = $(this).val(),
			for_end = moment(start, 'MM/DD/YYYY H:mm A'),
			for_deadline = moment(start, 'MM/DD/YYYY H:mm A')
				.subtract(1, 'd')
				.hour(23)
				.minute(59)
				.utcOffset(8);

		$('#reg_deadline')
			.data('DateTimePicker')
			.maxDate(for_deadline)
			.date(for_deadline);

		$('#end_datetime').data('DateTimePicker').minDate(for_end).date(for_end);
	});

	$('#edt_start_datetime').on('dp.change', function (e) {
		let start = $(this).val(),
			for_end = moment(start, 'MM/DD/YYYY H:mm A'),
			for_deadline = moment(start, 'MM/DD/YYYY H:mm A')
				.subtract(1, 'd')
				.hour(23)
				.minute(59)
				.utcOffset(8);

		$('#edt_reg_deadline')
			.data('DateTimePicker')
			.maxDate(for_deadline)
			.date(for_deadline);

		$('#edt_end_datetime')
			.data('DateTimePicker')
			.minDate(for_end)
			.date(for_end);
	});

	/* On modal open/close */
	$('#NewEvent, #EditEvent')
		.on('shown.bs.modal', function () {
			let formid = 'form#' + $(this).find('form').attr('id');

			AuthorId(formid);

			if (formid == 'form#event_form') {
				$(formid)
					.find('#start_datetime')
					.data('DateTimePicker')
					.date(moment().add(3, 'd').hour(00).minute(00).utcOffset(8));
				// .minDate(moment().add(1, 'd').hour(00).minute(00).utcOffset(8));

				setTimeout(() => {
					$('#start_datetime').trigger('dp.change');
				}, 1000);
			}
		})
		.on('hidden.bs.modal', function () {
			let formid = 'form#' + $(this).find('form').attr('id');
			$(formid + ' .form-control').removeClass('is-invalid is-valid');
			$(formid).find('.cke_1').removeAttr('style');
			$(formid + ' .validation-msg').html('');

			ClearCKE();
		});

	/* Open file manager */
	$('#dummy, #edt_dummy').click(function (e) {
		e.preventDefault();
		let file_input = $(this).attr('data-target');
		$(`[name="${file_input}"]`).click();
	});

	/* Display image filename on input */
	$('.file_select').on('change', function () {
		let regex = /[\/\\]([\w\d\s\'\.\,\-\(\)]+)$/,
			this_id = $(this).attr('id'),
			target_dummy = $(this).attr('data-target'),
			dummy = $(`[name="${target_dummy}"]`),
			fakepath = $(this).val(),
			slctd,
			selected = () => {
				if (fakepath.match(regex) != null) {
					let filename = fakepath.match(regex)[1];

					if (filename.length >= 12) {
						// shorten long filename
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
			slctd = selected();
			switch (slctd) {
				case 'invalid':
					dummy.val('').addClass('is-invalid');
					$(`small.${this_id}`)
						.addClass('text-danger')
						.html('Invalid filename. Rename file.');
					$(this).val('');
					break;

				default:
					dummy.val(slctd).removeClass('is-invalid');
					$(`small.${this_id}`).html('');
					break;
			}
		} else {
			// clear dummy if empty
			dummy.val('').removeClass('is-invalid');
			$(`small.${this_id}`).html('');
		}
	});

	/* Add new event */
	$('#event_form').submit(function (e) {
		e.preventDefault();

		InstanceCKE();

		let form = $(this).serializeArray(),
			form_data = new FormData(),
			file = $('#select_file')[0].files[0];

		switch (false) {
			case ValidateRequired('event_form', 'title'):
			case ValidateAttachment('event_form', 'select_file', 'dummy'):
			case ValidateSchedule('event_form', 'start_datetime', 'end_datetime'):
			case ValidateDeadline('event_form', 'start_datetime', 'reg_deadline'):
			case ValidateRequired('event_form', 'venue'):
			case ValidateCKE('event_form', 'description'):
				$('.modal').animate({ scrollTop: $('#title').offset().top }, 500);
				break;

			default:
				form_data.append('select_file', file);
				$.each(form, function (key, input) {
					form_data.append(input.name, input.value);
				});

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Events.php',
					data: form_data,
					contentType: false,
					processData: false,
					success: function (res) {
						switch (res) {
							case 'true':
								SuccessModal('Added new event.', 0, 5000);
								RenderList();
								break;

							default:
								ErrorModal(0, 0, 5000);
								'show';
								break;
						}
					},
				});
				break;
		}
	});

	/* Fetch event for edit modal */
	$('.events-container').on('click', '.edit_event', function (e) {
		e.stopPropagation();
		e.preventDefault();

		let event = $(this).attr('data-target'),
			image = (filename) => {
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
			};

		$('#EditEvent')
			.modal('show')
			.on('shown.bs.modal', function () {
				let formid = $(this).find('form').attr('id');

				$.post('./assets/hndlr/Events.php', { event }, function (res) {
					if (res != 'err:fetch') {
						$.each(JSON.parse(res), function (idx, el) {
							let start = el.start,
								end = el.end,
								deadline = el.deadline;

							$(`#${formid} [name="event_id"]`).val(el.event_id);
							$(`#${formid} [name="edt_title"]`).val(el.title);
							$(`#${formid} [name="edt_start_datetime"]`)
								.data('DateTimePicker')
								.date(moment(start, 'MM/DD/YYYY H:mm A'));
							$(`#${formid} [name="edt_end_datetime"]`)
								.data('DateTimePicker')
								.minDate(moment(start, 'MM/DD/YYYY H:mm A'))
								.date(moment(end, 'MM/DD/YYYY H:mm A'));
							$(`#${formid} [name="edt_reg_deadline"]`)
								.data('DateTimePicker')
								.maxDate(moment(start, 'MM/DD/YYYY H:mm A').subtract(1, 'd'))
								.date(moment(deadline, 'MM/DD/YYYY H:mm A'));
							$(`#${formid} [name="edt_reg_deadline"]`).val(el.deadline);
							$(`#${formid} [name="edt_venue"]`).val(el.venue);
							InstanceCKE();
							CKEDITOR.instances[instance].setData(el.description);
						});
					} else {
						console.log('err:fetch', res);
					}
				});
			});
	});

	/* Edit event */
	$('#edit_form').submit(function (e) {
		e.preventDefault();

		InstanceCKE();

		let empty = /^\s*$/,
			form = $(this).serializeArray(),
			form_data = new FormData(),
			file = $('[name="edt_select_file"]')[0].files[0];

		switch (false) {
			case ValidateRequired('edit_form', 'edt_title'):
			case ValidateSchedule(
				'edit_form',
				'edt_start_datetime',
				'edt_end_datetime'
			):
			case ValidateDeadline(
				'edit_form',
				'edt_start_datetime',
				'edt_reg_deadline'
			):
			case ValidateRequired('edit_form', 'edt_venue'):
			case ValidateCKE('edit_form', 'edt_description'):
				$('.modal').animate({ scrollTop: $('#edt_title').offset().top }, 500);
				break;

			default:
				form_data.append('edt_select_file', file);
				$.each(form, function (key, input) {
					form_data.append(input.name, input.value);
				});

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Events.php',
					data: form_data,
					contentType: false,
					processData: false,
					success: function (res) {
						switch (res) {
							case 'true':
								SuccessModal('Updated event.', 0, 5000);
								RenderList();
								break;

							default:
								ErrorModal(0, 0, 5000);
								console.log('ERR', res);
								break;
						}
					},
				});
				break;
		}
	});

	/* Delete event */
	$('.events-container').on('click', '.delete_event', function (e) {
		e.stopPropagation();
		e.preventDefault();

		let del = $(this).attr('data-target');
		PromptModal('Are you deleting this event?', 0, 10000, 'delete_event', del);
		PromptConfirm('Event deleted.', './assets/hndlr/Events.php');
	});

	/* Read more */
	$('.events-container').on('click', '.readmore', function () {
		let id = $(this).attr('data-target');

		$.post('./assets/hndlr/Events.php', { event: id }, function (res) {
			if (res != 'err:fetch') {
				let title, description;

				$.each(JSON.parse(res), function (idx, el) {
					title = el.title;
					description = el.description;
				});

				description = description.replace(/&nbsp;/g, ' ');
				$('#ReadMore').modal('show');

				$('#ReadMore').on('shown.bs.modal', function () {
					$(this).find('.modal-title').html('<i class="text-muted">Read more:</i><br>&emsp;' + title);
					$(this).find('.modal-body').html(description);
					$(this).find('blockquote').addClass('blockquote');
				})
				.on('hidden.bs.modal', function () {
					$(this).find('.modal-title').html('');
					$(this).find('.modal-body').html('');
					$(this).find('blockquote').addClass('blockquote');
				});
			} else {
				console.log('err:fetch', res);
			}
		});
	});
}); // ready fn

function InstanceCKE() {
	for (instance in CKEDITOR.instances) {
		CKEDITOR.instances[instance].updateElement();
	}
}

function ClearCKE() {
	InstanceCKE();
	CKEDITOR.instances[instance].setData('');
}

function ValidateAttachment(form_id, name, dummy_name) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr = formid + `[name="${name}"]`,
		dummy = formid + `[name="${dummy_name}"]`;

	if ($(name_attr).val().length >= 1) {
		let file_format = $(name_attr)[0].files[0].type;

		if (!file_format.match(/\b(\w*image\w*)\b/gi)) {
			ctrl = false;
			$(dummy).addClass('is-invalid');
			$('small.' + name)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('File not image.');
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

function ValidateSchedule(form_id, name1, name2) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr1 = formid + `[name="${name1}"]`,
		name_attr2 = formid + `[name="${name2}"]`,
		start_val,
		end_val,
		start,
		end,
		diff;

	start_val = $(name_attr1).val();
	end_val = $(name_attr2).val();

	start = moment(start_val, 'MM/DD/YY h:mm A').unix();
	end = moment(end_val, 'MM/DD/YY h:mm A').unix();

	diff = end - start;

	switch (true) {
		case diff <= 0:
			$(name_attr1).addClass('is-invalid');
			$(name_attr2).addClass('is-invalid');
			$(formid + 'small.' + name1)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('End date must not be the same time as start date.');
			ctrl = false;
			break;

		default:
			$(name_attr1).removeClass('is-invalid');
			$(name_attr2).removeClass('is-invalid');
			$(formid + 'small.' + name1)
				.removeClass('text-danger')
				.html('');
			break;
	}

	return ctrl;
}

function ValidateDeadline(form_id, name1, name2) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr1 = formid + `[name="${name1}"]`,
		name_attr2 = formid + `[name="${name2}"]`,
		start_val,
		deadline_val,
		start,
		deadline,
		diff;

	start_val = $(name_attr1).val();
	deadline_val = $(name_attr2).val();

	start = moment(start_val, 'MM/DD/YY h:mm A').unix();
	deadline = moment(deadline_val, 'MM/DD/YY h:mm A').unix();

	diff = deadline - start;

	switch (false) {
		case diff <= 0:
			$(name_attr2).addClass('is-invalid');
			$(formid + 'small.' + name2)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('Registration deadline must not be the same day as start date.');
			ctrl = false;
			break;

		default:
			$(name_attr2).removeClass('is-invalid');
			$(formid + 'small.' + name2)
				.removeClass('text-danger')
				.html('');
			break;
	}

	return ctrl;
}