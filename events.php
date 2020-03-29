<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Events Management | BUCTE Administration</title>
  <?php include './components/layout/Head.php'; ?>
  <style>
    img.rounded {
      max-height: 200px;
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
      <div class="row card-wrapper">
        <!-- MAIN CONTENT HERE -->
        <div class="col-lg-10 events-container">

          <!-- <div class="card card-shadow pointer-here" data-id="__ID">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <center>
                    <img alt="Image placeholder" src="./files/events/girl.jpg" class="img-fluid rounded">
                  </center>
                </div>
                <div class="col-md-9">
                  <button type="button" class="btn btn-sm btn-secondary text-danger float-right delete_event"
                    title="Delete event...">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-secondary text-purple float-right edit_event"
                    title="Edit event...">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </button>
                  <p class="font-weight-bold mb-0 text-primary">__TITLE</p>
                  <div class="mb-4">
                    <p>
                      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nostrum, modi?
                    </p>
                  </div>
                  <small class="text-muted">by __AUTHOR&nbsp;__SURNAME on 11th Feb 2020 at 01:04 AM</small>
                </div>
              </div>
            </div>
          </div> -->

        </div>
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
                <div class="form-group mb-2">
                  <label for="title"><small>Event title</small></label>
                  <input type="text" class="form-control text-dark" name="title" id="title" placeholder="Title...">
                  <small class="title"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="select_file"><small>Upload image</small></label>
                  <input type="text" class="form-control text-dark bg-white pointer-here" name="dummy" id="dummy"
                    placeholder="Select a file..." data-target="select_file" readonly>
                  <input type="file" class="d-none file_select" name="select_file" id="select_file"
                    accept="image/jpeg,image/png" data-target="dummy">
                  <small class="select_file"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="date"><small>Event date</small></label>
                  <input type="date" class="form-control text-dark" name="date" id="date">
                  <small class="date"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="venue"><small>Event venue</small></label>
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
        <form role="form" id="editevent_form" novalidate>
          <div class="modal-body">
            <input type="password" class="d-none" name="event_id">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-2">
                  <label><small>Event title</small></label>
                  <input type="text" class="form-control text-dark" name="edit_title" placeholder="Title...">
                  <small class="edit_title"></small>
                </div>
                <div class="form-group mb-2">
                  <label><small>Upload image</small></label>
                  <input type="text" class="form-control text-dark bg-white pointer-here" name="edit_dummy"
                    placeholder="Select a file..." data-target="edit_select_file" readonly>
                  <input type="file" class="d-none file_select" name="edit_select_file" accept="image/jpeg,image/png"
                    data-target="edit_dummy">
                  <small class="edit_select_file"></small>
                </div>
                <div class="form-group mb-2">
                  <label><small>Event date</small></label>
                  <input type="date" class="form-control text-dark" name="edit_date">
                  <small class="edit_date"></small>
                </div>
                <div class="form-group mb-2">
                  <label><small>Event venue</small></label>
                  <input type="text" class="form-control text-dark" name="edit_venue" placeholder="Venue...">
                  <small class="edit_venue"></small>
                </div>
                <div class="form-group mb-2">
                  <label><small>Description</small></label>
                  <textarea class="form-control ckwrite" name="edit_description" rows="5"
                    placeholder="Write description..."></textarea>
                  <small class="edit_description"></small>
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

  <!-- Scripts -->
  <?php include './components/layout/Scripts.php'; ?>
  <script src="./dist/vendor/ckeditor/ckeditor.js"></script>
  <script src="./assets/js/events.js"></script>
</body>

</html>