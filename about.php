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
    <title>About us - Discrounts</title>
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
    <!-- <div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div> -->
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
                        <h1>About Us</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">About</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- STAT SECTION ABOUT -->
        <div class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about_img scene mb-4 mb-lg-0">
                            <img src="assets/images/logo.png" alt="about_img" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="heading_s1">
                            <h2>Who We Are</h2>
                        </div>
                        <p>Discrounts is your trusted online retailer, dedicated to bringing you a seamless shopping experience. Our vision is to be the ultimate one-stop shop for a wide range of products, ensuring quality and satisfaction in every purchase.</p>
                        <p>We offer a diverse selection of groceries, wholesale beverages, sports equipment, and pharmacy products. Our goal is to make your shopping journey easy and enjoyable, providing authentic items directly to your doorstep.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION ABOUT -->

        <!-- START SECTION WHY CHOOSE -->
        <div class="section bg_light_blue2 pb_70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="heading_s1 text-center">
                            <h2>Why Choose Us?</h2>
                        </div>
                        <p class="text-center leads">At Discrounts, we prioritize your satisfaction and convenience. Here’s why we stand out:</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6">
                        <div class="icon_box icon_box_style4 box_shadow1">
                            <div class="icon">
                                <i class="ti-star"></i>
                            </div>
                            <div class="icon_box_content">
                                <h5>Quality Products</h5>
                                <p>We offer a curated selection of high-quality items, ensuring that you receive only the best.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="icon_box icon_box_style4 box_shadow1">
                            <div class="icon">
                                <i class="ti-shield"></i>
                            </div>
                            <div class="icon_box_content">
                                <h5>Secure Shopping</h5>
                                <p>Shop with confidence knowing that your personal information and transactions are secure.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="icon_box icon_box_style4 box_shadow1">
                            <div class="icon">
                                <i class="ti-face-smile"></i>
                            </div>
                            <div class="icon_box_content">
                                <h5>Excellent Customer Service</h5>
                                <p>Our dedicated team is here to assist you with any inquiries or issues you may have.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION WHY CHOOSE -->

        <!-- START SECTION TESTIMONIAL -->
        <div class="section" style="background-color: rgba(39,137,22,0.2);">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="heading_s1 text-center">
                            <h2>Our Clients Say!</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="testimonial_wrap testimonial_style1 carousel_slider owl-carousel owl-theme nav_style2" data-nav="true" data-dots="false" data-center="true" data-loop="true" data-autoplay="true" data-items='1'>
                            <div class="testimonial_box">
                                <div class="testimonial_desc">
                                    <p>Discrounts made my shopping experience so easy and enjoyable. The quality of their products is outstanding and the delivery was fast!</p>
                                </div>
                                <div class="author_wrap">
                                    <div class="author_img">
                                        <img src="assets/images/user.png" alt="user_img1" />
                                    </div>
                                    <div class="author_name">
                                        <h6>Lissa Castro</h6>
                                        <span>Designer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial_box">
                                <div class="testimonial_desc">
                                    <p>I appreciate the secure shopping experience at Discrounts. Their customer service team was very helpful with my inquiries.</p>
                                </div>
                                <div class="author_wrap">
                                    <div class="author_img">
                                        <img src="assets/images/user.png" alt="user_img2" />
                                    </div>
                                    <div class="author_name">
                                        <h6>Alden Smith</h6>
                                        <span>Designer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial_box">
                                <div class="testimonial_desc">
                                    <p>Discrounts has a fantastic range of products. I found everything I needed and more. The prices are great too!</p>
                                </div>
                                <div class="author_wrap">
                                    <div class="author_img">
                                        <img src="assets/images/user.png" alt="user_img3" />
                                    </div>
                                    <div class="author_name">
                                        <h6>Daisy Lana</h6>
                                        <span>Designer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial_box">
                                <div class="testimonial_desc">
                                    <p>Shopping at Discrounts was a breeze. Their website is user-friendly, and the delivery was prompt. Highly recommend!</p>
                                </div>
                                <div class="author_wrap">
                                    <div class="author_img">
                                        <img src="assets/images/user.png" alt="user_img4" />
                                    </div>
                                    <div class="author_name">
                                        <h6>John Becker</h6>
                                        <span>Designer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION TESTIMONIAL -->

        <!-- START SECTION SHOP INFO -->
        <div class="section pb_70">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-4">
                        <div class="icon_box icon_box_style1">
                            <div class="icon">
                                <i class="flaticon-shipped"></i>
                            </div>
                            <div class="icon_box_content">
                                <h5>Fast Delivery</h5>
                                <p>We ensure that your orders are delivered promptly, so you can enjoy your purchases without delay.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="icon_box icon_box_style1">
                            <div class="icon">
                                <i class="flaticon-money-back"></i>
                            </div>
                            <div class="icon_box_content">
                                <h5>30 Day Return</h5>
                                <p>Shop with peace of mind, knowing that you can return any item within 30 days if you're not satisfied.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="icon_box icon_box_style1">
                            <div class="icon">
                                <i class="flaticon-support"></i>
                            </div>
                            <div class="icon_box_content">
                                <h5>24/7 Support</h5>
                                <p>Our support team is available around the clock to assist you with any questions or concerns.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP INFO -->

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