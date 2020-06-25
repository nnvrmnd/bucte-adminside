<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Home Page | BUCTE Administration</title>
	<?php include './components/layout/Head.php'; ?>
	<link rel="stylesheet" href="./dist/vendor/fancybox/jquery.fancybox.min.css">
	<link rel="stylesheet" href="./dist/vendor/sweetalert2/dist/sweetalert2.min.css">
	<style>
		img.rounded {
			max-height: 200px;
		}

		.blockquote {
			padding-left: 3%;
			padding-right: 3%;
		}

		.welcome-container {

			max-height: 170px;
			max-width: 300px;
			display: flex;
			justify-content: center;
		}

		.welcome-img {
			border: solid 1px #dee2e6;
			max-height: 170px;
		}

		.upload-btn {
			position: absolute;
			top: 35%;
		}

		.ubtn {
			opacity: 0;
		}

		.welcome-container:hover .ubtn {
			opacity: 1;
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
							<form role="form" id="homepage_form" enctype="multipart/form-data">
								<input type="text" class="d-none" name="author" id="author">
								<div class="card-body">
									<div class="form-group mb-2">
										<label class="form-control-label" for="title">Title</label>
										<input type="text" class="form-control text-dark" name="title" id="title"
											maxlength="190" placeholder="Write title...">
										<small class="msg title"></small>
									</div>

									<div class="form-group mb-2">
										<label class="form-control-label image" for="welcome-img">Image</label>
										<div class="row">
											<div class="col">
												<div class="welcome-container">
													<img class="welcome-img" id="welcome-img" name="welcome-img"
														src="./assets/img/noimg.png">

													<div class="upload-btn">
														<label class="btn btn-lg btn-default ubtn" for="image"
															title="Change image...">
															<i class="fa fa-camera fa-lg" aria-hidden="true"></i>
														</label>
														<input type="file" class="d-none" id="image" name="image"
															accept="image/*">
													</div>
												</div>

											</div>
										</div>
										<small class="msg image"></small>
									</div>

									<div class="form-group mb-2">
										<label class="form-control-label" for="description">Body</label>
										<textarea class="form-control ckwrite" name="body" id="body" rows="7"
											placeholder="Write body..."></textarea>
										<small class="msg body"></small>
									</div>
								</div>
								<div class="card-footer">
									<div class="row">
										<div class="col">
											<button type="submit" class="btn btn-lg bg-gradient-primary text-white float-right">Save changes</button>
											<button type="button" class="btn btn-lg btn-secondary float-right mr-2 cancel">Cancel</button>
										</div>
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
	<script src="./dist/vendor/ckeditor/ckeditor.js"></script>
	<script src="./dist/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
	<script src="./assets/js/homepage.js"></script>
</body>

</html>