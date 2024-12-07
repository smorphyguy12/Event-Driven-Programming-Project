<?php
session_start();

include 'services/database.php';

if (isset($_SESSION['id'])) {
    header('location: dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $student_id = htmlspecialchars(trim($_POST['student_id']));
    $password = trim($_POST['password']);

    try {
        $student = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
        $student->bind_param("s", $student_id);
        $student->execute();
        $resultStudent = $student->get_result();

        $user = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $user->bind_param("s", $student_id);
        $user->execute();
        $resultUser = $user->get_result();

        if ($resultStudent->num_rows > 0) {
            $fetchStudent = $resultStudent->fetch_assoc();

            if (password_verify($password, $fetchStudent['password'])) {
                session_regenerate_id(true);

                $_SESSION['student'] = true;
                $_SESSION['id'] = $fetchStudent['id'];
                $_SESSION['student_id'] = $fetchStudent['student_id'];
                $_SESSION['fullname'] = $fetchStudent['fullname'];
                $_SESSION['course'] = $fetchStudent['course'];
                $_SESSION['email'] = $fetchStudent['email'];

                $student->close();
                $user->close();

                header("Location: dashboard.php");
                exit();
            }
        } else if ($resultUser->num_rows > 0) {
            $fetchUser = $resultUser->fetch_assoc();

            if (password_verify($password, $fetchUser['password'])) {
                session_regenerate_id(true);

                $_SESSION['user'] = true;
                $_SESSION['id'] = $fetchUser['id'];
                $_SESSION['username'] = $fetchUser['username'];
                $_SESSION['email'] = $fetchUser['email'];

                $student->close();
                $user->close();

                header("Location: dashboard.php");
                exit();
            }
        }

        echo "<script>alert('Invalid Credentials')</script>";
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
    }
}
?>

<?php include 'partials/main.php'; ?>

<head>
    <?php
    $title = "Log In";
    include 'partials/title-meta.php'; ?>

    <?php include 'partials/head-css.php'; ?>
</head>

<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-brand">
                                    <a href="index.php" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="assets/images/logo-dark.png" alt="" height="100">
                                        </span>
                                    </a>

                                    <a href="index.php" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="assets/images/logo-light.png" alt="" height="100">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-dark mb-4 mt-3">Hello Madlang People.</p>
                            </div>

                            <form method="POST">

                                <div class="mb-3">
                                    <label for="student_id" class="form-label">Student ID</label>
                                    <input class="form-control" type="text" id="student_id" placeholder="Enter your student id" name="student_id">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>

                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="auth-recoverpw.php" class="text-white-50 ms-1">Did you Forgot your password,Try Again?</a></p>
                            <p class="text-white-50">Don't have an account? <a href="auth-register.php" class="text-white ms-1"><b>Sign Up</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Authentication js -->
    <script src="assets/js/pages/authentication.init.js"></script>

</body>

</html>