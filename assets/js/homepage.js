$(function () {
	let whoiam = $('#whoiam').val();
	
	//tooltip
	$('a[data-toggle="tooltip"]').tooltip();

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

	//Delete Image
	$(document).on('click', 'i[class*="fa-trash"]', function(event){
		event.preventDefault();

		let getImage = $(this).parent().prev(), //.find("img").attr("id");
		    currentDiv = $(this).parent(),
			imageName = getImage.find("label").attr('for'),
			image =  getImage.find("img");
	    swal({
			title: `Proceed deleting ${imageName}?`,
			text: "Note: the image will be directly deleted without saving.",
			type: 'warning',
			buttons: true,
			showCloseButton: true,
			confirmButtonText: "Confirm"
		}).then(result => {
			if(result.value == true){
				$.post('./assets/hndlr/Homepage.php',
						{ image: imageName },
						function(res){
							console.log(res)
							switch (res) {
								case 'true':
									Swal.fire({
										type: 'success',
										title: 'Deleted successfully!',
										showConfirmButton: false,
										timer: 2500
									});
									image.attr("src", "assets/img/no-image.png")
									image.attr("class", "no-image-size")
									currentDiv.css({"display": "none"}) 
									currentDiv.prev().css({"padding": "40px"})
									break;
								default:
									Swal.fire({
										type: 'error',
										title: 'Error Occured!',
										text: 'Please try again.',
										showConfirmButton: false,
										timer: 2500
									});
									break;
							}
						}
				)		
			}
		})		
	})

	//textfields
	$.get('./assets/hndlr/textfield.php', function (data) {
		data = JSON.parse(data);
		let condition = data.meta2 != null;
		if (data != 'false') {
			$("input[name='title']").val(data.title);
			$("input[name='meta1']").val(data.meta1);
			$("textarea[name='content']").text(data.content);
			$("div[id='content-view']").html(data.content);
			condition  ? $("a[data-toggle=tooltip]").attr("data-original-title", `<img width='140px' src='${data.meta2}' />`) 
				: $("a[data-toggle=tooltip]").attr("data-original-title", `<img width='140px' src='assets/img/no-image.png' />`);
			condition ? $("#remove-signature").css({'display': ""}) : $("#remove-signature").css({'display': "none"});	
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

	//Delete meta2 (signature)
	$(document).on('click', 'button[id="remove-signature"]', function(){
		swal({
			title: `Proceed deleting signature image?`,
			text: "Note: the image will be directly deleted without saving.",
			type: 'warning',
			buttons: true,
			dangerMode: true,
			showCloseButton: true
		}).then(result=>{
			if(result.value==true){
			   		$.post('./assets/hndlr/Homepage.php',
					{ signatureImage: "meta2" },
					function(res){
						switch (res) {
							case 'true':
								Swal.fire({
									type: 'success',
									title: 'Deleted successfully!',
									showConfirmButton: false,
									timer: 2500
								});
								break;
							default:
								Swal.fire({
									type: 'error',
									title: 'Error Occured!',
									text: 'Please try again.',
									showConfirmButton: false,
									timer: 2500
								});
								break;
						}
					}
				)		
			}
		})		
	})

	//Save Changes in Form
	$('#homepage_form').submit(function (e) {
		e.preventDefault();
		swal({
			title: 'Are you sure?',
			text: "Proceed on saving by clicking 'OK'.",
			type: 'info',
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
				$(`input[name=meta2]`).get(0).files.length != 0 && form_data.append('meta2', $(`input[name=meta2]`)[0].files[0]);
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
									type: 'success',
									title: 'Saved successfully!',
									showConfirmButton: false,
									timer: 2500
								});
								break;
							default:
								Swal.fire({
									type: 'error',
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
