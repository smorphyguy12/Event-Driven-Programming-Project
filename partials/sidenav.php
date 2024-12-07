<!-- ========== Menu ========== -->
<div class="app-menu">

    <!-- Brand Logo -->
    <div class="logo-box">
        <!-- Brand Logo Light -->
        <a href="index.php" class="logo-light">
            <img src="assets/images/logo-light.png" alt="logo" class="logo-lg" style="padding: 5px; height: 60px;">
            <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm" style="padding: 5px; height: 60px;">
        </a>

        <!-- Brand Logo Dark -->
        <a href="index.php" class="logo-dark">
            <img src="assets/images/logo-dark.png" alt="dark logo" class="logo-lg" style="padding: 5px; height: 60px;">
            <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm" style="padding: 5px; height: 60px;">
        </a>
    </div>

    <!-- menu-left -->
    <div class="scrollbar">

        <!-- User box -->
        <div class="user-box text-center">
            <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block" data-bs-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted mb-0">Admin Head</p>
        </div>

        <!--- Menu -->
        <ul class="menu">

            <li class="menu-title">Home</li>

            <li class="menu-item">
                <a href="dashboard.php" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-home"></i></span>
                    <span class="menu-text"> Dashboard </span>
                </a>
            </li>

            <li class="menu-title">Menu</li>

            <li class="menu-item">
                <a href="apps-calendar.php" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-calendar"></i></span>
                    <span class="menu-text"> Calendar </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="apps-chat.php" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-forum-outline"></i></span>
                    <span class="menu-text"> Chat </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#menuEmail" data-bs-toggle="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-email-multiple-outline"></i></span>
                    <span class="menu-text"> Email </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="menuEmail">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="email-inbox.php" class="menu-link">
                                <span class="menu-text">Inbox</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="email-read.php" class="menu-link">
                                <span class="menu-text">Read Email</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="email-compose.php" class="menu-link">
                                <span class="menu-text">Compose Email</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="email-templates.php" class="menu-link">
                                <span class="menu-text">Email Templates</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item">
                <a href="#menuTasks" data-bs-toggle="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-clipboard-multiple-outline"></i></span>
                    <span class="menu-text"> Tasks </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="menuTasks">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="task-list.php" class="menu-link">
                                <span class="menu-text">List</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="task-details.php" class="menu-link">
                                <span class="menu-text">Details</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="task-kanban-board.php" class="menu-link">
                                <span class="menu-text">Kanban Board</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <!--- End Menu -->
        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left menu End ========== -->