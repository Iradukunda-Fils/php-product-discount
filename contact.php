<?php
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
    <meta content="Devslab Ltd" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- SITE TITLE -->
    <title>Contact us - Discrounts</title>
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
                        <h1>Contact</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Contact</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START SECTION CONTACT -->
        <div class="section pb_70">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="contact_wrap contact_style3">
                            <div class="contact_icon">
                                <i class="linearicons-map2"></i>
                            </div>
                            <div class="contact_text">
                                <span>Address</span>
                                <p>Kigali, Rwanda - </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="contact_wrap contact_style3">
                            <div class="contact_icon">
                                <i class="linearicons-envelope-open"></i>
                            </div>
                            <div class="contact_text">
                                <span>Email Address</span>
                                <a href="mailto:info@disscrounts.rw">info@disscrounts.rw </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="contact_wrap contact_style3">
                            <div class="contact_icon">
                                <i class="linearicons-tablet2"></i>
                            </div>
                            <div class="contact_text">
                                <span>Phone</span>
                                <p>+250 782 230 807</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION CONTACT -->

        <!-- START SECTION CONTACT -->
        <div class="section pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="heading_s1">
                            <h2>Get In touch</h2>
                        </div>
                        <p class="leads">We're here to help! If you have any questions, feedback, or need assistance, please feel free to reach out to us using the following contact details:</p>
                        <div class="field_form">
                            <form method="post" name="enq">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input required placeholder="Enter Name *" id="first-name" class="form-control" name="name" type="text">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input required placeholder="Enter Email *" id="email" class="form-control" name="email" type="email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input required placeholder="Enter Phone No. *" id="phone" class="form-control" name="phone">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input placeholder="Enter Subject" id="subject" class="form-control" name="subject">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <textarea required placeholder="Message *" id="description" class="form-control" name="message" rows="4"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" title="Submit Your Message!" class="btn btn-fill-out" id="submitButton" name="submit" value="Submit">Send Message</button>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="alert-msg" class="alert-msg text-center"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 pt-2 pt-lg-0 mt-4 mt-lg-0">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d31900.224058815726!2d30.04911651721231!3d-1.9414636594109653!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e6!4m3!3m2!1d-1.9329976!2d30.078077399999998!4m5!1s0x19dca4189c192a01%3A0x1abff61613ac0602!2schic%20building%20kigali!3m2!1d-1.9417514!2d30.0589396!5e0!3m2!1sen!2srw!4v1623050906521!5m2!1sen!2srw" width="100%" height="470" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- END SECTION FOOTER -->
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
        <!-- Google Map Js -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7TypZFTl4Z3gVtikNOdGSfNTpnmq-ahQ&amp;callback=initMap"></script>
        <!-- scripts js -->
        <script src="assets/js/scripts.js"></script>

</body>

</html>