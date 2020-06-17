<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Assessment Form | BUCTE Administration</title>
	<?php include './components/layout/Head.php'; ?>
	<!-- <style>
  .row {
    display: table;
  }

  .row [class*="col-"] {
      float: none;
      display: table-cell;
      vertical-align: top;
  }
  </style> -->
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
							<h6 class="h2 d-inline-block mb-0">Assessment Form</h6>
							<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
								<ol class="breadcrumb breadcrumb-links">
									<li class="breadcrumb-item"><a href="javascript:void(0)"><i
												class="fas fa-home"></i></a></li>
									<li class="breadcrumb-item"><a href="events.php">Events</a></li>
									<li class="breadcrumb-item active" aria-current="page">Assessment Form</li>
								</ol>
							</nav>
						</div>
						<div class="col-lg-6 col-5 text-right">
							<button class="btn btn-sm btn-neutral" id="add_btn" data-toggle="modal"
								data-target="#AddItem" title="Add item...">Add item</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Page content -->
		<div class="container-fluid mt--6">
			<div class="row card-wrapper event_title d-none">
				<div class="col-lg-12">
					<div class="card card-shadow">
						<div class="card-body pb-1">
							<p class="font-weight-bold event_title"></p>
						</div>
					</div>
				</div>
			</div>

			<div class="row card-wrapper items-container">
				<!-- MAIN CONTENT HERE -->




			</div>
			<!-- Footer -->
			<?php include './components/layout/Footer.php'; ?>
		</div>
	</div>

	<!-- Modals -->
	<div class="modal fade" id="AddItem" tabindex="-1" role="dialog" aria-labelledby="AddItemLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="AddItemLabel">Add item</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="item_form">
					<div class="modal-body">
						<input type="password" class="d-none author" name="author">
						<!-- <input type="password" class="d-none event" name="event"> -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-3">
									<label class="form-control-label" for="question">Question</label>
									<textarea class="form-control text-dark question" name="question" id="question"
										rows="2" placeholder="Write a question..."></textarea>
									<small class="question"></small>
								</div>

								<label class="form-control-label" for="answer">Choices</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control text-dark options" name="optionA" id="answer"
										data-radio="a" placeholder="First choice">
								</div>
								<div class="input-group mb-2">
									<input type="text" class="form-control text-dark options" name="optionB"
										data-radio="b" placeholder="Second choice">
								</div>
								<div class="input-group mb-2">
									<input type="text" class="form-control text-dark options" name="optionC"
										data-radio="c" placeholder="Third choice">
								</div>
								<div class="input-group mb-2">
									<input type="text" class="form-control text-dark options" name="optionD"
										data-radio="d" placeholder="Fourth choice">
								</div>
								<small class="answer options"></small>
							</div>
							<!-- <div class="col-md-6"></div> -->
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Create new</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="UpdateItem" tabindex="-1" role="dialog" aria-labelledby="UpdateItemLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="UpdateItemLabel">Edit item</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" id="update_form">
					<div class="modal-body">
						<input type="password" class="d-none event" name="edt_item">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-3">
									<label class="form-control-label" for="edt_question">Question</label>
									<textarea class="form-control text-dark question" name="edt_question"
										id="edt_question" rows="2" placeholder="Write a question..."></textarea>
									<small class="edt_question"></small>
								</div>

								<label class="form-control-label" for="edt_answer">Choices</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control text-dark options" name="optionA"
										id="edt_answer" data-radio="a" placeholder="First choice">
								</div>
								<div class="input-group mb-2">
									<input type="text" class="form-control text-dark options" name="optionB"
										data-radio="b" placeholder="Second choice">
								</div>
								<div class="input-group mb-2">
									<input type="text" class="form-control text-dark options" name="optionC"
										data-radio="c" placeholder="Third choice">
								</div>
								<div class="input-group mb-2">
									<input type="text" class="form-control text-dark options" name="optionD"
										data-radio="d" placeholder="Fourth choice">
								</div>
								<small class="answer options"></small>
							</div>
							<!-- <div class="col-md-6"></div> -->
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-primary text-white">Create new</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<?php include './components/layout/Scripts.php'; ?>
	<script src="./assets/js/assessment.js"></script>
</body>

</html>