<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
  <title>E-LET Questionnaire | BUCTE Administration</title>
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
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">E-LET Questionnaire</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="javascript:void(0)"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="reviewer.php">E-LET Reviewer</a></li>
                  <li class="breadcrumb-item active" aria-current="page">E-LET Questionnaire</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#AddItem">Add item</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row card-wrapper reviewer_title d-none">
        <div class="col-lg-10">
          <div class="card card-shadow">
            <div class="card-body pb-1">
              <p class="font-weight-bold reviewer_title"></p>
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
            <input type="text" class="d-none reviewer" name="reviewer">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-3">
                  <label for="question"><small>Question</small></label>
                  <textarea class="form-control text-dark question" name="question" rows="2"
                    placeholder="Write a question..."></textarea>
                  <small class="question"></small>
                </div>

                <label for="question"><small>Choices</small></label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" data-target="a">
                      <input type="radio" class="answer" name="answer" value="a" disabled>
                    </div>
                  </div>
                  <input type="text" class="form-control text-dark options" data-radio="a" name="optionA"
                    placeholder="First choice">
                </div>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" data-target="b">
                      <input type="radio" class="answer" name="answer" value="b" disabled>
                    </div>
                  </div>
                  <input type="text" class="form-control text-dark options" data-radio="b" name="optionB"
                    placeholder="Second choice">
                </div>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" data-target="c">
                      <input type="radio" class="answer" name="answer" value="c" disabled>
                    </div>
                  </div>
                  <input type="text" class="form-control text-dark options" data-radio="c" name="optionC"
                    placeholder="Third choice">
                </div>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" data-target="d">
                      <input type="radio" class="answer" name="answer" value="d" disabled>
                    </div>
                  </div>
                  <input type="text" class="form-control text-dark options" data-radio="d" name="optionD"
                    placeholder="Fourth choice">
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
          <h5 class="modal-title" id="UpdateItemLabel">Update item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" id="update_form">
          <div class="modal-body">
            <input type="password" class="d-none author" name="author">
            <input type="text" class="d-none question_id" name="question_id">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-3">
                  <label for="question"><small>Question</small></label>
                  <textarea class="form-control text-dark question" name="question" rows="2"
                    placeholder="Write a question..."></textarea>
                  <small class="question"></small>
                </div>

                <label for="answer"><small>Choices</small></label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" data-target="a">
                      <input type="radio" class="answer" name="answer" value="a" disabled>
                    </div>
                  </div>
                  <input type="text" class="form-control text-dark options" data-radio="a" name="optionA"
                    placeholder="First choice">
                </div>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" data-target="b">
                      <input type="radio" class="answer" name="answer" value="b" disabled>
                    </div>
                  </div>
                  <input type="text" class="form-control text-dark options" data-radio="b" name="optionB"
                    placeholder="Second choice">
                </div>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" data-target="c">
                      <input type="radio" class="answer" name="answer" value="c" disabled>
                    </div>
                  </div>
                  <input type="text" class="form-control text-dark options" data-radio="c" name="optionC"
                    placeholder="Third choice">
                </div>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" data-target="d">
                      <input type="radio" class="answer" name="answer" value="d" disabled>
                    </div>
                  </div>
                  <input type="text" class="form-control text-dark options" data-radio="d" name="optionD"
                    placeholder="Fourth choice">
                </div>
                <small class="answer options"></small>
              </div>
              <div class="col-md-12">

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn bg-gradient-primary text-white">Update item</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <?php include './components/layout/Scripts.php'; ?>
  <script src="./assets/js/questionnaire.js"></script>
</body>

</html>