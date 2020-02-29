<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Events Management | BUCTE Administration</title>
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
              <h6 class="h2 text-white d-inline-block mb-0">Events</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="javascript:void(0)"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Events Management</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#NewEvent">New
                event</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row card-wrapper events-container">
          <!-- MAIN CONTENT HERE -->



      </div>
      <!-- Footer -->
      <?php include './components/layout/Footer.php'; ?>
    </div>
  </div>

  <!-- Modals -->
  <div class="modal fade" id="NewEvent" tabindex="-1" role="dialog" aria-labelledby="NewEventLabel" aria-hidden="true">
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
                <!-- <div class="form-group mb-2">
                  <label for="select_file"><small>Upload image</small></label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="select_file" id="select_file" lang="en">
                    <label class="custom-file-label select_file" for="select_file">Select a
                      file...</label>
                  </div>
                  <small class="select_file"></small>
                </div> -->
                <div class="form-group mb-2">
                  <label for="select_file"><small>Upload image</small></label>
                  <input type="text" class="form-control text-dark bg-white pointer-here" name="dummy" id="dummy" placeholder="Select a file..." readonly>
                  <input type="file" class="d-none" name="select_file" id="select_file" accept="image/jpeg,image/png">
                  <small class="select_file"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="title"><small>Event title</small></label>
                  <input type="text" class="form-control text-dark" name="title" id="title" placeholder="Title...">
                  <small class="title"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="date"><small>Date</small></label>
                  <input type="date" class="form-control text-dark" name="date" id="date">
                  <small class="date"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="venue"><small>Venue</small></label>
                  <input type="text" class="form-control text-dark" name="venue" id="venue" placeholder="Venue...">
                  <small class="venue"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="description"><small>Description</small></label>
                  <textarea class="form-control ckwrite" name="description" id="description" rows="5"
                    placeholder="Write description..."></textarea>
                  <small class="description"></small>
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

  <!-- Scripts -->
  <?php include './components/layout/Scripts.php'; ?>
  <script src="./dist/vendor/ckeditor/ckeditor.js"></script>
  <script src="./assets/js/events.js"></script>
</body>

</html>