<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Contact Page | BUCTE Administration</title>
	<?php include './components/layout/Head.php'; ?>
	<link rel="stylesheet" href="./dist/vendor/fancybox/jquery.fancybox.min.css">
	<link rel="stylesheet" href="./dist/vendor/sweetalert2/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="./assets/css/tabs.css" type="text/css">
	<link rel="stylesheet" href="./assets/css/tabstyles.css" type="text/css">
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
							<h6 class="h2 d-inline-block mb-0">Edit &raquo; Contact Page</h6>
							<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
								<ol class="breadcrumb breadcrumb-links">
									<li class="breadcrumb-item"><a href="javascript:void(0)"><i
												class="fas fa-home"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page">Pages</li>
								</ol>
							</nav>
						</div>
						<div class="col-lg-6 col-5 text-right"></div>
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
							<form role="form" id="contact_form" enctype="multipart/form-data" novalidate>
								<div class="card-body">
									<section>
										<input type="password" class="d-none author" name="author" id="author">
										<div class="row">
											<div class="col-md-6 mb-2">
												<div class="form-group mb-2">
													<div class="form-control-label single-contact-info" for="phone">
														<i class="fa fa-phone" aria-hidden="true"></i>
														<h2>Phone</h2>
													</div>
													<input type="text" class="form-control text-dark" name="phone"
														id="phone" maxlength="190" placeholder="Phone...">
													<small class="phone"></small>
												</div>
											</div>
											<div class="col-md-6 mb-2">
												<div class="form-group mb-2">
													<div class="form-control-label single-contact-info" for="address">
														<i class="fa fa-map-marker-alt" aria-hidden="true"></i>
														<h2>Address</h2>
													</div>
													<input type="text" class="form-control text-dark" name="address"
														id="address" maxlength="190" placeholder="Address...">
													<small class="address"></small>
												</div>
											</div>
											<div class="col-md-6 mb-2">
												<div class="form-group mb-2">
													<div class="form-control-label single-contact-info" for="open">
														<i class="fa fa-clock" aria-hidden="true"></i>
														<h2>Open time</h2>
													</div>
													<div class="row">
														<div class="col-6">
															<input type="time" class="form-control text-dark" id="opening" name="opening">
															<small class="opening"></small>
														</div>
														<div class="col-6">
															<input type="time" class="form-control text-dark" id="closing" name="closing">
															<small class="closing"></small>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6 mb-2">
												<div class="form-group mb-2">
													<div class="form-control-label single-contact-info" for="email">
														<i class="fa fa-envelope" aria-hidden="true"></i>
														<h2>Email</h2>
													</div>
													<input type="email" class="form-control text-dark" name="email"
														id="email" maxlength="190" placeholder="Email...">
													<small class="email"></small>
												</div>
											</div>
											<div class="col-md-12 mb-2">
												<div class="form-group mb-2">
													<div class="form-control-label single-contact-info" for="embed">
														<i class="fas fa-map-marked-alt"></i>
														<h2>Location</h2>
													</div>
													<textarea class="form-control text-dark resource-input"
														name="embed" id="embed" rows="5"
														placeholder="Google map embed..."></textarea>
													<small class="embed"></small>
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="card-footer">
									<div class="row">
										<div class="col">
											<button type="submit"
												class="btn btn-lg bg-gradient-primary text-white float-right">Save
												changes</button>
											<button type="button"
												class="btn btn-lg btn-secondary float-right mr-2 cancel">Cancel</button>
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
	<script src="./dist/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
	<script src="./dist /vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
	<script src="./assets/js/contactpage.js"></script>
</body>

</html>