<?php
include './components/functions/Functions.php';
SeshStart('page');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home Page | BUCTE Administration</title>
    <?php include './components/layout/Head.php'; ?>
    <link rel="stylesheet" href="./dist/vendor/fancybox/jquery.fancybox.min.css">
    <link rel="stylesheet" href="./dist/vendor/sweetalert2/dist/sweetalert2.min.css">
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
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 d-inline-block mb-0">Edit &raquo; Home Page</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)"><i
                                                class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Pages</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <!-- <button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#NewEvent">New button</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row card-wrapper justify-content-center">
                <div class="col-lg-12 editor-container">
                    <!-- MAIN CONTENT HERE -->
                    <div class="card-wrapper">
                        <div class="card card-shadow">
                            <form role="form" id="homepage_form" enctype="multipart/form-data">
                                <input type="password" class="d-none" name="u_id" id="author" hidden>
                                <input type="password" class="d-none" value="homepage" name="alias" id="alias" hidden>
                                <div class="card-body">
                                    <div class="form-group mb-2">
                                        <label class="form-control-label" for="title">Event title</label>
                                        <input type="text" class="form-control text-dark" name="title" id="title"
                                            maxlength="190" placeholder="Write title...">
                                        <small class="title"></small>
                                    </div>
                                    <div class="form-group mb-2 images">
                                        <!---View and Edit of image here {assets/hndlr/images.php} --->
                                    </div>

                                    <div class="form-group mb-2 content" style="display:none">
                                        <label class="form-control-label" for="content">Body</label>
                                        <textarea class="form-control ckwrite" name="content" id="content_body" rows="5"
                                            placeholder="Write content body..."></textarea>
                                        <small class="content_body"></small>
                                    </div>

                                    <div class="form-group mb-2 edit-holder">
                                        <label class="form-control-label" for="content">Body</label>
                                        <div class="col-md-12 col-sm-12 content-style"
                                            style="padding:10px; height: 370px; overflow: auto; border: solid 1px #d1d1d1;">
                                            <div class="scrollbar-inner">
                                                <div id="content-view" style="padding"></div>
                                            </div>
                                        </div>
                                        <div class="show-edit"> CLICK HERE TO EDIT. </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12"><label class="form-control-label"
                                                for="content">Optional:</label></div>
                                        <div class="col-md-12 row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label class="form-control-label" for="meta1">Author</label>
                                                    <input type="text" class="form-control text-dark" name="meta1"
                                                        id="meta1" maxlength="190" placeholder="Author...">
                                                    <small class="title"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label class="form-control-label">Signature
                                                        (Image)</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="meta2" accept="image/*" class="custom-file-input" id="customFileLang">
                                                        <label class="custom-file-label" for="customFileLang"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2 flex-center">
                                        <div class="btn-xlg-container"><button type="submit" name="save_changes"
                                                class="btn btn-lg btn-block bg-gradient-primary text-white ">Save
                                                Changes</button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    <script src="./dist/vendor/ckeditor/ckeditor.js"></script>
    <script src="./dist/vendor/fancybox/jquery.fancybox.min.js"></script>
    <script src="./assets/js/pages.js"></script>
    <script src="./dist/vendor/ckeditor/ckeditor.js"></script>
    <script src="./dist/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./assets/js/homepage.js"></script>
</body>

</html>