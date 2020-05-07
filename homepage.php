<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Pages | BUCTE Administration</title>
	<?php include './components/layout/Head.php'; ?>
	<link rel="stylesheet" href="./dist/vendor/fancybox/jquery.fancybox.min.css">
	<style>
		img.rounded {
			max-height: 200px;
		}

		.blockquote {
			padding-left: 3%;
			padding-right: 3%;
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
						<div class="col-lg-6 col-7">
							<h6 class="h2 d-inline-block mb-0">Edit &raquo; Home Page</h6>
							<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
								<ol class="breadcrumb breadcrumb-links">
									<li class="breadcrumb-item"><a href="javascript:void(0)"><i
												class="fas fa-home"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page">Pages</li>
								</ol>
							</nav>
						</div>
						<div class="col-lg-6 col-5 text-right">
							<!-- <button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#NewEvent">New button</button> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Page content -->
		<div class="container-fluid mt--6">
			<div class="row card-wrapper justify-content-center">
				<div class="col-lg-12 editor-container">
					<!-- MAIN CONTENT HERE -->

					<div class="card-wrapper">
						<div class="card card-shadow">
							<form role="form" id="editor_form">
								<div class="card-body">
									<div class="form-group mb-2">
										<label class="form-control-label" for="title">Event title</label>
										<input type="text" class="form-control text-dark" name="title" id="title"
											maxlength="190" placeholder="Write title...">
										<small class="title"></small>
									</div>

									<div class="form-group mb-2">
										<label class="form-control-label" for="content_body">Body</label>
										<textarea class="form-control ckwrite" name="content_body" id="content_body"
											rows="5" placeholder="Write content body..."></textarea>
										<small class="content_body"></small>
									</div>
								</div>
							</form>
						</div>
					</div>

				</div>
			</div>
			<!-- Footer -->
			<?php include './components/layout/Footer.php'; ?>
		</div>
	</div>

	<!-- Modals -->

	<!-- Scripts -->
	<?php include './components/layout/Scripts.php'; ?>
	<script src="./dist/vendor/ckeditor/ckeditor.js"></script>
	<script src="./dist/vendor/fancybox/jquery.fancybox.min.js"></script>
	<script src="./assets/js/pages.js"></script>
</body>

</html>