<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SAS (Smart Attendance Student)</title>
    <link rel="icon" href="<?= base_url('assets/img/logo.png'); ?>" type="image/x-icon">
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <!-- <link href="assets/css/sb-admin-2.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sb-admin-2.css'); ?>">

    <!-- INI CSS LOCAL -->
    <link rel="stylesheet" href="assets/css/sas.css">

</head>

<body>
    <!-- Splash Screen -->
    <div class="splash-screen" id="splash">
        <img src="assets/img/sas.png" alt="Loading">
    </div>
    <div id="main-content" style="display: none;">
        <div class="background"></div>
        <div class="element top-left"></div>
        <div class="element bottom-right"></div>
        <div class="logo left-in-fade"></div>

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div>
                                <div class="login-container right-in-fade-06">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Sign In</h1>
                                        </div>
                                        <form class="user" method="post" action="<?= base_url('auth/proses_login'); ?>">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="id_user"
                                                    placeholder="Masukan NPM" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    name="password" placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <?php if ($this->session->flashdata('error')): ?>
                                                <div class="alert alert-danger">
                                                    <?php echo $this->session->flashdata('error'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <button type="submit" class="btn btn-sas btn-user btn-block">
                                                Login
                                            </button>

                                            <!-- <a href="<?= base_url('home'); ?>" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </a> -->
                                            <hr>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                document.getElementById("splash").classList.add("hidden");
                setTimeout(() => {
                    document.getElementById("splash").style.display = "none";
                    document.getElementById("main-content").style.display = "block";
                }, 500);
            }, 1000); // Splash screen will be visible for 2 seconds
        });
    </script>
</body>

</html>