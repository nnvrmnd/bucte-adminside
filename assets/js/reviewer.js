// IDEA: Maybe add a "1 minute per item" time duration

/* Fetch list */
function RenderList(sortBy = 'post', orderBy = 'desc', search = 0) {
	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Reviewer.php',
		data: { fetchreviewers: 'all' },
		success: function (res) {
			$('.reviewers-container').empty();

			try {
				let reviewers = JSON.parse(res),
					search_regex = new RegExp(search, 'gi');

				reviewers.sort((a, b) => {
					let A, B, arg;

					switch (sortBy) {
						case 'title':
							A = a.title;
							B = b.title;
							break;
						case 'level':
							A = a.level;
							B = b.level;
							break;
						case 'source':
							A = a.source;
							B = b.source;
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
					reviewers = reviewers.filter(reviewer => {
						if (reviewer.title.match(search_regex)) {
							return true;
						}
					});

					if (reviewers.length == 0) {
						$('.reviewers-container').html(`
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

				$.each(reviewers, function (idx, el) {
					let regex = /^\s*$/,
						description = el.description,
						readmore = `<a href="javascript:void(0)" class="readmore" data-target="${el.rvwr_id}">Read more</a>`,
						duration,
						level,
						created_date,
						created_time,
						created_at;

					created_date = moment(el.created_at).format('Do MMM YYYY');
					created_time = moment(el.created_at).format('h:mm A');
					created_at = `${created_date} at ${created_time}`;

					if (!description.match(regex) === false) {
						description = '<i>No description...</i>';
						readmore = '&nbsp;';
					}
					switch (el.duration) {
						case '30':
							duration = '30 mins';
							break;
						case '45':
							duration = '45 mins';
							break;
						case '60':
							duration = '1 hour';
							break;
						case '90':
							duration = '1 hour and 30 mins';
							break;
						case '120':
							duration = '2 hours';
							break;
					}
					switch (el.level) {
						case 'gen':
							level = 'General';
							break;
						case 'prof':
							level = 'Professional';
							break;
						case 'eng':
							level = 'English';
							break;
						case 'fil':
							level = 'Filipino';
							break;
						case 'bio':
							level = 'Biology Sciences';
							break;
						case 'phys':
							level = 'Physical Sciences';
							break;
						case 'math':
							level = 'Mathematics';
							break;
						case 'socsci':
							level = 'Social Studies/Sciences';
							break;
						case 'values':
							level = 'Values';
							break;
						case 'mapeh':
							level = 'MAPEH';
							break;
						case 'agri':
							level = 'Agriculture and Fishery Arts';
							break;
						case 'tech':
							level = 'Technology and Livelihood';
							break;
					}

					$('.reviewers-container').append(`
					<div class="col-lg-6">
						<div class="card card-shadow pointer-here" title="Click for questionnaire..." data-id="${
							el.rvwr_id
						}">
							<div class="card-body pb-1">
								<button type="button" class="btn btn-sm btn-secondary text-danger float-right delete_reviewer" data-target="${
									el.rvwr_id
								}" title="Delete reviewer...">
										<i class="fa fa-trash" aria-hidden="true"></i>
								</button>
								<button type="button" class="btn btn-sm btn-secondary text-purple float-right edit_reviewer" data-target="${
									el.rvwr_id
								}" title="Edit reviewer...">
										<i class="fa fa-edit" aria-hidden="true"></i>
								</button>
								<p class="font-weight-bold mb-0 text-primary text-truncate" title="${
									el.title
								}">${el.title}</p>
								<div class="text-truncate desc" data-target="desc_${
									el.rvwr_id
								}"><small>${description}</small></div>
								<p id="desc_${
									el.rvwr_id
								}"><small title="Click to read description...">${readmore}</small></p>
								<small>
									<dl class="row">
										<dt class="col-sm-3">Level:</dt>
										<dd class="col-sm-9">${level} Education</dd>
										<dt class="col-sm-3">Source:</dt>
										<dd class="col-sm-9">${el.source}</dd>
										<dt class="col-sm-3">No. of items:</dt>
										<dd class="col-sm-9">${el.items}</dd>
										<dt class="col-sm-3">Duration:</dt>
										<dd class="col-sm-9">${duration}</dd>
									</dl>
								</small>
								<p>
									<small class="text-muted">by ${AuthorName(el.author)} on ${created_at}</small>
								</p>
							</div>
						</div>
					</div>
					`);
				});
			} catch (e) {
				console.error('ERR', e.message);
				$('.reviewers-container').html(`
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
		complete: function (res) {
			$('.desc').each(function (idx, el) {
				let target = $(el).attr('data-target'),
					condition = el.scrollWidth > el.clientWidth;
				if (condition === false) {
					$('.reviewers-container')
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
			$('.reviewers-container').empty();
			clearTimeout(typingtimer);
		});

	/* On modal open/close */
	$('#NewReviewer, #EditReviewer')
		.on('shown.bs.modal', function () {
			let formid = 'form#' + $(this).find('form').attr('id');

			AuthorId(formid);
		})
		.on('hidden.bs.modal', function () {
			let formid = 'form#' + $(this).find('form').attr('id');
			$(formid + ' .form-control').removeClass('is-invalid is-valid');
			$(
				formid + ' small.title, small.level, small.duration, small.source'
			).html('');
			// $(formid + ' [name=""]').prop('selected', true);
		});

	/* New reviewer validation/submit */
	$('#reviewer_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serialize();

		switch (false) {
			case ValidateRequired('reviewer_form', 'title'):
			case ValidateRequired('reviewer_form', 'source'):
			case ValidateRequired('reviewer_form', 'level'):
			case ValidateRequired('reviewer_form', 'duration'):
				$('.modal').animate(
					{ scrollTop: $('[name="title"]').offset().top },
					500
				);
				break;

			default:
				WaitModal(5000);

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Reviewer.php',
					data: form,
					success: function (res) {
						switch (res) {
							case 'true':
								SuccessModal('Created new reviewer.', 5000);
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

	/* Open reviewer */
	$('.reviewers-container').on('click', '.card.pointer-here', function (e) {
		let id = $(this).attr('data-id');

		sessionStorage.setItem('rvwr', id);
		window.location.href = 'questionnaire.php';
	});

	/* Fetch reviewer for modal */
	$('.reviewers-container').on('click', '.edit_reviewer', function (e) {
		e.stopPropagation();
		e.preventDefault();

		let reviewer = $(this).attr('data-target'),
			formid = 'form#edit_form ';

		$('#EditReviewer').modal('show');
		$.post(
			'./assets/hndlr/Reviewer.php',
			{
				reviewer
			},
			function (res) {
				if (res != 'err:fetch') {
					$.each(JSON.parse(res), function (idx, el) {
						$(formid + '[name="reviewer_id"]').val(el.reviewer_id);
						$(formid + '[name="title"]').val(el.title);
						$(formid + '[name="source"]').val(el.source);
						$(formid + `[name="level"] option[value="${el.level}"]`).prop(
							'selected',
							true
						);
						$(formid + `[name="duration"] option[value="${el.duration}"]`).prop(
							'selected',
							true
						);
						$(formid + '[name="description"]').val(el.description);
					});
				} else {
					console.log('err:fetch');
				}
			}
		);
	});

	/* Update reviewer validation/submit */
	$('#edit_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serialize();

		switch (false) {
			case ValidateRequired('edit_form', 'title'):
			case ValidateRequired('edit_form', 'source'):
			case ValidateRequired('edit_form', 'level'):
			case ValidateRequired('edit_form', 'duration'):
				$('.modal').animate({ scrollTop: $('#title').offset().top }, 500);
				break;

			default:
				WaitModal(5000);

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Reviewer.php',
					data: form,
					success: function (res) {
						switch (res) {
							case 'true':
								SuccessModal('Updated reviewer.', 5000);
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

	/* Delete reviewer */
	$('.reviewers-container').on('click', '.delete_reviewer', function (e) {
		e.stopPropagation();
		e.preventDefault();

		let del = $(this).attr('data-target');
		PromptModal(
			10000,
			'delete_reviewer',
			del,
			'Are you deleting this reviewer?'
		);
		PromptConfirm('Reviewer deleted.', './assets/hndlr/Reviewer.php');
		$('#SuccessModal, #ErrorModal').on('hidden.bs.modal', function () {
			RenderList(sortby, orderby, search);
		});
	});

	/* Read more */
	$('.reviewers-container').on('click', '.readmore', function (e) {
		e.stopPropagation();
		e.preventDefault();

		let id = $(this).attr('data-target');

		$.post('./assets/hndlr/Reviewer.php', { reviewer: id }, function (res) {
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

	DocumentReady();
}); // ready fn
