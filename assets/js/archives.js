/* Fetch list */
function RenderList(sortBy = 'post', orderBy = 'desc', search = 0) {
	$.ajax({
		type: 'POST',
		url: './assets/hndlr/Archives.php',
		data: { fetcharchives: 'all' },
		success: function (res) {
			$('.archives-container').empty();

			try {
				let archives = JSON.parse(res),
					search_regex = new RegExp(search, 'gi');

				archives.sort((a, b) => {
					let A, B, arg;

					switch (sortBy) {
						case 'title':
							A = a.zipname;
							B = b.zipname;
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
					archives = archives.filter(archive => {
						if (archive.zipname.match(search_regex)) {
							return true;
						}
					});

					if (archives.length == 0) {
						$('.archives-container').html(`
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

				$.each(archives, function (idx, el) {
					let created_date, created_time, created_at;

					created_date = moment(el.created_at).format('Do MMM YYYY');
					created_time = moment(el.created_at).format('h:mm A');
					created_at = `${created_date} at ${created_time}`;

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
								)} on ${created_at}</small> <br>
								<a href="./files/documents/${el.zipname}.zip" download="${el.zipname}.zip"
									class="btn btn-link px-0 float-right download_file" title="Download file...">
									<i class="fas fa-cloud-download-alt fa-lg"></i>
								</a>
							</div>
						</div>
					</div>
					`);
				});
			} catch (e) {
				console.error('ERR', e.message);
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
			$('.archives-container').empty();
			clearTimeout(typingtimer);
		});

	$('#ReadArchive')
		.on('shown.bs.modal', function () {
			/* Check/uncheck checkbox */
			$(this).on('click', 'tr', function (e) {
				e.preventDefault();

				let tr = $(this).attr('data-target'),
					checkbox = $(this).find(`#${tr}`);

				checkbox.is(':checked')
					? checkbox.prop('checked', false)
					: checkbox.prop('checked', true);
			});
		})
		.on('hidden.bs.modal', function () {
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

							{
								/* <td>
								<div class="custom-control custom-checkbox m-2">
									<input type="checkbox" class="custom-control-input checkboxes" id="check_${id}" data-id="${id}">
									<label class="custom-control-label" for="check_${id}" title="Select to extract file/s..."></label>
								</div>
							</td> */
							}

							table.append(`
								<tr class="table-row pointer-here" data-target="check_${id}">
									<td class="text-truncate mx-5 px-5" colspan="3" title="${title}">
										<img class="avatar mr-3" src="./assets/img/file_format/${file_format(
											format
										)}" alt="Filetype thumbnail">
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
						RenderList(sortby, orderby, search);
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
