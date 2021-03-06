<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Profile | BUCTE Administration</title>
	<?php include './components/layout/Head.php'; ?>
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
							<h6 class="h2 d-inline-block mb-0">Profile</h6>
							<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
								<ol class="breadcrumb breadcrumb-links">
									<li class="breadcrumb-item"><a href="javascript:void(0)"><i
												class="fas fa-home"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page">My profile</li>
								</ol>
							</nav>
						</div>
						<div class="col-lg-6 col-5 text-right d-none">
							<a href="#" class="btn btn-sm btn-neutral">New</a>
							<a href="#" class="btn btn-sm btn-neutral">Filters</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Page content -->
		<div class="container-fluid mt--5">
			<div class="row">
				<div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
					<div class="card card-profile card-shadow">
						<div class="row justify-content-center">
							<div class="col-lg-3 order-lg-2">
								<div class="card-profile-image">
									<a href="javascript:void(0)">
										<img class="rounded-circle" id="profile-avatar">
									</a>
								</div>
							</div>
						</div>
						<div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4"
							style="border-radius: calc(.375rem - 1px) calc(.375rem - 1px) 0 0;">
							<div class="d-flex justify-content-between">
								<!-- <a href="javascript:void(0)" class="btn btn-sm btn-info mr-4">Connect</a> -->
								<!-- <a href="javascript:void(0)" class="btn btn-sm btn-default float-right">Message</a> -->
							</div>
						</div>
						<div class="card-body pt-0 pt-md-5">
							<div class="text-center">
								<span class="d-block mb-1" id="name"></span>
								<small class="h4 font-weight-light text-muted" id="position"></small>
							</div>
							<div class="row">
								<div class="col">
									<div class="card-profile-stats d-flex justify-content-center mt-md-2">
										<div>
											<span class="d-none" id="form_btns">
												<button class="btn bg-gradient-success text-white" id="submit_btn"
													disabled>Save</button>
												<button class="btn" id="cancel_btn">Cancel</button>
											</span>
											<button class="btn bg-gradient-primary text-white" id="edit_btn">
												<i class="fas fa-edit"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-8 order-xl-1">
					<div class="card bg-secondary card-shadow">
						<div class="card-header bg-white border-0">
							<div class="row align-items-center">
								<div class="col-8">
									<h3 class="mb-0">My account</h3>
								</div>
								<div class="col-4 text-right">
									<a href="javascript:void(0)" class="btn btn-sm btn-neutral" data-toggle="modal"
										data-target="#ChangePassword">Change password</a>
								</div>
							</div>
						</div>
						<div class="card-body">
							<form role="form" id="profile_form" novalidate>
								<h6 class="heading-small text-muted mb-4">User information</h6>
								<div class="pl-lg-4">
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="form-control-label given" for="given">First name</label>
												<input type="text" class="form-control bg-white profileform"
													name="given" id="given" readonly>
												<small class="msg given"></small>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="form-control-label surname" for="surname">Last
													name</label>
												<input type="text" class="form-control bg-white profileform"
													name="surname" id="surname" readonly>
												<small class="msg surname"></small>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<input type="password" class="d-none" name="account">
											<div class="form-group">
												<label class="form-control-label username"
													for="username">Username</label>
												<input type="password" class="d-none" name="user_profile">
												<input type="text" class="form-control bg-white profileform"
													name="username" id="username" maxlength="16" readonly>
												<small class="msg username"></small>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="form-control-label email" for="email">Email
													address</label>
												<input type="email" class="form-control bg-white profileform"
													name="email" id="email" readonly>
												<small class="msg email"></small>
											</div>
										</div>
									</div>
								</div>
								<!-- <hr class="my-4" /> -->
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- Footer -->
			<?php include './components/layout/Footer.php'; ?>
		</div>
	</div>

	<!-- CHANGE PASSWORD Modal -->
	<div class="modal fade" id="ChangePassword" tabindex="-1" role="dialog" aria-labelledby="ChangePasswordLabel"
		data-backdrop="static" aria-hidden="true">
		<div class="modal-dialog modal- modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ChangePasswordLabel">Change password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="pass_form">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="form-control-label" for="current">Current password</label>
									<input type="password" class="form-control text-dark" name="current" id="current"
										maxlength="16" placeholder="Current password...">
									<small class="msg current"></small>
								</div>
								<hr>
								<div class="form-group">
									<label class="form-control-label" for="new">New password</label>
									<input type="password" class="form-control text-dark" name="new" id="new"
										maxlength="16" placeholder="New password...">
									<small class="msg new"></small>
								</div>
								<div class="form-group">
									<label class="form-control-label" for="confirm">Confirm password</label>
									<input type="password" class="form-control text-dark" name="confirm" id="confirm"
										maxlength="16" placeholder="Re-enter password...">
									<small class="msg confirm"></small>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<?php include './components/layout/Scripts.php'; ?>
	<script src='./assets/js/profile.js'></script>
</body>

</html>