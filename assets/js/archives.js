/* Fetch list */
function RenderList() {
	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Archives.php',
		data: { fetcharchives: 'all' },
		success: function (res) {
			$('.archives-container').html('');

			if (!res.match(/\b(\w*err:fetch\w*)\b/g)) {
				$.each(JSON.parse(res), function (idx, el) {
					$('.archives-container').append(`
						<div class="col-sm-6 col-md-4 col-lg-3 document-card">
							<div class="card card-shadow">

								<div class="d-flex align-items-center justify-content-center mt-4 pointer-here readarchive"
									data-target="${el.archive_id}" title="Click to read more...">
									<img class="card-img-top mx-auto mt-4" src="./assets/img/file_format/zip.png" alt="Filetype thumbnail">
								</div>

								<div class="card-body pb-1">
									<p class="font-weight-bold card-title text-truncate mb-0 pointer-here readarchive"
										data-id="${
											el.archive_id
										}" data-target="${el.archive_id}" title="${el.zipname}">${el.zipname}</p>
									<small class="text-muted">by ${AuthorName(
										el.author
									)} on ${el.created_at}</small> <br>
									<a href="./files/documents/${el.zipname}.zip" download="${el.zipname}.zip"
										class="btn btn-link px-0 float-right download_file" title="Download file...">
										<i class="fas fa-cloud-download-alt fa-lg"></i>
									</a>
								</div>
							</div>
						</div>
					`);
				});
			} else {
				$('.archives-container').html(`
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

$(function () {
	RenderList();

	$('#ReadArchive').on('shown.bs.modal', function () {
		/* Check/uncheck checkbox */
		$(this).on('click', 'tr', function (e) {
			e.preventDefault();

			let tr = $(this).attr('data-target'),
				checkbox = $(this).find(`#${tr}`);

			checkbox.is(':checked')
				? checkbox.prop('checked', false)
				: checkbox.prop('checked', true);
		});
	}).on('hidden.bs.modal', function () {
		$(this).find('#files-container').html('');
	});

	/* Read archive files */
	$('.archives-container').on('click', '.readarchive', function (e) {
		e.preventDefault();

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

		let id = $(this).attr('data-target');

		$.ajax({
			type: 'POST',
			url: './assets/hndlr/Archives.php',
			data: { archive: id },
			success: function (res) {
				if (res != 'err:fetch') {
					$('#ReadArchive').on('shown.bs.modal', function () {
						let table = $(this).find('#files-container'),
							header = $(this).find('#ReadArchiveLabel'),
							id,
							zipname,
							title,
							format,
							description,
							uploaded_at;

						table.html('');

						$.each(JSON.parse(res), function (idx, el) {
							id = el.document_id;
							zipname = el.zipname;
							title = el.title;
							format = el.format;
							description = el.description;
							uploaded_at = el.uploaded_at;

							{/* <td>
								<div class="custom-control custom-checkbox m-2">
									<input type="checkbox" class="custom-control-input checkboxes" id="check_${id}" data-id="${id}">
									<label class="custom-control-label" for="check_${id}" title="Select to extract file/s..."></label>
								</div>
							</td> */}

							table.append(`
								<tr class="table-row pointer-here" data-target="check_${id}">
									<td class="text-truncate mx-5 px-5" colspan="3" title="${title}">
										<img class="avatar mr-3" src="./assets/img/file_format/${file_format(format)}" alt="Filetype thumbnail">
										<b>${title}</b>
									</td>
									<td class="table-actions">
										<a href="#" class="btn btn-sm btn-secondary text-primary extract_file" data-target="${id}" title="Extact to Documents...">
											<i class="fas fa-share-square"></i>
										</a>
										<a href="#" class="btn btn-sm btn-secondary text-red delete_file d-none" data-target="${id}" title="Delete file...">
											<i class="fas fa-trash"></i>
										</a>
									</td>
								</td>
								`);
						});

						header.html(zipname);
					});
				} else {
					console.error('ERR', res);
				}
			},
			complete: function () {
				$('#ReadArchive').modal('show');
			}
		});
	});

	/* Extract file */
	$('#ReadArchive').on('click', '.extract_file', function (e) {
		e.preventDefault();
		e.stopPropagation();

		WaitModal(5000);

		let target = $(this).attr('data-target');

		$.ajax({
			type: 'POST',
			url: './assets/hndlr/Archives.php',
			data: { extract: target },
			success: function (res) {
				switch (res) {
					case 'true':
						SuccessModal('File extracted to Documents', 5000);
						RenderList();
						break;

					default:
						ErrorModal(5000);
						console.error('ERR', res);
						break;
				}
			}
		});
	});

	DocumentReady();
}); // ready fn
