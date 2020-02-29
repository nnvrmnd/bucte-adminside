<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
  <title>E-LET Reviewer | BUCTE Administration</title>
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
              <h6 class="h2 text-white d-inline-block mb-0">E-LET Reviewer</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="javascript:void(0)"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">E-LET Reviewer</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#NewReviewer">New
                reviewer</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row card-wrapper reviewers-container">
        <!-- MAIN CONTENT HERE -->




      </div>
      <!-- Footer -->
      <?php include './components/layout/Footer.php'; ?>
    </div>
  </div>

  <!-- Modals -->
  <div class="modal fade" id="NewReviewer" tabindex="-1" role="dialog" aria-labelledby="NewReviewerLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="NewReviewerLabel">New reviewer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" id="reviewer_form">
          <div class="modal-body">
            <input type="password" class="d-none" name="author">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-2">
                  <label for="title"><small>Reviewer title</small></label>
                  <input type="text" class="form-control text-dark" name="title" placeholder="Title..."
                    title="For easy search later">
                  <small class="title"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="source"><small>Reviewer source</small></label>
                  <input type="text" class="form-control text-dark" name="source" placeholder="Source...">
                  <small class="source"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="level"><small>Level</small></label>
                  <select class="form-control record-input" name="level">
                    <option value="" selected>Select level...</option>
                    <option value="gen">&emsp;- General Education</option>
                    <option value="prof">&emsp;- Professional Education</option>
                    <option value="">&emsp;Specialization:</option>
                    <option value="eng">&emsp;&emsp;- English</option>
                    <option value="fil">&emsp;&emsp;- Filipino</option>
                    <option value="bio">&emsp;&emsp;- Biological Sciences</option>
                    <option value="phys">&emsp;&emsp;- Physical Sciences</option>
                    <option value="math">&emsp;&emsp;- Mathematics</option>
                    <option value="socsci">&emsp;&emsp;- Social Studies/Sciences</option>
                    <option value="values">&emsp;&emsp;- Values</option>
                    <option value="mapeh">&emsp;&emsp;- MAPEH</option>
                    <option value="agri">&emsp;&emsp;- Agriculture and Fishery Arts</option>
                    <option value="tech">&emsp;&emsp;- Technology and Livelihood Education</option>
                  </select>
                  <small class="level"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="duration"><small>Test duration</small></label>
                  <select class="form-control record-input" name="duration">
                    <option value="" selected>Select duration...</option>
                    <option value="30">30 mins</option>
                    <option value="45">45 mins</option>
                    <option value="60">1 hour</option>
                    <option value="90">1 hour and 30 mins</option>
                    <option value="120">2 hours</option>
                  </select>
                  <small class="duration"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="description"><small>Description</small></label>
                  <textarea class="form-control text-dark" name="description" rows="5"
                    placeholder="Write reviewer description..."></textarea>
                </div>
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

  <div class="modal fade" id="EditReviewer" tabindex="-1" role="dialog" aria-labelledby="EditReviewerLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="EditReviewerLabel">Edit reviewer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" id="edit_form">
          <div class="modal-body">
            <input type="text" class="d-none" name="reviewer_id" id="reviewer_id">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-2">
                  <label for="title"><small>Reviewer title</small></label>
                  <input type="text" class="form-control text-dark" name="title" placeholder="Title..." id="title"
                    title="For easy search later">
                  <small class="title"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="source"><small>Reviewer source</small></label>
                  <input type="text" class="form-control text-dark" name="source" placeholder="Source...">
                  <small class="source"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="level"><small>Level</small></label>
                  <select class="form-control record-input" name="level">
                    <option value="" selected>Select level...</option>
                    <option value="gen">&emsp;- General Education</option>
                    <option value="prof">&emsp;- Professional Education</option>
                    <option value="">&emsp;Specialization:</option>
                    <option value="eng">&emsp;&emsp;- English</option>
                    <option value="fil">&emsp;&emsp;- Filipino</option>
                    <option value="bio">&emsp;&emsp;- Biological Sciences</option>
                    <option value="phys">&emsp;&emsp;- Physical Sciences</option>
                    <option value="math">&emsp;&emsp;- Mathematics</option>
                    <option value="socsci">&emsp;&emsp;- Social Studies/Sciences</option>
                    <option value="values">&emsp;&emsp;- Values</option>
                    <option value="mapeh">&emsp;&emsp;- MAPEH</option>
                    <option value="agri">&emsp;&emsp;- Agriculture and Fishery Arts</option>
                    <option value="tech">&emsp;&emsp;- Technology and Livelihood Education</option>
                  </select>
                  <small class="level"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="duration"><small>Test duration</small></label>
                  <select class="form-control record-input" name="duration">
                    <option value="" selected>Select duration...</option>
                    <option value="30">&emsp;30 mins</option>
                    <option value="45">&emsp;45 mins</option>
                    <option value="60">&emsp;1 hour</option>
                    <option value="90">&emsp;1 hour and 30 mins</option>
                    <option value="120">&emsp;2 hours</option>
                  </select>
                  <small class="duration"></small>
                </div>
                <div class="form-group mb-2">
                  <label for="description"><small>Description</small></label>
                  <textarea class="form-control text-dark" name="description" id="description" rows="5"
                    placeholder="Write reviewer description..."></textarea>
                </div>
              </div>
              <!-- <div class="col-md-6"></div> -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn bg-gradient-primary text-white">Update reviewer</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <?php include './components/layout/Scripts.php'; ?>
  <script src="./assets/js/reviewer.js"></script>
</body>

</html>