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
			$("input[name='u_id']").val(id.u_id);
		}
	);

	$('.show-edit').on('click', function () {
		$(this).parent().css({
			display: 'none'
		});
		$('.content').css({
			display: ''
		});
	});

	//textfields
	$.get('./assets/hndlr/textfield.php', function (data) {
		if (data != 'false') {
			data = JSON.parse(data);
			$("input[name='title']").val(data.title);
			$("input[name='meta1']").val(data.meta1);
			$("textarea[name='content']").text(data.content);
			$("div[id='content-view']").html(data.content);
			//content.innerHTML(data.content)
		}
	});

	//Show Image when Upload
	function readURL(input) {
		if (input.files && input.files[0]) {
			let reader = new FileReader();
			reader.onload = function (e) {
				let id = $(input).attr('id');
				$(`img[id="${id}1"]`).attr('src', e.target.result);
				$(`img[id="${id}1"]`).css({
					width: '100%',
					'max-width': '100%',
					height: '100%',
					display: 'block'
				});
				$(`img[id="${id}1"]`).parent().css({
					padding: '0px'
				});
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	//Images
	$.get('./assets/hndlr/images.php', function (data) {
		let content = data;
		$('.images').prepend(content);
		$('input[id*=image]').on('change', function () {
			readURL(this);
		});
	});

	//Save Changes in Form
	$('#homepage_form').submit(function (e) {
		e.preventDefault();
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
					file = $('input[name*=image]');
				$.each(form, function (key, input) {
					input.value != '' && form_data.append(input.name, input.value);
				});
				$.each(file, function (key, input) {
					input.value != '' &&
						form_data.append(
							input.name,
							$(`input[name=${input.name}]`)[0].files[0]
						);
				});
				form_data.append('meta2', $(`input[name=meta2]`)[0].files[0]);
				form_data.append('save_changes', '');
				$.ajax({
					type: 'POST',
					url: './assets/hndlr/Homepage.php',
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
						console.log(res);
					}
				});
			} //else swal.close();
		});
	});

	DocumentReady();
});
