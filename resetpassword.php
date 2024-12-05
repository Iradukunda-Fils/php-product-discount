<?php
ob_start();

require("configs/connection.php");
require("configs/test.data.php");
require("configs/session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Discrounts" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- SITE TITLE -->
    <title>Reset Password</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/linearicons.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/simple-line-icons.css">
    <!--- owl carousel CSS-->
    <link rel="stylesheet" href="assets/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.css">
    <link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.default.min.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/slick-theme.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body>

    <!-- LOADER -->
<!--    <div class="preloader">-->
<!--        <div class="lds-ellipsis">-->
<!--            <span></span>-->
<!--            <span></span>-->
<!--            <span></span>-->
<!--        </div>-->
<!--    </div>-->
    <!-- END LOADER -->

    <!-- START HEADER -->
    <?php require("templates/header.php"); ?>
    <!-- END HEADER -->

    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container">
            <!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Reset Password</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">Reset Password</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START LOGIN SECTION -->
        <div class="login_register_wrap section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-md-10">

                        <?php require("configs/scripts.php"); ?>

                        <div class="login_wrap">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <h3>Submit your email</h3>
                                </div>
                                <form method="post">
                                    <div class="form-group">
                                        <input type="email" required class="form-control" name="email" placeholder="Email">
                                    </div>


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-fill-out btn-block" name="resetPassword">Submit</button>
                                    </div>
                                </form>

                                <div class="different_login">
                                    <span> or</span>
                                </div>
                                <!-- <ul class="btn-login list_none text-center">
                                    <li><a href="#" class="btn btn-facebook"><i class="ion-social-facebook"></i>Facebook</a></li>
                                    <li><a href="#" class="btn btn-google"><i class="ion-social-googleplus"></i>Google</a></li>
                                </ul> -->
                                <div class="form-note text-center">Don't Have an Account? <a href="signup">Sign up now</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END LOGIN SECTION -->


        <!-- START FOOTER -->
        <?php require('templates/footer.php'); ?>
        <!-- END FOOTER -->



        <!-- Latest jQuery -->
        <script src="assets/js/jquery-1.12.4.min.js"></script>
        <!-- popper min js -->
        <script src="assets/js/popper.min.js"></script>
        <!-- Latest compiled and minified Bootstrap -->
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- owl-carousel min js  -->
        <script src="assets/owlcarousel/js/owl.carousel.min.js"></script>
        <!-- magnific-popup min js  -->
        <script src="assets/js/magnific-popup.min.js"></script>
        <!-- waypoints min js  -->
        <script src="assets/js/waypoints.min.js"></script>
        <!-- parallax js  -->
        <script src="assets/js/parallax.js"></script>
        <!-- countdown js  -->
        <script src="assets/js/jquery.countdown.min.js"></script>
        <!-- imagesloaded js -->
        <script src="assets/js/imagesloaded.pkgd.min.js"></script>
        <!-- isotope min js -->
        <script src="assets/js/isotope.min.js"></script>
        <!-- jquery.dd.min js -->
        <script src="assets/js/jquery.dd.min.js"></script>
        <!-- slick js -->
        <script src="assets/js/slick.min.js"></script>
        <!-- elevatezoom js -->
        <script src="assets/js/jquery.elevatezoom.js"></script>
        <!-- scripts js -->
        <script src="assets/js/scripts.js"></script>

</body>

</html>