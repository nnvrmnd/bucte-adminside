<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Events Management | BUCTE Administration</title>
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
						<div class="col-lg-6">
							<h6 class="h2 d-inline-block mb-0">Events</h6>
							<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
								<ol class="breadcrumb breadcrumb-links">
									<li class="breadcrumb-item"><a href="javascript:void(0)"><i
												class="fas fa-home"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page">Events Management</li>
								</ol>
							</nav>
						</div>
						<div class="col-lg-6 text-right">
							<a href="assessment.php" class="btn btn-sm btn-neutral" id="assessment_form"
								title="Create new assessment form...">
								Assessment form
							</a>
							<button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#NewEvent">
								New event
							</button>
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
								<select class="form-control form-control-sm pointer-here" name="sort" title="Sort by...">
									<option value="title">&ensp;Title</option>
									<option value="sched">&ensp;Schedule</option>
									<option value="deadln">&ensp;Deadline</option>
									<option value="post" selected>&ensp;Date posted</option>
								</select>
								<span class="input-group-addon input-group-append">
									<button type="button" class="btn btn-sm btn-outline-primary" id="order" data-state="desc" title="Descending order">
										<span class="fas fa-long-arrow-alt-down"></span>
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="row card-wrapper">
				<div class="col-lg-12 events-container">
					<!-- MAIN CONTENT HERE -->
				</div>
			</div>
			<!-- Footer -->
			<?php include './components/layout/Footer.php'; ?>
		</div>
	</div>

	<!-- Modals -->
	<div class="modal fade" id="NewEvent" tabindex="-1" role="dialog" aria-labelledby="NewEventLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="NewEventLabel">New event</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="event_form" novalidate>
					<div class="modal-body">
						<input type="password" class="d-none" name="author" id="author">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="title">Event title</label>
									<input type="text" class="form-control text-dark" name="title" id="title"
										maxlength="190" placeholder="Title...">
									<small class="validation-msg title"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="select_file">Upload image</label>
									<input type="text" class="form-control text-dark bg-white pointer-here" name="dummy"
										id="dummy" placeholder="Select a file..." data-target="select_file" readonly>
									<input type="file" class="d-none file_select" name="select_file" id="select_file"
										accept="image/jpeg,image/png" data-target="dummy">
									<small class="validation-msg select_file"></small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-control-label" for="start_datetime">Start date</label>
									<input type="text" class="form-control text-dark datetimepicker pointer-here"
										name="start_datetime" id="start_datetime" value=""
										placeholder="Select date & time">
									<small class="validation-msg start_datetime"></small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-control-label" for="end_datetime">End date</label>
									<input type="text" class="form-control text-dark datetimepicker pointer-here"
										name="end_datetime" id="end_datetime" placeholder="Select date & time">
									<small class="validation-msg end_datetime"></small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-control-label" for="reg_deadline">Registration deadline</label>
									<input type="text" class="form-control text-dark datetimepicker pointer-here"
										name="reg_deadline" id="reg_deadline" placeholder="Select date & time">
									<small class="validation-msg reg_deadline"></small>
								</div>
							</div>
							<div class="col-md-6"></div>
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="venue">Venue</label>
									<input type="text" class="form-control text-dark" name="venue" id="venue"
										placeholder="Venue...">
									<small class="validation-msg venue"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="description">Description</label>
									<textarea class="form-control ckwrite" name="description" id="description" rows="5"
										placeholder="Write description..."></textarea>
									<small class="validation-msg description"></small>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Create event</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="EditEvent" tabindex="-1" role="dialog" aria-labelledby="EditEventLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="EditEventLabel">Edit event</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="edit_form" novalidate>
					<div class="modal-body">
						<input type="password" class="d-none" name="event_id" id="event_id">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_title">Event title</label>
									<input type="text" class="form-control text-dark" name="edt_title" id="edt_title"
										maxlength="190" placeholder="Title...">
									<small class="validation-msg edt_title"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_select_file">Upload new image</label>
									<input type="text" class="form-control text-dark bg-white pointer-here"
										name="edt_dummy" id="edt_dummy" placeholder="Select a file..."
										data-target="edt_select_file" readonly>
									<input type="file" class="d-none file_select" name="edt_select_file"
										id="edt_select_file" accept="image/jpeg,image/png" data-target="edt_dummy">
									<small class="validation-msg edt_select_file"></small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_start_datetime">Start date</label>
									<input type="text" class="form-control text-dark datetimepicker pointer-here"
										name="edt_start_datetime" id="edt_start_datetime" value=""
										placeholder="Select date & time">
									<small class="validation-msg edt_start_datetime"></small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_end_datetime">End date</label>
									<input type="text" class="form-control text-dark datetimepicker pointer-here"
										name="edt_end_datetime" id="edt_end_datetime" placeholder="Select date & time">
									<small class="validation-msg edt_end_datetime"></small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_reg_deadline">Registration
										deadline</label>
									<input type="text" class="form-control text-dark datetimepicker pointer-here"
										name="edt_reg_deadline" id="edt_reg_deadline" placeholder="Select date & time">
									<small class="validation-msg edt_reg_deadline"></small>
								</div>
							</div>
							<div class="col-md-6"></div>
							<div class="col-md-12">
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_venue">Venue</label>
									<input type="text" class="form-control text-dark" name="edt_venue" id="edt_venue"
										placeholder="Venue...">
									<small class="validation-msg edt_venue"></small>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label" for="edt_description">Description</label>
									<textarea class="form-control ckwrite" name="edt_description" id="edt_description"
										rows="5" placeholder="Write description..."></textarea>
									<small class="validation-msg edt_description"></small>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Update event</button>
					</div>
				</form>
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
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="EventAssessment" tabindex="-1" role="dialog" aria-labelledby="EventAssessmentLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="EventAssessmentLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="chart">
						<!-- Chart wrapper -->
						<canvas id="chart-bar-stacked7" class="chart-canvas"></canvas>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<?php include './components/layout/Scripts.php'; ?>
	<script src="./dist/vendor/chart.js/dist/Chart.min.js"></script>
	<script src="./dist/vendor/chart.js/dist/Chart.extension.js"></script>
	<script src="./dist/vendor/ckeditor/ckeditor.js"></script>
	<script src="./dist/vendor/fancybox/jquery.fancybox.min.js"></script>
	<script src="./assets/js/events.js"></script>
</body>

</html>