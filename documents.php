<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Documents | BUCTE Administration</title>
	<?php include './components/layout/Head.php'; ?>

	<style>
		img.card-img-top {
			width: 40% !important;
		}

		.nav-tabs .nav-item.show .nav-link,
		.nav-tabs .nav-link.active {
			color: #525f7f;
			border-color: #dee2e6 #dee2e6 #f8f9fe;
			background-color: white !important;
		}

		.nav-tabs .nav-link {
			border-top-left-radius: .100rem !important;
			border-top-right-radius: .100rem !important;
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
							<h6 class="h2 d-inline-block mb-0">Documents</h6>
							<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
								<ol class="breadcrumb breadcrumb-links">
									<li class="breadcrumb-item"><a href="javascript:void(0)"><i
												class="fas fa-home"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page">Records</li>
								</ol>
							</nav>
						</div>
						<div class="col-lg-6 text-right">
							<button class="btn btn-sm btn-secondary text-danger d-none" id="delete_btn"
								title="Delete selected file/s...">Delete file/s</button>
							<button class="btn btn-sm btn-secondary text-warning d-none" id="archive_btn"
								title="Archive selected file/s...">Archive file/s</button>
							<button class="btn btn-sm btn-secondary text-primary" data-toggle="modal"
								data-target="#UploadFile" title="Upoad new file...">Upload file</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Page content -->
		<div class="container-fluid mt--6">
			<form class="filter">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-sm-5 ml-auto">
						<div class="form-group">
							<input type="text" class="form-control form-control-sm text-dark" name="search"
								placeholder="Search...">
							</select>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-5">
						<div class="form-group">
							<div class="input-group">
								<select class="form-control form-control-sm pointer-here" name="sort"
									title="Sort by...">
									<option value="title">&ensp;Title</option>
									<option value="type">&ensp;File type</option>
									<option value="post" selected>&ensp;Date uploaded</option>
								</select>
								<span class="input-group-addon input-group-append">
									<button type="button" class="btn btn-sm btn-outline-primary" id="order"
										data-state="desc" title="Descending order">
										<span class="fas fa-long-arrow-alt-down"></span>
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="row card-wrapper documents-container">
				<!-- MAIN CONTENT HERE -->
			</div>
			<!-- Footer -->
			<?php include './components/layout/Footer.php'; ?>
		</div>
	</div>

	<!-- Modals -->
	<div class="modal fade" id="UploadFile" tabindex="-1" role="dialog" aria-labelledby="UploadFileLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
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
									<input type="text" class="form-control text-dark document-input" name="title"
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
									<textarea class="form-control text-dark document-input" name="description"
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

	<div class="modal fade" id="EditDocument" tabindex="-1" role="dialog" aria-labelledby="EditDocumentLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="EditDocumentLabel">Edit document</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="edit_form">
					<div class="modal-body">
						<input type="password" class="d-none" name="document_id" id="document_id">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_title">File title</label>
									<input type="text" class="form-control text-dark document-input" name="edt_title"
										id="edt_title" maxlength="190" title="For easy search later"
										placeholder="Title...">
									<small class="edt_title"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_description">Description</label>
									<textarea class="form-control text-dark document-input" name="edt_description"
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
		<div class="modal-dialog " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ArchiveFileLabel">Archive selected file/s</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<nav>
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<a class="nav-item nav-link archtab active" id="nav-newarch-tab" data-toggle="tab"
								href="#nav-newarch" role="tab" aria-controls="nav-newarch" aria-selected="true">To new
								archive</a>
							<a class="nav-item nav-link archtab" id="nav-existingarch-tab" data-toggle="tab"
								href="#nav-existingarch" role="tab" aria-controls="nav-existingarch"
								aria-selected="false">To existing archive</a>
						</div>
					</nav>
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-newarch" role="tabpanel"
							aria-labelledby="nav-newarch-tab">
							<div class="form-group mt-3 mb-2">
								<form role="form" id="newarchive_form">
									<input type="password" class="d-none author" name="archive_author"
										id="archival_author">
									<label class="form-control-label" for="archive_name">Archive name</label>
									<input type="text" class="form-control text-dark" name="archive_name"
										id="archive_name" maxlength="190" placeholder="Write new archive name...">
									<small class="archive_name"></small>
								</form>
							</div>
						</div>
						<div class="tab-pane fade" id="nav-existingarch" role="tabpanel"
							aria-labelledby="nav-existingarch-tab">
							<div class="table table-responsive">
								<table class="table align-items-center table-flush">
									<thead class="thead-light">
										<tr>
											<th>Archive name</th>
											<th></th>
											<th></th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody class="text-truncate" id="archives-container"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn bg-gradient-primary text-white" id="process_btn"
						data-target="#newarchive_form">Process</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="ReadMore" tabindex="-1" role="dialog" aria-labelledby="ReadMoreLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ReadMoreLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

				</div>

				<div class="modal-body"></div>

				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary text-purple edit_delete edit_document"
						title="Edit title/desciprtion..." data-dismiss="modal">
						<i class="fa fa-edit" aria-hidden="true"></i>
					</button>
					<button type="button" class="btn btn-sm btn-secondary text-danger edit_delete delete_document"
						title="Delete document..." data-dismiss="modal">
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
	<script src="./assets/js/documents.js"></script>
</body>

</html>