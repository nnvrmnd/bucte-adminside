<?php
include './components/functions/Functions.php';
SeshStart('auth');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Authenticate | BUCTE Administration</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon -->
	<link rel="icon" href="./dist/img/brand/bu-logo.png" type="image/png">
	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
	<!-- Icons -->
	<link rel="stylesheet" href="./dist/vendor/nucleo/css/nucleo.css" type="text/css">
	<link rel="stylesheet" href="./dist/vendor/%40fortawesome/fontawesome-free/css/all.min.css" type="text/css">
	<!-- Argon CSS -->
	<link rel="stylesheet" href="./dist/css/argon.min5438.css?v=1.0.0" type="text/css">

	<link rel="stylesheet" href="./assets/css/style.css" type="text/css">
</head>

<body>

	<!-- Main content -->
	<div class="main-content">
		<!-- Header -->
		<div class="header py-4 py-lg-1 pt-lg-6">
			<div class="container">
				<div class="header-body text-center mb-4">
					<div class="row justify-content-center">
						<div class="col-xl-5 col-lg-6 col-md-8 px-5">
							<h1 class="text-white">&nbsp;</h1>
							<p class="text-lead text-white">&nbsp;</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Page content -->
		<div class="container mt--8 pb-5">
			<div class="row justify-content-center">
				<div class="col-lg-5 col-md-7">
					<div class="card bg-secondary border-0 mb-0 card-shadow">
						<div class="card-header bg-transparent pb-4">
							<div class="text-muted text-center mt-2 mb-3"><small>Dashboard</small></div>
							<div class="btn-wrapper text-center">
								<img src="./dist/img/brand/cte.png" style="width: 50%;">
							</div>
						</div>
						<div class="card-body px-lg-5 py-lg-5">
							<div class="text-center text-muted mb-4">
								<small>Sign in with credentials</small>
							</div>
							<form role="form" id="sudo_auth">
								<div class="">
									<center>
										<small class="text-danger font-weight-bold" id="auth-alert"></small>
									</center>
								</div>
								<div class="form-group mb-3">
									<div class="input-group input-group-merge input-group-alternative">
										<div class="input-group-prepend">
											<span class="input-group-text auth-icon"><i class="ni ni-email-83"></i></span>
										</div>
										<input type="text" class="form-control text-dark auth-input" placeholder="Email or Username"
											name="sudo_username" maxlength="16">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group input-group-merge input-group-alternative">
										<div class="input-group-prepend">
											<span class="input-group-text auth-icon"><i class="ni ni-lock-circle-open"></i></span>
										</div>
										<input type="password" class="form-control text-dark auth-input" placeholder="Password"
											name="sudo_password" maxlength="16">
									</div>
								</div>
								<div class="custom-control custom-control-alternative custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="sudo_remember" name="sudo_remember">
									<label class="custom-control-label" for="sudo_remember">
										<span class="text-muted">Remember me</span>
									</label>
								</div>
								<div class="text-center">
									<button type="submit" class="btn bg-gradient-primary text-white my-4" id="SigninBtn">Sign
										in</button>
								</div>
							</form>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-6">
							<a href="#" class="text-light"><small>&nbsp;</small></a>
						</div>
						<div class="col-6 text-right">
							<a href="#" class="text-light"><small>&nbsp;</small></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<footer class="py-5 mt-6 d-none" id="footer-main">
		<div class="container">
			<div class="row align-items-center justify-content-xl-between">
				<div class="col-xl-6">
					<div class="copyright text-center text-xl-left text-muted">
						&copy; 2020 <a href="https://www.creative-tim.com/" class="font-weight-bold ml-1" target="_blank">Creative
							Tim</a>
					</div>
				</div>
				<div class="col-xl-6">
					<ul class="nav nav-footer justify-content-center justify-content-xl-end">
						<li class="nav-item">
							<a href="https://www.creative-tim.com/" class="nav-link" target="_blank">Creative Tim</a>
						</li>
						<li class="nav-item">
							<a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
						</li>
						<li class="nav-item">
							<a href="http://blog.creative-tim.com/" class="nav-link" target="_blank">Blog</a>
						</li>
						<li class="nav-item">
							<a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</footer>

	<!-- Scripts -->
	<!-- Argon Scripts -->
	<script src="./dist/vendor/jquery/dist/jquery.min.js"></script>
	<script src="./dist/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="./dist/vendor/js-cookie/js.cookie.js"></script>
	<script src="./dist/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
	<script src="./dist/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
	<!-- Argon JS -->
	<script src="./dist/js/argon.min5438.js?v=1.0.0"></script>
	<!-- Demo JS - remove this in your project -->
	<script src="./dist/js/demo.min.js"></script>
	<!-- NEIL FRANCIS E. BAYNA -->
	<script src="./assets/js/auth-signin.js"></script>
</body>


</html>