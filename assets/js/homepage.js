function RenderList() {
	$.post('./assets/hndlr/Homepage.php', { welcome: '1' }, function (res) {
		try {
			let data = JSON.parse(res);
			AuthorId('form#homepage_form');

			$.each(data, function (idx, el) {
				$('[name=title]').val(el.title);
				$('[name=welcome-img]').attr('src', el.image);
				CKEDITOR.instances['body'].setData(el.content);
			});
		} catch (e) {
			console.error('ERR', e.message);
		}
	});
}

$(function () {
	RenderList();

	$('#image').change(function (e) {
		e.preventDefault();

		function readURL(input) {
			if (input.files && input.files[0]) {
				let reader = new FileReader();
				reader.onload = function (e) {
					$('#welcome-img').attr('src', e.target.result);
				};

				reader.readAsDataURL(input.files[0]);
			} else {
				$('#welcome-img').attr('src', './assets/img/noimg.png');
			}
		}

		readURL(this);
	});

	/* Cancel changes */
	$('.cancel').click(function (e) {
		e.preventDefault();
		RenderList();
	});

	/* Save changes */
	$('#homepage_form').submit(function (e) {
		e.preventDefault();

		InstanceCKE();

		let form = $(this).serializeArray(),
			form_data = new FormData(),
			file = $('#image')[0].files[0];

		switch (false) {
			case ValidateRequired('homepage_form', 'title'):
			case ValidateAttachment('homepage_form', 'image', 'welcome-img'):
			case ValidateCKE('homepage_form', 'body'):
				console.log('mig');
				break;

			default:
				form_data.append('image', file);
				$.each(form, function (key, input) {
					form_data.append(input.name, input.value);
				});

				PromptModal(10000, 'save_changes', 0, 'Save changes?');

				$('#prompt_form #yes_prompt')
					.off()
					.click(function (e) {
						WaitModal(5000);

						$.ajax({
							type: 'POST',
							url: './assets/hndlr/Homepage.php',
							data: form_data,
							contentType: false,
							processData: false,
							success: function (res) {
								switch (res) {
									case 'true':
										SuccessModal('Changes saved.', 5000);
										break;
									case 'err:save':
										ErrorModal(5000, 'No changes applied.');
										break;

									default:
										ErrorModal(5000);
										console.error('ERR', res);
										break;
								}
							}
						});

						$('#SuccessModal, #ErrorModal').on('hidden.bs.modal', function () {
							RenderList();
						});
					});

				break;
		}
	});

	DocumentReady();
});

function InstanceCKE() {
	for (instance in CKEDITOR.instances) {
		CKEDITOR.instances[instance].updateElement();
	}
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
			$(dummy).attr('src', './assets/img/noimg.png');
			$(`label.${name}`).addClass('text-danger');
			$('small.' + name)
				.removeClass('text-success')
				.addClass('text-danger')
				.html('File not image.');
		} else {
			$(`label.${name}`).removeClass('text-danger');
			$('small.' + name)
				.removeClass('text-danger')
				.empty();
		}
	} else {
		$(`label.${name}`).removeClass('text-danger');
		$('small.' + name)
			.removeClass('text-danger')
			.empty();
	}

	return ctrl;
}
