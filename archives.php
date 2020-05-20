<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Archives | BUCTE Administration</title>
	<?php include './components/layout/Head.php'; ?>

	<style>
		img.card-img-top {
			width: 40% !important;
		}

		.avatar {
			background-color: #fff !important;
		}

		.table {
			table-layout: fixed;
		}
	</style>
</head>

<body>
	<!-- Sidenav -->
	<?php include './components/layout/Sidenav.php'; ?>
	<!-- Main content -->
	<div class="main-content" id="panel">
		<!-- Topnav -->
		<?php include './components/layout/Topnav.php'; ?>
		<!-- Header -->
		<div class="header pb-6">
			<div class="container-fluid">
				<div class="header-body">
					<div class="row align-items-center py-4">
						<div class="col-lg-6">
							<h6 class="h2 d-inline-block mb-0">Archives</h6>
							<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
								<ol class="breadcrumb breadcrumb-links">
									<li class="breadcrumb-item"><a href="javascript:void(0)"><i
												class="fas fa-home"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page">Records</li>
								</ol>
							</nav>
						</div>
						<div class="col-lg-6 text-right"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- Page content -->
		<div class="container-fluid mt--6">
			<div class="row card-wrapper archives-container">
				<!-- MAIN CONTENT HERE -->







			</div>
			<!-- Footer -->
			<?php include './components/layout/Footer.php'; ?>
		</div>
	</div>

	<!-- Modals -->
	<div class="modal fade" id="UploadFile" tabindex="-1" role="dialog" aria-labelledby="UploadFileLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="archive">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="UploadFileLabel">Upload file</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="upload_form">
					<div class="modal-body">
						<input type="password" class="d-none" name="author" id="author">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="title">File title</label>
									<input type="text" class="form-control text-dark archive-input" name="title"
										id="title" maxlength="190" title="For easy search later" placeholder="Title...">
									<small class="title"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="select_file">Select file</label>
									<input type="text" class="form-control text-dark bg-white pointer-here" name="dummy"
										id="dummy" placeholder="Select a file..." data-target="select_file" readonly>
									<input type="file" class="d-none file_select" name="select_file" id="select_file"
										data-target="dummy">
									<input type="hidden" class="d-none" name="file_format" id="file_format">
									<!-- accept="image/jpeg,image/png" -->
									<small class="select_file"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="description">Description</label>
									<textarea class="form-control text-dark archive-input" name="description"
										id="description" rows="5" placeholder="Write file description..."></textarea>
								</div>
							</div>
							<!-- <div class="col-md-6"></div> -->
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Upload</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="EditArchive" tabindex="-1" role="dialog" aria-labelledby="EditArchiveLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="archive">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="EditArchiveLabel">Edit archive</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="edit_form">
					<div class="modal-body">
						<input type="password" class="d-none" name="archive_id" id="archive_id">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_title">File title</label>
									<input type="text" class="form-control text-dark archive-input" name="edt_title"
										id="edt_title" maxlength="190" title="For easy search later"
										placeholder="Title...">
									<small class="edt_title"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_description">Description</label>
									<textarea class="form-control text-dark archive-input" name="edt_description"
										id="edt_description" rows="5"
										placeholder="Write file description..."></textarea>
								</div>
							</div>
							<!-- <div class="col-md-6"></div> -->
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Upload</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="ArchiveFile" tabindex="-1" role="dialog" aria-labelledby="ArchiveFileLabel"
		aria-hidden="true">
		<div class="modal-dialog " role="archive">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ArchiveFileLabel">Archive selected file/s</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="archival_form">
					<input type="password" class="d-none author" name="archive_author" id="archival_author">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="archive_name">Archive name</label>
									<input type="text" class="form-control text-dark" name="archive_name"
										id="archive_name" maxlength="190" placeholder="Write name...">
									<small class="archive_name"></small>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Process</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="ReadArchive" tabindex="-1" role="dialog" aria-labelledby="ReadArchiveLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="archive">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ReadArchiveLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col">
							<div class="card">
								<!-- <div class="card-body"> -->
								<!-- Light table -->
								<div class="table table-responsive">
									<table class="table align-items-center table-flush">
										<thead class="thead-light">
											<tr>
												<!-- <th style="width: 8.33%">
													<div class="custom-control custom-checkbox m-2">
														<input type="checkbox" class="custom-control-input" id="checkall">
														<label class="custom-control-label" for="checkall" title="Select all..."></label>
													</div>
												</th> -->
												<th>Document name</th>
												<th></th>
												<th></th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class="text-truncate" id="files-container">
											<!-- <tr>
													<td class="table-user">
														<img src="../../assets/img/theme/team-1.jpg"
															class="avatar rounded-circle mr-3">
														<b>John Michael</b>
													</td>
													<td class="table-actions">
														<a href="#!" class="table-action" data-toggle="tooltip"
															data-original-title="Edit product">
															<i class="fas fa-user-edit"></i>
														</a>
														<a href="#!" class="table-action table-action-delete"
															data-toggle="tooltip" data-original-title="Delete product">
															<i class="fas fa-trash"></i>
														</a>
													</td>
												</tr> -->
										</tbody>
									</table>
								</div>
								<!-- </div> -->
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="ReadMore" tabindex="-1" role="dialog" aria-labelledby="ReadMoreLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="archive">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ReadMoreLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

				</div>

				<div class="modal-body"></div>

				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary text-purple edit_delete edit_archive"
						title="Edit title/desciprtion..." data-dismiss="modal">
						<i class="fa fa-edit" aria-hidden="true"></i>
					</button>
					<button type="button" class="btn btn-sm btn-secondary text-danger edit_delete delete_archive"
						title="Delete archive..." data-dismiss="modal">
						<i class="fa fa-trash" aria-hidden="true"></i>
					</button>
					<a class="btn btn-link text-blue ml-auto mt-2 download_btn" title="Download file...">
						<i class="fas fa-cloud-download-alt fa-lg"></i>
					</a>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<?php include './components/layout/Scripts.php'; ?>
	<script src="./assets/js/archives.js"></script>
</body>

</html>