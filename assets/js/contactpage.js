function RenderList() {
	$('form#contact_form').trigger('reset');

	$.post('./assets/hndlr/Contactpage.php', { contact: '1' }, function (res) {
		try {
			let contact = JSON.parse(res);

			$.each(contact, function (idx, el) {
				$('#phone').val(el.phone);
				$('#address').val(el.address);
				$('#opening').val(el.open);
				$('#closing').val(el.close);
				$('#email').val(el.email);
				$('#embed').text(el.embed);
			});

			AuthorId('form#contact_form');
		} catch (e) {
			console.error('ERR', e.message);
			ErrorModal(5000);
		}
	});
}

$(function () {
	RenderList();

	/* Set closing 8 hrs from opening */
	$('#opening').change(function () {
		let opening = $(this).val(),
			closing = moment(opening, 'HH:mm').format('x');

		closing = parseInt(closing) + 28800000;
		closing = moment(closing).format('HH:mm');
		$('#closing').val(closing);
	});

	/* Set opening 8 hrs less from closing */
	/* $('#closing').change(function () {
		let closing = $(this).val(),
			opening = moment(closing, 'HH:mm').format('x');

		opening = parseInt(opening) - 28800000;
		opening = moment(opening).format('HH:mm');
		$('#opening').val(opening);
	}); */

	/* Cancel changes */
	$('.cancel').click(function (e) {
		e.preventDefault();
		RenderList();
	});

	/* Save changes */
	$('#contact_form').submit(function (e) {
		e.preventDefault();
		let form = $(this).serialize(),
			formid = $(this).attr('id');

		switch (false) {
			case ValidateRequired(formid, 'phone'):
			case ValidateRequired(formid, 'address'):
			case ValidateRequired(formid, 'opening'):
			case ValidateRequired(formid, 'closing'):
			case ValidateRequired(formid, 'email'):
			case ValidateRequired(formid, 'embed'):
				break;

			default:
				unicode('embed');

				PromptModal(10000, 'save_changes', 0, 'Save changes?');

				$('#prompt_form #yes_prompt')
					.off()
					.click(function (e) {
						WaitModal(5000);

						$.post('./assets/hndlr/Contactpage.php', form, function (res) {
							switch (res) {
								case 'true':
									SuccessModal('Changes saved.', 5000);
									RenderList();
									break;
								case 'err:save':
									ErrorModal(5000, 'No changes applied.');
									RenderList();
									break;

								default:
									ErrorModal(5000);
									console.error('ERR', res);
									break;
							}
						});
					});
				break;
		}
	});

	DocumentReady();
});
