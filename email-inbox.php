
<?php
include 'services/session.php';
include 'services/session-auth.php';
include 'services/database.php';
?>
<?php include 'partials/main.php'; ?>

<head>
    <?php
    $title = "Email Inbox";
    include 'partials/title-meta.php'; ?>

	   <?php include 'partials/head-css.php'; ?>
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <?php include 'partials/menu.php'; ?>

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                <?php include 'partials/topbar.php'; ?>

                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <?php
$sub_title = "Email";$title = "Inbox";
include 'partials/page-title.php'; ?>


                        <div class="row">

                            <!-- Right Sidebar -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Left sidebar -->
                                    <div class="inbox-leftbar">

                                        <a href="email-compose.php" class="btn btn-danger w-100 waves-effect waves-light">Compose</a>

                                        <div class="mail-list mt-4">
                                            <a href="javascript: void(0);" class="text-danger fw-bold"><i class="dripicons-inbox me-2"></i>Inbox<span class="badge badge-soft-danger float-end ms-2">7</span></a>
                                            <a href="javascript: void(0);"><i class="dripicons-star me-2"></i>Starred</a>
                                            <a href="javascript: void(0);"><i class="dripicons-clock me-2"></i>Snoozed</a>
                                            <a href="javascript: void(0);"><i class="dripicons-document me-2"></i>Draft<span class="badge badge-soft-info float-end ms-2">32</span></a>
                                            <a href="javascript: void(0);"><i class="dripicons-exit me-2"></i>Sent Mail</a>
                                            <a href="javascript: void(0);"><i class="dripicons-trash me-2"></i>Trash</a>
                                            <a href="javascript: void(0);"><i class="dripicons-tag me-2"></i>Important</a>
                                            <a href="javascript: void(0);"><i class="dripicons-warning me-2"></i>Spam</a>
                                        </div>

                                        <h6 class="mt-4">Labels</h6>

                                        <div class="list-group b-0 mail-list">
                                            <a href="#" class="list-group-item border-0"><span class="mdi mdi-circle text-info me-2"></span>Web App</a>
                                            <a href="#" class="list-group-item border-0"><span class="mdi mdi-circle text-warning me-2"></span>Recharge</a>
                                            <a href="#" class="list-group-item border-0"><span class="mdi mdi-circle text-dark me-2"></span>Wallet Balance</a>
                                            <a href="#" class="list-group-item border-0"><span class="mdi mdi-circle text-primary me-2"></span>Friends</a>
                                            <a href="#" class="list-group-item border-0"><span class="mdi mdi-circle text-success me-2"></span>Family</a>
                                        </div>

                                    </div>
                                    <!-- End Left sidebar -->

                                    <div class="inbox-rightbar">

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-archive font-18"></i></button>
                                            <button type="button" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-alert-octagon font-18"></i></button>
                                            <button type="button" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-delete-variant font-18"></i></button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-folder font-18"></i>
                                                <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <span class="dropdown-header">Move to</span>
                                                <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-label font-18"></i>
                                                <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <span class="dropdown-header">Label as:</span>
                                                <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                            </div>
                                        </div>

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal font-18"></i> More
                                                <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <span class="dropdown-header">More Option :</span>
                                                <a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Add Star</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Mute</a>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <ul class="message-list">
                                                <li class="unread">
                                                    <div class="col-mail col-mail-1">
                                                        <div class="checkbox-wrapper-mail">
                                                            <input type="checkbox" id="chk1">
                                                            <label for="chk1" class="toggle"></label>
                                                        </div>
                                                        <span class="star-toggle far fa-star text-warning"></span>
                                                        <a href="" class="title">Lucas Kriebel (via Twitter)</a>
                                                    </div>
                                                    <div class="col-mail col-mail-2">
                                                        <a href="" class="subject">Lucas Kriebel (@LucasKriebel) has sent
                                                            you a direct message on Twitter! &nbsp;&ndash;&nbsp;
                                                            <span class="teaser">@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                                        </a>
                                                        <div class="date">11:49 am</div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="col-mail col-mail-1">
                                                        <div class="checkbox-wrapper-mail">
                                                            <input type="checkbox" id="chk3">
                                                            <label for="chk3" class="toggle"></label>
                                                        </div>
                                                        <span class="star-toggle far fa-star"></span>
                                                        <a href="" class="title">Randy, me (5)</a>
                                                    </div>
                                                    <div class="col-mail col-mail-2">
                                                        <a href="" class="subject">Last pic over my village &nbsp;&ndash;&nbsp;
                                                            <span class="teaser">Yeah i'd like that! Do you remember the video you showed me of your train ride between Colombo and Kandy? The one with the mountain view? I would love to see that one again!</span>
                                                        </a>
                                                        <div class="date">5:01 am</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- end .mt-4 -->

                                        <div class="row">
                                            <div class="col-7 mt-1">
                                                Showing 1 - 20 of 289
                                            </div> <!-- end col-->
                                            <div class="col-5">
                                                <div class="btn-group float-end">
                                                    <button type="button" class="btn btn-light btn-sm"><i class="mdi mdi-chevron-left"></i></button>
                                                    <button type="button" class="btn btn-info btn-sm"><i class="mdi mdi-chevron-right"></i></button>
                                                </div>
                                            </div> <!-- end col-->
                                        </div>
                                        <!-- end row-->
                                    </div> 
                                    <!-- end inbox-rightbar-->

                                    <div class="clearfix"></div>
                                    </div>
                                </div> <!-- end card -->

                            </div> <!-- end Col -->
                        </div><!-- End row -->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <?php include 'partials/footer.php'; ?>

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <?php include 'partials/right-sidebar.php'; ?>
        
        <?php include 'partials/footer-scripts.php'; ?>

        <!-- Inbox init -->
        <script src="assets/js/pages/inbox.js"></script>
       
    </body>
</html>