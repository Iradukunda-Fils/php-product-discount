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
    <title>Frequently Asked Questions - Discrounts</title>
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
    <div class="preloader">
        <div class="lds-ellipsis">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
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
                        <h1>Frequently asked question</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Faq</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- STAT SECTION FAQ -->
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="heading_s1 mb-3 mb-md-5">
                            <h3>General questions</h3>
                        </div>
                        <div id="accordion" class="accordion accordion_style1">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h6 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Discount</a> </h6>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Discounts are promotions set by seller for all products in the platform You can enjoy discounts when your total paid order amount reached a certain requirement.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h6 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Service commitment</a> </h6>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Service Commitment is limited to part of the products, specific as follows:
                                            15 days for goods that may shipped by air those are small items such as bags,clothes shoes , on small quantities not more than 20 pcs and 45 days for the high volume goods and goods with battery inside , liquide goods , powder goods and other goods that are prohibited to ship them by Air
                                            If you are unsatisfied with this product,you may return it within 7 days of delivery for a full refund
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h6 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Wholesale Discount</a> </h6>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <p> The preferential price of ordering more quantity at one time may give you the chance to get the big discount as your entering into B2B terms </p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h6 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Feedback</a> </h6>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>After you completed an order, you have the right to make a comment. The feedback would display in product's description. Different rates show buyers' various attitudes toward the item.</p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFive">
                                    <h6 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Wishlist</a> </h6>
                                </div>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                    <div class="card-body">
                                        <p> Put the products that you want to buy in your cart, then you could buy them at one time.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- END SECTION FAQ -->

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
        <!-- scripts js -->
        <script src="assets/js/scripts.js"></script>

</body>

</html>