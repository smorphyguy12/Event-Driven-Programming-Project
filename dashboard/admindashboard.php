
<?php include 'partials/main.php'; ?>

<head>
    <?php
    $title = "Dashboard 2";
    include 'partials/title-meta.php'; ?>

        <!-- plugin css -->
        <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

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
                        $sub_title = "Dashboards";
                        $title = "Dashboard 2";
                        include 'partials/page-title.php'; ?>

                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="avatar-sm bg-blue rounded">
                                                    <i class="fe-aperture avatar-title font-22 text-white"></i>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-end">
                                                    <h3 class="text-dark my-1">$<span data-plugin="counterup">12,145</span></h3>
                                                    <p class="text-dark mb-1 text-truncate">Email Messaging Integration</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="text-uppercase">Target <span class="float-end">60%</span></h6>
                                            <div class="progress progress-sm m-0">
                                                <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                    <span class="visually-hidden">60% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="avatar-sm bg-success rounded">
                                                    <i class="fe-shopping-cart avatar-title font-22 text-white"></i>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-end">
                                                    <h3 class="text-dark my-1"><span data-plugin="counterup">1576</span></h3>
                                                    <p class="text-dark mb-1 text-truncate">Chatting System</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="text-uppercase">Target <span class="float-end">49%</span></h6>
                                            <div class="progress progress-sm m-0">
                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="49" aria-valuemin="0" aria-valuemax="100" style="width: 49%">
                                                    <span class="visually-hidden">49% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="avatar-sm bg-warning rounded">
                                                    <i class="fe-bar-chart-2 avatar-title font-22 text-white"></i>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-end">
                                                    <h3 class="text-dark my-1">$<span data-plugin="counterup">8947</span></h3>
                                                    <p class="text-muted mb-1 text-truncate">Calendar Activities</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="text-uppercase">Target <span class="float-end">18%</span></h6>
                                            <div class="progress progress-sm m-0">
                                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100" style="width: 18%">
                                                    <span class="visually-hidden">18% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="avatar-sm bg-info rounded">
                                                    <i class="fe-cpu avatar-title font-22 text-white"></i>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-end">
                                                    <h3 class="text-dark my-1"><span data-plugin="counterup">178</span></h3>
                                                    <p class="text-muted mb-1 text-truncate">Task Management</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="text-uppercase">Target <span class="float-end">74%</span></h6>
                                            <div class="progress progress-sm m-0">
                                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100" style="width: 74%">
                                                    <span class="visually-hidden">74% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->


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

        <!-- Plugins js-->
        <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

        <!-- Dashboard 2 init -->
        <script src="assets/js/pages/dashboard-2.init.js"></script>
       
    </body>
</html>