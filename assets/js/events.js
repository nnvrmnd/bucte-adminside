/* Fetch list */
function RenderList(sortBy = 'post', orderBy = 'desc', search = 0) {
	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Events.php',
		data: { fetchevents: 'all' },
		success: function (res) {
			$('.events-container').empty();

			try {
				let events = JSON.parse(res),
					search_regex = new RegExp(search, 'gi');

				events.sort((a, b) => {
					let A, B, arg;

					switch (sortBy) {
						case 'title':
							A = a.title;
							B = b.title;
							break;
						case 'sched':
							A = a.start;
							B = b.start;
							break;
						case 'deadln':
							A = a.deadline;
							B = b.deadline;
							break;

						default:
							A = a.created_at;
							B = b.created_at;
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
					events = events.filter(event => {
						if (event.title.match(search_regex)) {
							return true;
						}
					});

					if (events.length == 0) {
						$('.events-container').html(`
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

				$.each(events, function (idx, el) {
					let regex = /^\s*$/,
						event_id = el.event_id,
						desc_raw = el.description,
						desc_replace = desc_raw.replace(
							/<\/?[br|li|ol|ul|p|strong|blockquotes]+\/?>/gim,
							''
						),
						deadline = el.deadline,
						start = el.start,
						end = el.end,
						start_date,
						start_time,
						end_date,
						end_time,
						created_date,
						created_time,
						created_at;

					start_date = moment(start, 'YYYY/MM/DD h:mm A').format('MMM DD');
					start_time = moment(start, 'YYYY/MM/DD h:mm A').format('h:mm A');
					end_date = moment(end, 'YYYY/MM/DD h:mm A').format('MMM DD, YYYY');
					end_time = moment(end, 'YYYY/MM/DD h:mm A').format('h:mm A');
					deadline = moment(deadline, 'YYYY/MM/DD h:mm A').format('MMM DD, YYYY h:mm A');
					created_date = moment(el.created_at).format('Do MMM YYYY');
					created_time = moment(el.created_at).format('h:mm A');
					created_at = `${created_date} at ${created_time}`;

					$('.events-container').append(`
					<div class="card card-shadow" data-id="${event_id}">
						<div class="card-body">
							<div class="row">
								<div class="col-md-4 col-lg-4 d-flex align-items-center justify-content-center">
										<a href="../files/events/${
											el.image
										}" class="fancybox zoom-in" data-fancybox="events_gallery" data-caption="${el.title}">
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
									<button class="btn btn-sm btn-neutral float-right event_assmnt" title="View event assessment..." data-target="${event_id}">
										Assessment
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
									<small class="text-muted">by ${AuthorName(el.author)} on ${created_at}</small>
								</div>
								<!-- xs block -->
								<div class="col-md-9 mt-3 d-block d-sm-none d-none d-sm-block d-md-none">
									<button type="button" class="btn btn-sm btn-secondary text-danger float-right delete_event"
										title="Delete event..." data-target="${event_id}">
										<i class="fa fa-trash" aria-hidden="true"></i>
									</button>
									<button type="button" class="btn btn-sm btn-secondary text-purple float-right edit_event"
										title="Edit event..." data-target="${event_id}">
										<i class="fa fa-edit" aria-hidden="true"></i>
									</button>
									<button type="button" class="btn btn-sm btn-neutral float-right event_assmnt"
										title="View event assessment..." data-target="${event_id}">
										Assessment
									</button>
									<p class="font-weight-bold text-primary">${el.title} </p>
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
									<small class="text-muted">by ${AuthorName(el.author)} on ${created_at}</small>
								</div>
							</div>
						</div>
					</div>
					`);
				});
			} catch (e) {
				console.error('ERR', e.message);
				$('.events-container').html(`
				<div class="col notfound mb-5 pb-5">
					<div class="d-none d-sm-block notfound-404">
						<h1>Oops!</h1>
					</div>
					<h2 class="ml-2">Oops! List is empty</h2>
					<p class="ml-2">No items to display</p>
				</div>
				`);
			}
		},
		complete: function () {
			$('.desc').each(function (idx, el) {
				let target = $(el).attr('data-target'),
					condition = el.scrollWidth > el.clientWidth;
				if (condition === false) {
					$('.events-container')
						.find('#' + target)
						.html('&nbsp;');
				}
			});
		}
	});
}

/* Triggers */
$(function () {
	RenderList();
	$('form.filter').trigger('reset');

	/* Filter form */
	let form, sortby, orderby, search;
	function UpdateFilter() {
		form = $('form.filter').serializeArray();
		sortby = form[1].value;
		orderby = $('.filter #order').attr('data-state');
		search = form[0].value;
		search = search.match(/^\s*$/) ? 0 : search;
	}

	/* Sort */
	$('.filter [name=sort]').change(function (e) {
		e.preventDefault();

		UpdateFilter();
		RenderList(sortby, orderby, search);
	});

	/* Order */
	$('.filter #order').click(function (e) {
		e.preventDefault();

		UpdateFilter();

		switch (orderby) {
			case 'desc':
				RenderList(sortby, 'asc', search);
				$(this)
					.attr('data-state', 'asc')
					.attr('title', 'Ascending order')
					.html('<span class="fas fa-long-arrow-alt-up"></span>');
				break;

			default:
				RenderList(sortby, 'desc', search);
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
	}

	$('.filter [name=search]')
		.keyup(function (e) {
			UpdateFilter();
			clearTimeout(typingtimer);
			typingtimer = setTimeout(DoneTyping, 1000);
		})
		.keydown(function () {
			$('.events-container').empty();
			clearTimeout(typingtimer);
		});

	/* Fancybox */
	$('body').fancybox({
		selector: '[data-fancybox="events_gallery"]',
		buttons: ['zoom', 'thumbs', 'close']
	});

	/* CKEditor */
	CKEDITOR.disableAutoInline = true;
	let ckwrites = $('body').find('.ckwrite');
	ckwrites.each(function (i, e) {
		CKEDITOR.replace(e.name, {
			customConfig: '/app/admin/assets/js/ck_events.js'
		});
	});

	/* Charts */
	let Charts = (function () {
		var e,
			a = $('[data-toggle="chart"]'),
			t = 'light',
			n = {
				base: 'Open Sans'
			},
			i = {
				gray: {
					100: '#f6f9fc',
					200: '#e9ecef',
					300: '#dee2e6',
					400: '#ced4da',
					500: '#adb5bd',
					600: '#8898aa',
					700: '#525f7f',
					800: '#32325d',
					900: '#212529'
				},
				theme: {
					default: '#172b4d',
					primary: '#5e72e4',
					secondary: '#f4f5f7',
					info: '#11cdef',
					success: '#2dce89',
					danger: '#f5365c',
					warning: '#fb6340'
				},
				black: '#12263F',
				white: '#FFFFFF',
				transparent: 'transparent'
			};
		function o(e, a) {
			for (var t in a) 'object' != typeof a[t] ? (e[t] = a[t]) : o(e[t], a[t]);
		}
		function s(e) {
			var a = e.data('add'),
				t = $(e.data('target')).data('chart');
			e.is(':checked')
				? (!(function e(a, t) {
						for (var n in t)
							Array.isArray(t[n])
								? t[n].forEach(function (e) {
										a[n].push(e);
								  })
								: e(a[n], t[n]);
				  })(t, a),
				  t.update())
				: (!(function e(a, t) {
						for (var n in t)
							Array.isArray(t[n])
								? t[n].forEach(function (e) {
										a[n].pop();
								  })
								: e(a[n], t[n]);
				  })(t, a),
				  t.update());
		}
		function l(e) {
			var a = e.data('update'),
				t = $(e.data('target')).data('chart');
			o(t, a),
				(function (e, a) {
					if (void 0 !== e.data('prefix') || void 0 !== e.data('prefix')) {
						var t = e.data('prefix') ? e.data('prefix') : '',
							n = e.data('suffix') ? e.data('suffix') : '';
						(a.options.scales.yAxes[0].ticks.callback = function (e) {
							if (!(e % 10)) return t + e + n;
						}),
							(a.options.tooltips.callbacks.label = function (e, a) {
								var i = a.datasets[e.datasetIndex].label || '',
									o = e.yLabel,
									s = '';
								return (
									a.datasets.length > 1 &&
										(s +=
											'<span class="popover-body-label mr-auto">' +
											i +
											'</span>'),
									(s +=
										'<span class="popover-body-value">' + t + o + n + '</span>')
								);
							});
					}
				})(e, t),
				t.update();
		}
		return (
			window.Chart &&
				o(
					Chart,
					((e = {
						defaults: {
							global: {
								responsive: !0,
								maintainAspectRatio: !1,
								defaultColor: 'dark' == t ? i.gray[700] : i.gray[600],
								defaultFontColor: 'dark' == t ? i.gray[700] : i.gray[600],
								defaultFontFamily: n.base,
								defaultFontSize: 13,
								layout: {
									padding: 0
								},
								legend: {
									display: !1,
									position: 'bottom',
									labels: {
										usePointStyle: !0,
										padding: 16
									}
								},
								elements: {
									point: {
										radius: 0,
										backgroundColor: i.theme.primary
									},
									line: {
										tension: 0.4,
										borderWidth: 4,
										borderColor: i.theme.primary,
										backgroundColor: i.transparent,
										borderCapStyle: 'rounded'
									},
									rectangle: {
										backgroundColor: i.theme.warning
									},
									arc: {
										backgroundColor: i.theme.primary,
										borderColor: 'dark' == t ? i.gray[800] : i.white,
										borderWidth: 4
									}
								},
								tooltips: {
									enabled: !0,
									mode: 'index',
									intersect: !1
								}
							},
							doughnut: {
								cutoutPercentage: 83,
								legendCallback: function (e) {
									var a = e.data,
										t = '';
									return (
										a.labels.forEach(function (e, n) {
											var i = a.datasets[0].backgroundColor[n];
											(t += '<span class="chart-legend-item">'),
												(t +=
													'<i class="chart-legend-indicator" style="background-color: ' +
													i +
													'"></i>'),
												(t += e),
												(t += '</span>');
										}),
										t
									);
								}
							}
						}
					}),
					Chart.scaleService.updateScaleDefaults('linear', {
						gridLines: {
							borderDash: [2],
							borderDashOffset: [2],
							color: 'dark' == t ? i.gray[900] : i.gray[300],
							drawBorder: !1,
							drawTicks: !1,
							drawOnChartArea: !0,
							zeroLineWidth: 0,
							zeroLineColor: 'rgba(0,0,0,0)',
							zeroLineBorderDash: [2],
							zeroLineBorderDashOffset: [2]
						},
						ticks: {
							beginAtZero: !0,
							padding: 10,
							callback: function (e) {
								if (!(e % 10)) return e;
							}
						}
					}),
					Chart.scaleService.updateScaleDefaults('category', {
						gridLines: {
							drawBorder: !1,
							drawOnChartArea: !1,
							drawTicks: !1
						},
						ticks: {
							padding: 20
						},
						maxBarThickness: 10
					}),
					e)
				),
			a.on({
				change: function () {
					var e = $(this);
					e.is('[data-add]') && s(e);
				},
				click: function () {
					var e = $(this);
					e.is('[data-update]') && l(e);
				}
			}),
			{
				colors: i,
				fonts: n,
				mode: t
			}
		);
	})();

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
			close: 'fa fa-remove'
		},
		useCurrent: false
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
				WaitModal(5000);

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
								SuccessModal('Added new event.', 5000);
								RenderList(sortby, orderby, search);
								break;

							default:
								console.error('ERR', res)
								ErrorModal(5000);
								break;
						}
					}
				});
				break;
		}
	});

	/* Fetch event for edit modal */
	$('.events-container').on('click', '.edit_event', function (e) {
		e.stopPropagation();
		e.preventDefault();

		let event = $(this).attr('data-target'),
			image = filename => {
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
								.date(moment(start, 'YYYY/MM/DD h:mm A'));
							$(`#${formid} [name="edt_end_datetime"]`)
								.data('DateTimePicker')
								.minDate(moment(start, 'YYYY/MM/DD h:mm A'))
								.date(moment(end, 'YYYY/MM/DD h:mm A'));
							$(`#${formid} [name="edt_reg_deadline"]`)
								.data('DateTimePicker')
								.maxDate(moment(start, 'YYYY/MM/DD h:mm A').subtract(1, 'd'))
								.date(moment(deadline, 'YYYY/MM/DD h:mm A'));
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
				WaitModal(5000);

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
								SuccessModal('Updated event.', 5000);
								RenderList(sortby, orderby, search);
								break;

							default:
								ErrorModal(5000);
								console.error('ERR', res);
								break;
						}
					}
				});
				break;
		}
	});

	/* Delete event */
	$('.events-container').on('click', '.delete_event', function (e) {
		e.stopPropagation();
		e.preventDefault();

		let del = $(this).attr('data-target');
		PromptModal(10000, 'delete_event', del, 'Are you deleting this event?');
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

				$('#ReadMore')
					.on('shown.bs.modal', function () {
						$(this)
							.find('.modal-title')
							.html('<i class="text-muted">Read more:</i><br>&emsp;' + title);
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

	/* Event assessment */
	$('.events-container').on('click', '.event_assmnt', function () {
		let id = $(this).attr('data-target');

		let BarStackedChart = function (labels, ans_a, ans_b, ans_c, ans_d) {
			var e,
				a,
				t,
				n,
				i = $('#chart-bar-stacked7');

			i.length &&
				((e = i),
				(a = function () {
					return Math.round(100 * Math.random());
				}),
				(t = {
					labels: labels,
					datasets: [
						{
							label: 'Answered A',
							backgroundColor: Charts.colors.theme.primary,
							data: ans_a
						},
						{
							label: 'Answered B',
							backgroundColor: Charts.colors.theme.danger,
							data: ans_b
						},
						{
							label: 'Answered C',
							backgroundColor: Charts.colors.theme.success,
							data: ans_c
						},
						{
							label: 'Answered D',
							backgroundColor: Charts.colors.theme.warning,
							data: ans_d
						}
					]
				}),
				(n = new Chart(e, {
					type: 'horizontalBar',
					data: t,
					options: {
						tooltips: {
							mode: 'index',
							intersect: !1
						},
						responsive: !0,
						scales: {
							xAxes: [{ stacked: !0 }],
							yAxes: [{ stacked: !0 }]
						}
					}
				})),
				e.data('chart', n));
		};

		$.ajax({
			type: 'POST',
			url: './assets/hndlr/Events.php',
			data: { assessment: id },
			success: function (res) {
				$('.participants-container').empty();
				try {
					let participants = JSON.parse(res);
					participants.sort((a, b) => (a.surname > b.surname ? 1 : -1));

					$('.accts-container').find('.card').removeClass('d-none');

					$.each(participants, function (idx, el) {
						$('.participants-container').append(`
						<tr class="table-row pointer-here">
							<td class="text-truncate mx-5 px-5" title="${el.given} ${el.surname}">
								<b>${el.given} ${el.surname}</b>
							</td>
							<td class="text-truncate" title="${el.email}"><b>${el.email}</b></td>
						</tr>
						`);

						// $('.sendemail-btn').attr('data-target', el.event_id);
						$('.print-btn').attr('data-target', el.event_id);
					});
				} catch (e) {
					console.error('ERR', res);
					$('.sendemail-btn').attr('disabled', true);
					$('.participants-container').append(`
						<tr class="table-row pointer-here">
							<td class="text-truncate mx-5 px-5">
								<i>No participants...</i>
							</td>
							<td class="text-truncate"></td>
						</tr>
						`);
				}
			}
		});

		$.ajax({
			type: 'POST',
			url: './assets/hndlr/Events.php',
			data: { stats: id },
			success: function (res) {
				try {
					let assessment = JSON.parse(res),
						num_items = assessment.length,
						labels = [],
						a = [],
						b = [],
						c = [],
						d = [];

					for (let i = 1; i <= num_items; i++) {
						labels.push(`Item ${i}`);
					}

					$.each(assessment, function (idx, el) {
						a.push(el.answered_a);
						b.push(el.answered_b);
						c.push(el.answered_c);
						d.push(el.answered_d);
					});

					BarStackedChart(labels, a, b, c, d);
				} catch (e) {
					console.error('ERR', e.message);
					ErrorModal(5000);
				}
			}
		});

		$('#EventAssessment').modal('show');
	});

	$('#nav-participants-tab').click(function (e) {
		e.preventDefault();
		$('.print-btn').removeClass('d-none');
	});
	$('#nav-stat-tab').click(function (e) {
		e.preventDefault();
		$('.print-btn').addClass('d-none');
	});

	$('.sendemail-btn').click(function (e) {
		e.preventDefault();

		let id = $(this).attr('data-target');

		PromptModal(10000, 'sendsurvey', id, 'Send survey email?');
		PromptConfirm(
			'Survey has been send to participants.',
			'./assets/hndlr/Events.php'
		);
	});

	$('.print-btn').click(function (e) {
		e.preventDefault();

		let event = $(this).attr('data-target');

		$.post('./assets/hndlr/Events.php', { assessment: event }, function (res) {
			$('#print-table tbody').empty();
			try {
				let participants = JSON.parse(res);
				participants.sort((a, b) => (a.surname > b.surname ? 1 : -1));

				$.each(participants, function (idx, el) {
					$('#print-table tbody').append(`
					<tr><td><center>${idx + 1}.</center></td>
						<td>${el.surname}, ${el.given}</td>
						<td>${el.email}</td>
						<td></td>
					</tr>
					`);
				});

				setTimeout(() => {
					Print('#print-area');
				}, 1000);
			} catch (e) {
				console.log('ERR', e.message);
				ErrorModal(5000);
			}
		});
	});
	DocumentReady();
}); // ready fn

function Print(element) {
	let content = $(element).html(),
		printWindow = window.open(
			'',
			'PRINT',
			`height=${screen.height}, width=${screen.width}`
		);

	printWindow.document.write(`
		<html>
		<head>
			<meta charset="UTF-8">
			<title>List of Participants</title>
			<link rel="stylesheet" href="./assets/css/printarea.css">
		</head>
		`);
	printWindow.document.write('<body>');
	printWindow.document.write(content);
	printWindow.document.write('</body></html>');
	printWindow.document.close();
	printWindow.moveTo(0, 0);
	setTimeout(() => {
		printWindow.print();
	}, 1000);
}

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
