
<?php
include 'services/database.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $hash_pass = password_hash($password, PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $confirm_pass = $_POST['confirm-password'];

    if ($password !== $confirm_pass) {
        echo "<script>alert('Password is not equal')</script>";
    } else {
        $sql = "INSERT INTO `users` (username, email, password) VALUES ('$fullname', '$email', '$hash_pass')";

        $result = mysqli_query($conn, $sql);
    
        if($result){
            header("Location: index.php");
            exit(); // Ensure script stops here to prevent further execution
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

}
?>
<?php include 'partials/main.php'; ?>
<?php include 'services/database.php'; ?>
<head>
    <?php
    $title = "Register & Signup";
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
                                <p class="text-dark mb-4 mt-3">Don't have an account? Create your account</p>
                            </div>

                            <form method="POST">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input class="form-control" type="text" name="fullname" id="fullname" placeholder="Enter your name" require>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="email" id="email" name="email" required placeholder="Enter your email" require>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" require>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm-password" class="form-label">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="confirm-password" id="confirm-password" name="confirm-password" class="form-control" placeholder="Confirm your password" require>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                    <div id="errorDisplay" class="text-danger"></div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signup" require>
                                        <label class="form-check-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>
                                    </div>
                                </div>
                                <div class="text-center d-grid">
                                    <button class="btn btn-success" id="registerBtn" type="submit"> Sign Up </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Already have account? <a href="/" class="text-white ms-1"><b>Sign In</b></a></p>
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



    <?php include 'partials/right-sidebar.php'; ?>
        
    <?php include 'partials/footer-scripts.php'; ?>

    <!-- Authentication js -->
    <!-- <script>
        $(document).ready(function () {
            $(document).on('click', '#registerBtn', function (e) {
                password = $('#password').val();
                confirm_pass = $('#confirm-password').val();

                if (password !== confirm_pass) {
                    $('#errorDisplay').text('Password not equal.');
                } else {
                    $('#errorDisplay').text('');
                }
            })

        })
    </script> -->
</body>

</html>