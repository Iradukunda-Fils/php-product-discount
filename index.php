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
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- SITE TITLE -->
    <title>Welcome to Discrounts</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap"
          rel="stylesheet">
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
    <link rel="stylesheet" href="assets/css/custom.css">

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

<!-- Home Popup Section -->
<?php //require("templates/popup.php")
?>
<!-- End Screen Load Popup Section -->

<!-- START HEADER -->
<?php require("templates/header.php") ?>
<!-- END HEADER -->
<!-- START SECTION BANNER -->
<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            require("configs/connection.php");
            $count = 0;

            $query = mysqli_query($connection, "SELECT * FROM slides ORDER BY rand() ") or die(mysqli_error($connection));
            while ($data = mysqli_fetch_assoc($query)) {

                $count ++;
                ?>
                <div class="carousel-item background_bg <?php if( $count==1){ print"active"; } ?>" data-img-src="<?php print $data["slide_url"]; ?>">
                    <div class="banner_slide_content banner_content_inner">
<!--                        <div class="container">-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-8 col-10">-->
<!--                                    <div class="banner_content overflow-hidden">-->
<!--                                        <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="0.5s">Beat Headphone</h2>-->
<!--                                        <h5 class="mb-3 mb-sm-4 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="1s">Taking your Viewing Experience to Next Level</h5>-->
<!--                                        <a class="btn btn-fill-out staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>

            <?php } ?>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"><i
                    class="ion-chevron-left"></i></a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"><i
                    class="ion-chevron-right"></i></a>
    </div>
</div>
<!-- END SECTION BANNER -->


<!-- START SECTION CATEGORIES -->
<div class="section small_pb small_pt">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Top Categories</h2>
                </div>
                <p class="text-center leads">Discover top categories: groceries, beverages, sports gear, and pharmacy
                    essentials. Everything you need in one place!</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-8 offset-2">
                <div class="cat_slider cat_style1 mt-4 mt-md-0 carousel_slider owl-carousel owl-theme nav_style5"
                     data-loop="true" data-dots="false" data-nav="true" data-margin="30"
                     data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "576":{"items": "5"}, "768":{"items": "5"}, "991":{"items": "5"}, "1199":{"items": "5"}}'>

                    <?php require("configs/connection.php");
                    $query = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id =0 AND category_status !='deactivated' ");
                    while ($cart = mysqli_fetch_assoc($query)) { ?>
                        <div class="item" style="background-color: #ffffff;">
                            <div class="categories_box">
                                <a href="category?path=<?php print $cart["category_id"]; ?>">
                                    <img src="<?php print $cart["category_image"]; ?>" alt=""
                                         style="padding: 30px; padding-bottom: 10px"/>
                                    <span><?php print $cart["category_name"]; ?></span>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION CATEGORIES -->

<!-- START SECTION SHOP -->
<div class="section small_pt pb_20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s3 text-center">
                    <h2>New Arrivals</h2>
                </div>
                <div class="small_divider clearfix"></div>
            </div>
        </div>
        <div class="row shop_container">

            <?php
            require("configs/connection.php");
            $query = mysqli_query($connection, "SELECT * FROM products WHERE store_id ='$storeId' AND product_status='In stock' ORDER BY product_id DESC LIMIT 12") or die(mysqli_error($connection));
            while ($data = mysqli_fetch_assoc($query)) { ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product_box text-center">
                        <div class="product_img">
                            <a href="product?detail=<?php print  $data["product_sku"]; ?>">
                                <img src="<?php print $data["product_image"]; ?>" alt="furniture_img8">
                            </a>
                            <div class="product_action_box">
                                <ul class="list_none pr_action_btn">
                                    <li><a href="product?detail=<?php print  $data["product_sku"]; ?>"><i
                                                    class="icon-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product_info">
                            <h6 class="product_title"><a
                                        href="product?detail=<?php print  $data["product_sku"]; ?>"><?php print $data["product_name"]; ?></a>
                            </h6>
                            <div class="product_price">
                                <span class="price"><?php print $currency; ?>  <?php print number_format($data["product_price"]); ?></span>
                                <del></del>
                                <div class="on_sale">
                                    <span> </span>
                                </div>
                            </div>
                            <div class="rating_wrap">
                                <div class="rating">
                                    <div class="product_rate" style="width:70%"></div>
                                </div>

                            </div>
                            <div class="pr_desc">
                                <p></p>
                            </div>
                            <div class="add-to-cart">
                                <a href="cart?product=<?php print $data["product_id"]; ?>"
                                   class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->
<!-- START SECTION SHOP -->
<div class="section small_pt pb_20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s3 text-center">
                    <h2> Best Sellers</h2>
                </div>
                <div class="small_divider clearfix"></div>
            </div>
        </div>
        <div class="row shop_container">

            <?php
            require("configs/connection.php");
            $query = mysqli_query($connection, "SELECT * FROM products WHERE store_id ='$storeId' AND product_status='In stock'ORDER BY  rand() LIMIT 12") or die(mysqli_error($connection));
            while ($data = mysqli_fetch_assoc($query)) { ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product_box text-center">
                        <div class="product_img">
                            <a href="product?detail=<?php print  $data["product_sku"]; ?>">
                                <img src="<?php print $data["product_image"]; ?>" alt="furniture_img8">
                            </a>
                            <div class="product_action_box">
                                <ul class="list_none pr_action_btn">
                                    <li><a href="product?detail=<?php print  $data["product_sku"]; ?>"><i
                                                    class="icon-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product_info">
                            <h6 class="product_title"><a
                                        href="product?detail=<?php print  $data["product_sku"]; ?>"><?php print $data["product_name"]; ?></a>
                            </h6>
                            <div class="product_price">
                                <span class="price"><?php print $currency; ?>  <?php print number_format($data["product_price"]); ?></span>
                                <del></del>
                                <div class="on_sale">
                                    <span> </span>
                                </div>
                            </div>
                            <div class="rating_wrap">
                                <div class="rating">
                                    <div class="product_rate" style="width:70%"></div>
                                </div>
                                <span class="rating_num">( <?php print number_format($data["product_views"]); ?>)</span>
                            </div>
                            <div class="pr_desc">
                                <p></p>
                            </div>
                            <div class="add-to-cart">
                                <a href="cart?product=<?php print $data["product_id"]; ?>"
                                   class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

<!-- START SECTION SHOP -->
<div class="section small_pt pb_20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s3 text-center">
                    <h2> Specials</h2>
                </div>
                <div class="small_divider clearfix"></div>
            </div>
        </div>
        <div class="row shop_container">

            <?php
            require("configs/connection.php");
            $query = mysqli_query($connection, "SELECT * FROM products WHERE store_id ='$storeId' AND product_status='In stock'ORDER BY rand() DESC LIMIT 12") or die(mysqli_error($connection));
            while ($data = mysqli_fetch_assoc($query)) { ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product_box text-center">
                        <div class="product_img">
                            <a href="product?detail=<?php print  $data["product_sku"]; ?>">
                                <img src="<?php print $data["product_image"]; ?>" alt="furniture_img8">
                            </a>
                            <div class="product_action_box">
                                <ul class="list_none pr_action_btn">
                                    <li><a href="product?detail=<?php print  $data["product_sku"]; ?>"><i
                                                    class="icon-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product_info">
                            <h6 class="product_title"><a
                                        href="product?detail=<?php print  $data["product_sku"]; ?>"><?php print $data["product_name"]; ?></a>
                            </h6>
                            <div class="product_price">
                                <span class="price"><?php print $currency; ?> <?php print number_format($data["product_price"]); ?></span>
                                <del></del>
                                <div class="on_sale">
                                    <span> </span>
                                </div>
                            </div>
                            <div class="rating_wrap">
                                <div class="rating">
                                    <div class="product_rate" style="width:70%"></div>
                                </div>
                                <span class="rating_num">( <?php print number_format($data["product_views"]); ?>)</span>
                            </div>
                            <div class="pr_desc">
                                <p></p>
                            </div>
                            <div class="add-to-cart">
                                <a href="cart?product=<?php print $data["product_id"]; ?>"
                                   class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->


<!-- START FOOTER -->
<?php require("templates/footer.php"); ?>
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