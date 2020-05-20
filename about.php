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
							<h6 class="h2 d-inline-block mb-0">Edit &raquo; About Page</h6>
							<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
								<ol class="breadcrumb breadcrumb-links">
									<li class="breadcrumb-item"><a href="javascript:void(0)"><i class="fas fa-home"></i></a></li>
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
							<div class="card-body">
								<section>
									<div class="tabs tabs-style-linetriangle">
										<nav>
											<ul class="tab-selection">
												<li><a href="#vision"><span>Vision</span></a></li>
												<li><a href="#mission"><span>Mission</span></a></li>
												<li><a href="#objectives"><span>Objectives</span></a></li>
											</ul>
										</nav>

										<div class="content-wrap">

											<section id="vision">
												<form role="form" id="formV" enctype="multipart/form-data" style="display: none;">
													<input type="password" class="d-none" value="vision" name="alias" id="alias" hidden>
													<div class="col-md-12">
														<div class="form-group mb-2">
															<label class="form-control-label" for="content">Vision</label>
															<textarea class="form-control ckwriteV" name="content" id="vision_body" rows="5"
																placeholder="Write content body..."></textarea>
															<small class="vision_body"></small>
														</div>
														<div class="form-group mb-2 flex-center">
															<div class="btn-xlg-container"><button type="submit" name="save_vision"
																	class="btn btn-lg btn-block bg-gradient-primary text-white ">Save
																	Changes</button></div>
														</div>
													</div>
												</form>

												<div class="form-group mb-2 edit-holder" id="vs">
													<label class="form-control-label" for="content">Vision</label>
													<div class="col-md-12 col-sm-12 content-style"
														style="padding:10px; height: 370px; overflow: auto; border: solid 1px #d1d1d1;">
														<div class="scrollbar-inner">
															<div id="vision-view" style="padding"></div>
														</div>
													</div>
													<div class="show-edit edit-vision"> CLICK HERE TO EDIT. </div>
												</div>
											</section>

											<section id="mission">
												<form role="form" id="formM" enctype="multipart/form-data" style="display:none;">
													<input type="password" class="d-none" value="mission" name="alias" id="alias" hidden>
													<div class="col-md-12">
														<div class="form-group mb-2">
															<label class="form-control-label" for="content">Mission</label>
															<textarea class="form-control ckwriteM" name="content" id="mission_body" rows="5"
																placeholder="Write content body..." required></textarea>
															<small class="mission_body"></small>
														</div>
														<div class="form-group mb-2 flex-center">
															<div class="btn-xlg-container">
																<button type="submit" name="save_changes"
																	class="btn btn-lg btn-block bg-gradient-primary text-white ">
																	Save Changes
																</button>
															</div>
														</div>
													</div>
												</form>

												<div class="form-group mb-2 edit-holder" id="ms">
													<label class="form-control-label" for="content">Mission</label>
													<div class="col-md-12 col-sm-12 content-style"
														style="padding:10px; height: 370px; overflow: auto; border: solid 1px #d1d1d1;">
														<div class="scrollbar-inner">
															<div id="mission-view" style="padding"></div>
														</div>
													</div>
													<div class="show-edit edit-mission"> CLICK HERE TO EDIT.</div>
												</div>
											</section>

											<section id="objectives">
												<form role="form" id="formO" enctype="multipart/form-data" style="display: none">
													<input type="password" class="d-none" value="objectives" name="alias" id="alias" hidden>
													<div class="form-group mb-2">
														<label class="form-control-label" for="content">Objectives</label>
														<textarea class="form-control ckwriteO" name="content" id="obj_body" rows="5"
															placeholder="Write content body..." required></textarea>
														<small class="obj_body"></small>
													</div>
													<div class="form-group mb-2 flex-center">
														<div class="btn-xlg-container">
															<button type="submit" name="save_changes"
																class="btn btn-lg btn-block bg-gradient-primary text-white ">
																Save Changes
															</button>
														</div>
													</div>
												</form>

												<div class="form-group mb-2 edit-holder" id="os">
													<label class="form-control-label" for="content">Objectives</label>
													<div class="col-md-12 col-sm-12 content-style"
														style="padding:10px; height: 370px; overflow: auto; border: solid 1px #d1d1d1;">
														<div class="scrollbar-inner">
															<div id="obj-view" style="padding"></div>
														</div>
													</div>
													<div class="show-edit edit-obj"> CLICK HERE TO EDIT. </div>
												</div>
											</section>
										</div>
									</div><!-- /content -->
								</section>
							</div>
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
	<script src="./assets/js/pages.js"></script>
	<script src="./dist/vendor/ckeditor/ckeditor.js"></script>
	<script src="./assets/js/cbpFWTabs.js"></script>
	<script src="./assets/js/about.js"></script>
</body>

</html>