'use_strict';
$(function () {
	let whoiam = $('#whoiam').val();
	//getId
	$.get(
		'./assets/hndlr/Homepage.php',
		{
			user: whoiam
		},
		function (data) {
			let id = JSON.parse(data);
			$('.card-shadow').prepend(
				`<input type="text" value="${id.u_id}" class="d-none" name="author" hidden>`
			);
		}
	);

	// //Hide teaxtArea
	$('div[class*=edit-]').on('click', function (e) {
		if ($(this).hasClass('edit-vision'))
			$('#formV').css({ display: '' }) &&
				$('#vs').hide().css({ display: 'none' });
		if ($(this).hasClass('edit-mission'))
			$('#formM').css({ display: '' }) &&
				$('#ms').hide().css({ display: 'none' });
		if ($(this).hasClass('edit-obj'))
			$('#formO').css({ display: '' }) &&
				$('#os').hide().css({ display: 'none' });
	});

	$.get('./assets/hndlr/aliases.php', function (data) {
		let results = [];
		let id = JSON.parse(data);
		id.forEach(el => {
			el.alias == 'vision'
				? $('textarea[id=vision_body]').text(el.content) &&
				  $('#vision-view').html(el.content)
				: el.alias == 'mission'
				? $('textarea[id=mission_body]').text(el.content) &&
				  $('#mission-view').html(el.content)
				: el.alias == 'objectives'
				? $('textarea[id=obj_body]').text(el.content) &&
				  $('#obj-view').html(el.content)
				: '';
		});
	});

	$('form[id*=form]').on('submit', function (e) {
		e.preventDefault();

		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances[instance].updateElement();
		}

		swal({
			title: 'Are you sure?',
			text: "Proceed on saving by clicking 'OK'.",
			icon: 'warning',
			buttons: true,
			dangerMode: true,
			showCloseButton: true
		}).then(result => {
			if (result.value) {
				let form = $(this).serializeArray(),
					form_data = new FormData(),
					id = $('input[name=author]').val();
				$.each(form, function (key, input) {
					input != '' && form_data.append(input.name, input.value);
				});
				form_data.append('u_id', id);
				form_data.append('save_changes', '');
				var formEntries = Array.from(form_data.entries());
				//console.log("formEntries ", formEntries);
				$.ajax({
					type: 'POST',
					url: './assets/hndlr/About.php',
					data: form_data,
					contentType: false,
					processData: false,
					success: function (res) {
						switch (res) {
							case 'true':
								Swal.fire({
									icon: 'success',
									title: 'Saved successfully!',
									showConfirmButton: false,
									timer: 2500
								});
								break;
							default:
								Swal.fire({
									icon: 'error',
									title: 'Error Occured!',
									text: 'Please try again.',
									showConfirmButton: false,
									timer: 2500
								});
								break;
						}
					},
					error: function () {
						Swal.fire({
							icon: 'error',
							title: 'Error Occured!',
							text: 'Please try again.',
							showConfirmButton: false,
							timer: 2500
						});
					}
				});
			}
		});
	});
});

(function () {
	[].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
		new CBPFWTabs(el);
	});
})();
