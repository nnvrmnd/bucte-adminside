/* Fetch list */
function RenderList() {
	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Assessment.php',
		data: { fetchitems: 'all' },
		success: function (res) {
			$('.items-container').html('');

			try {
				let count = JSON.parse(res).length;
				$.each(JSON.parse(res), function (idx, el) {
					let regex = /^\s*$/,
						optC = el.optionC,
						optD = el.optionD,
						optionC = '',
						optionD = '';

					switch (true) {
						case !optD.match(regex) && !optD.match(regex):
							optionC = `<small>C.&emsp;${el.optionC}</small> <br>`;
							optionD = `<small>D.&emsp;${el.optionD}</small> <br>`;
							break;
						case !optC.match(regex):
							optionC = `<small>C.&emsp;${el.optionC}</small> <br>`;
							break;
					}

					if (el.count >= 10) {
						$('#add_btn')
							.attr('title', 'Reached maximum number of items...')
							.attr('disabled', true);
					} else {
						$('#add_btn').attr('title', 'Add item...').removeAttr('disabled');
					}

					$('.items-container').append(`
					<div class="col-lg-12">
						<div class="card card-shadow">
								<div class="card-body pb-1">
									<button type="button" class="btn btn-sm btn-secondary text-danger float-right delete_item" data-target="${
										el.assessment_id
									}" title="Delete item...">
											<i class="fa fa-trash" aria-hidden="true"></i>
									</button>
									<button type="button" class="btn btn-sm btn-secondary text-purple float-right edit_item" data-id="${
										el.assessment_id
									}" title="Edit item...">
											<i class="fa fa-edit" aria-hidden="true"></i>
									</button>
									<p class="font-weight-bold mb-0 text-primary item">
									${count--}.&ensp;${el.question}</p>
									<p class="pl-3 text-dark">
											<small>A.&emsp;${el.optionA}</small> <br>
											<small>B.&emsp;${el.optionB}</small> <br>
											${optionC}
											${optionD}
									</p>
								</div>
						</div>
					</div>
					`);
				});
			} catch (e) {
				console.error('ERR', res);
				$('.items-container').html(`
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

// IDEA: Add CKEditor to questions

/* Triggers */
$(function () {
	RenderList();

	/* On modal open/close */
	$('#AddItem, #UpdateItem')
		.on('shown.bs.modal', function () {
			let formid = 'form#' + $(this).find('form').attr('id');

			AuthorId(formid);

			$(formid + ' [name="event"]').val(event);
		})
		.on('hidden.bs.modal', function () {
			$('textarea.question, input.options').removeClass('is-invalid is-valid');
			$('div.input-group-text').removeClass('bg-pink');
			$('small.question, small.options').html('');

			$('input.answer, input.edt_answer').each(function () {
				if (!$(this).attr('disabled')) {
					$(this).attr('disabled', 'disabled');
				}
			});
		});

	/* Friendly radio buttons */
	$('.input-group-text').click(function (e) {
		let find = $(this).attr('data-target'),
			radio = $(this).find(`input[value="${find}"]`).prop('disabled');

		if (radio == false) {
			$(this).find(`input[value="${find}"]`).prop('checked', true);
		}
	});

	/* Validation for radio options */
	$('form#item_form .options, form#update_form .options').keyup(function (e) {
		let regex = /^\s*$/,
			input = $(this).val(),
			radio = $(this).attr('data-radio');

		if (!input.match(regex)) {
			$(`[value='${radio}']`).removeAttr('disabled');
		} else {
			$(`[value='${radio}']`)
				.attr('disabled', 'disabled')
				.prop('checked', false);
		}
	});

	/* Add item validation/submit */
	$('#item_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serialize();

		switch (false) {
			case ValidateRequired('item_form', 'question'):
			case ValidateChoices('item_form'):
				// case ValidateAnswer('item_form'):
				break;

			default:
				WaitModal(5000);

				console.log(form);

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Assessment.php',
					data: form,
					success: function (res) {
						switch (res) {
							case 'true':
								SuccessModal('Item added.', 5000);
								RenderList();
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

	/* Fetch item for modal */
	$('.items-container').on('click', '.edit_item', function (e) {
		e.stopPropagation();
		e.preventDefault();

		let item = $(this).attr('data-id'),
			formid = 'form#update_form ';

		$('#UpdateItem').modal('show');
		$.post('./assets/hndlr/Assessment.php', { item }, function (res) {
			if (res != 'err:fetch') {
				$.each(JSON.parse(res), function (idx, el) {
					$(formid + '[name="edt_item"]').val(el.assessment_id);
					$(formid + '[name="edt_question"]').val(el.question);
					$(formid + '[name="optionA"]').val(el.optionA);
					$(formid + '[name="optionB"]').val(el.optionB);
					$(formid + '[name="optionC"]').val(el.optionC);
					$(formid + '[name="optionD"]').val(el.optionD);
					$(formid + `.answer[value="${el.answer}"]`).prop('checked', true);
				});
			} else {
				console.error('ERR', res);
				ErrorModal(5000)
			}

			/* Enable radio if !empty */
			/* $(formid + 'input.options').each(function (idx, el) {
				let options = $(this).val(),
					radio = $(this).attr('data-radio'),
					regex = /^\s*$/;
				if (!options.match(regex)) {
					$(formid + `input.answer[value="${radio}"]`).removeAttr('disabled');
				}
			}); */
		});
	});

	/* Update item validation/submit */
	$('#update_form').submit(function (e) {
		e.preventDefault();

		let form = $(this).serialize();

		switch (false) {
			case ValidateRequired('update_form', 'edt_question'):
			case ValidateChoices('update_form'):
			// case ValidateAnswer('update_form'):
				break;

			default:
				WaitModal(5000);

				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Assessment.php',
					data: form,
					success: function (res) {
						switch (res) {
							case 'true':
								SuccessModal('Item updated.', 5000);
								RenderList();
								break;

							default:
								ErrorModal(5000, 'No changes applied.');
								console.error('ERR', res);
								break;
						}
					}
				});
				break;
		}
	});

	/* Item delete */
	$('.items-container').on('click', '.delete_item', function (e) {
		e.stopPropagation();
		e.preventDefault();

		let del = $(this).attr('data-target');
		PromptModal(10000, 'delete_item', del, 'Are you deleting this item?');
		PromptConfirm('Item deleted.', './assets/hndlr/Assessment.php', event);
	});

	DocumentReady();
});
/* Triggers */

/* Validate options */
function ValidateChoices(form_id) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr1 = formid + '[name="optionA"]',
		name_attr2 = formid + '[name="optionB"]',
		name_attr3 = formid + '[name="optionC"]',
		name_attr4 = formid + '[name="optionD"]',
		input1 = $(name_attr1).val(),
		input2 = $(name_attr2).val(),
		input3 = $(name_attr3).val(),
		input4 = $(name_attr4).val(),
		regex = /^\s*$/,
		required = !input1.match(regex) && !input2.match(regex) ? true : false,
		mistake =
			!input4.match(regex) == 1 && !input3.match(regex) == 0 ? false : true;

	switch (false) {
		case required:
		case mistake:
			$(formid + 'input.options').addClass('is-invalid');
			$(formid + 'small.options')
				.removeClass('text-success')
				.addClass('text-danger')
				.html(
					'Give at least 2-3 choices. (At first, second, and third choice)'
				);

			ctrl = false;
			break;

		default:
			unicode('optionA');
			unicode('optionB');
			unicode('optionC');
			unicode('optionD');
			/* $(formid + 'input.options')
        .val()
        .replace(/"/g, '&quot;')
        .replace(/'/, '&apos;')
        .replace(/`/, '&#96;'); */
			$(formid + 'input.options').removeClass('is-invalid');
			$(formid + 'small.options')
				.removeClass('text-success')
				.html('');
			break;
	}

	return ctrl;
}

/* Validate answer */
function ValidateAnswer(form_id) {
	let ctrl = true,
		formid = `form#${form_id} `,
		name_attr = formid + '[name="answer"]:checked',
		input = $(name_attr),
		required = input.length != 0 ? true : false;

	switch (false) {
		case required:
			$(formid + 'div.input-group-text').addClass('bg-pink');
			$(formid + 'small.answer')
				.removeClass('text-success')
				.addClass('text-danger')
				.html('Select the correct answer.');
			ctrl = false;
			break;

		default:
			$(formid + 'div.input-group-text').removeClass('bg-pink');
			$(formid + 'small.answer')
				.removeClass('text-success')
				.html('');
			break;
	}

	return ctrl;
}
