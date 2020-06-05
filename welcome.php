<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Welcome | BUCTE Administration</title>
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

		.carousel-inner {
			width: 100%;
			max-height: 500px !important;
		}

		.carousel-item>img {
			height: 40rem;
		}

		#vision {
			background: rgba(94, 114, 228, 0.2)
		}

		#mission {
			background: rgba(251, 99, 64, 0.2)
		}

		#objectives {
			background: rgba(45, 206, 137, 0.2)
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
		<div class="header pb-7">
			<div class="">
				<div class="header-body">
					<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
						<!-- <ol class="carousel-indicators">
							<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
							<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
							<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
						</ol> -->
						<div class="carousel-inner">
							<div class="carousel-item">
								<img class="d-block w-100" src="" alt="Third slide">
							</div>
						</div>
						<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
							data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
							data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Page content -->
		<div class="container-fluid mt--6">
			<div class="row card-wrapper pt-3">
				<!-- MAIN CONTENT HERE -->
				<div class="col-lg-12 what-container">
					<div class="card card-shadow">
						<div class="card-header">
							<h2 class="text-blue">VISION</h2>
						</div>
						<div class="card-body text-dark" id="vision"></div>
					</div>
				</div>
				<div class="col-lg-12 what-container">
					<div class="card card-shadow">
						<div class="card-header">
							<h2 class="text-orange">MISSION</h2>
						</div>
						<div class="card-body text-dark" id="mission"></div>
					</div>
				</div>
				<div class="col-lg-12 what-container">
					<div class="card card-shadow">
						<div class="card-header text-green">
							<h2 class="text-green">OBJECTIVES</h2>
						</div>
						<div class="card-body text-dark" id="objectives"></div>
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
	<script src="./dist/vendor/fancybox/jquery.fancybox.min.js"></script>
	<script src="./assets/js/welcome.js"></script>
</body>

</html>