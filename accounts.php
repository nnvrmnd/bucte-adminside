<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Account Management | BUCTE Administration</title>
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
							<h6 class="h2 d-inline-block mb-0">Account Management</h6>
							<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
								<ol class="breadcrumb breadcrumb-links">
									<li class="breadcrumb-item"><a href="javascript:void(0)"><i
												class="fas fa-home"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page">Account Management</li>
								</ol>
							</nav>
						</div>
						<div class="col-lg-6 text-right">
							<button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#NewAcct">
								New event
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Page content -->
		<div class="container-fluid mt--6">
			<div class="row card-wrapper">
				<div class="col-lg-12 accts-container">
					<!-- MAIN CONTENT HERE -->

					<div class="card card-shadow">
						<div class="card-body">

							<div class="table table-responsive">
								<table class="table align-items-center table-flush">
									<thead class="thead-light">
										<tr>
											<th>Name</th>
											<th></th>
											<th>Username</th>
											<th>Email</th>
											<th>Account Type</th>
											<th>Account Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody class="text-truncate accounts-container">
										<!-- <tr>
											<td class="table-user">
												<img src="./assets/img/m.png"
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

						</div>
					</div>


				</div>
			</div>
			<!-- Footer -->
			<?php include './components/layout/Footer.php'; ?>
		</div>
	</div>

	<!-- Modals -->
	<div class="modal fade" id="NewAcct" tabindex="-1" role="dialog" aria-labelledby="NewAcctLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="NewAcctLabel">New account</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="new_form" novalidate>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="given">Given name</label>
									<input type="text" class="form-control text-dark" name="given" id="given"
										maxlength="190" placeholder="Given name...">
									<small class="msg given"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="surname">Surname</label>
									<input type="text" class="form-control text-dark" name="surname" id="surname"
										maxlength="190" placeholder="Surname...">
									<small class="msg surname"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="username">Username</label>
									<input type="text" class="form-control text-dark" name="username" id="username"
										maxlength="190" placeholder="Username...">
									<small class="msg username"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="email">Email</label>
									<input type="text" class="form-control text-dark" name="email" id="email"
										maxlength="190" placeholder="Email...">
									<small class="msg email"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="gender">Gender <small>(click to change)</small></label>
									<input type="text" class="form-control bg-white text-dark pointer-here gender" name="gender" id="gender" value="Female"
										data-gender="f" maxlength="190" placeholder="Gender..." readonly>
									<small class="msg gender"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="status">Account status <small>(click to change)</small></label>
									<input type="text" class="form-control bg-white text-dark pointer-here status" name="status" id="status" value="Deactivated"
										data-status="0" maxlength="190" placeholder="Account status..." readonly>
									<small class="msg status"></small>
								</div>
								<small class="text-muted pointer-here float-right" title="Default password:&ensp;cte@bu">Hint</small>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Create account</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="UpdateAcct" tabindex="-1" role="dialog" aria-labelledby="UpdateAcctLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="UpdateAcctLabel">Update account</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="edit_form" novalidate>
					<div class="modal-body">
						<input type="password" class="d-none" name="account" id="account">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_given">Given name</label>
									<input type="text" class="form-control text-dark" name="edt_given" id="edt_given"
										maxlength="190" placeholder="Given name...">
									<small class="msg edt_given"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_surname">Surname</label>
									<input type="text" class="form-control text-dark" name="edt_surname" id="edt_surname"
										maxlength="190" placeholder="Surname...">
									<small class="msg edt_surname"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_username">Username</label>
									<input type="text" class="form-control text-dark" name="edt_username" id="edt_username"
										maxlength="190" placeholder="Username...">
									<small class="msg edt_username"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_email">Email</label>
									<input type="text" class="form-control text-dark" name="edt_email" id="edt_email"
										maxlength="190" placeholder="Email...">
									<small class="msg edt_email"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_status">Account status <small>(click to change)</small></label>
									<input type="text" class="form-control bg-white text-dark pointer-here status" name="edt_status" id="edt_status"
										maxlength="190" placeholder="Account status..." readonly>
									<small class="msg edt_status"></small>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-neutral btn-sm text-warning mr-auto" id="reset_btn" title="Default password:&ensp;cte@bu">
							Reset password
						</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Update account</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<?php include './components/layout/Scripts.php'; ?>
	<script src="./dist/vendor/chart.js/dist/Chart.min.js"></script>
	<script src="./dist/vendor/chart.js/dist/Chart.extension.js"></script>
	<script src="./dist/vendor/ckeditor/ckeditor.js"></script>
	<script src="./dist/vendor/fancybox/jquery.fancybox.min.js"></script>
	<script src="./assets/js/accounts.js"></script>
</body>

</html>