<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Records Management | BUCTE Administration</title>
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
              <h6 class="h2 text-white d-inline-block mb-0">Records</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="javascript:void(0)"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Records Management</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#UploadModal">Upload
                file</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row card-wrapper records-container">
        <!-- MAIN CONTENT HERE -->




      </div>
      <!-- Footer -->
      <?php include './components/layout/Footer.php'; ?>
    </div>
  </div>

  <!-- Modals -->
  <div class="modal fade" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="UploadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="UploadModalLabel">Upload</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" id="record_form">
          <div class="modal-body">
            <input type="password" class="d-none" name="author" id="author">
            <input type="text" class="d-none" name="format" id="format">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-2">
                  <label for="title"><small>File title</small></label>
                  <input type="text" class="form-control text-dark record-input" name="title" id="title"
                    title="For easy search later">
                  <small class="title"></small>
                </div>
                <div class="form-group mb-2 filetype-select">
                  <label for="file_type"><small>File type</small></label>
                  <select class="form-control record-input" name="file_type" id="file_type">
                    <option value="" selected>Select type...</option>
                    <option value="records">Records</option>
                    <option value="library">E-library</option>
                    <!-- <option value="other">Other</option> -->
                  </select>
                  <small class="text-danger file_type"></small>
                </div>
                <div class="form-group mb-2">
                  <input type="text" class="form-control text-dark record-input d-none" name="other_type"
                    id="other_type" placeholder="Specify other filetype...">
                  <small class="text-danger other_type"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="description"><small>Description</small></label>
                  <textarea class="form-control record-input" name="description" id="description" rows="5"
                    placeholder="Write file description..."></textarea>
                </div>
                <div class="form-group mb-2">
                  <label for="select_file"><small>Upload file</small></label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="select_file" id="select_file" lang="en">
                    <label class="custom-file-label select_file" for="select_file">Select a
                      file...</label>
                    </div>
                    <small class="select_file"></small>
                </div>
              </div>
              <!-- <div class="col-md-6"></div> -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn bg-gradient-primary text-white">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <?php include './components/layout/Scripts.php'; ?>
  <script src="./assets/js/records.js"></script>
</body>

</html>