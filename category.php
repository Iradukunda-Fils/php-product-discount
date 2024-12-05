<?php if (isset($_GET["path"])) {

    require("configs/connection.php");
    require("configs/test.data.php");
    require("configs/session.php");

    $categoryId = TestData($_GET["path"]);
    $query = mysqli_query($connection, "SELECT * FROM categories WHERE category_id ='$categoryId'") or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);
    $categoryName = $data["category_name"];

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
        <title><?php print $data["category_name"]; ?> - Discrounts</title>
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
        <!-- jquery-ui CSS -->
        <link rel="stylesheet" href="assets/css/jquery-ui.css">
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
<!--        <div class="preloader">-->
<!--            <div class="lds-ellipsis">-->
<!--                <span></span>-->
<!--                <span></span>-->
<!--                <span></span>-->
<!--            </div>-->
<!--        </div>-->
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
                            <h1><?php print $data["category_name"]; ?></h1>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Categories</a></li>
                            <li class="breadcrumb-item active"><?php print $categoryName; ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->

        <!-- START MAIN CONTENT -->
        <div class="main_content">

            <!-- START SECTION SHOP -->
            <div class="section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div style="margin-top: -70px !important;" class="cat_slider cat_style1 mt-0 mb-4 mt-md-0 carousel_slider owl-carousel owl-theme nav_style5"
                                 data-loop="false" data-dots="false" data-nav="true" data-margin="30"
                                 data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "576":{"items": "8"}, "768":{"items": "8"}, "991":{"items": "8"}, "1199":{"items": "8"}}'>

                                <?php require("configs/connection.php");
                                $query = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id ='$categoryId' AND category_status !='deactivated' ");

                                while ($cart = mysqli_fetch_assoc($query)) { ?>
                                    <div class="item" style="background-color: #ffffff;">
                                        <div class="categories_box">
                                            <a href="category?path=<?php print $cart["category_id"]; ?>">
                                                <img src="<?php print $cart["category_image"]; ?>" alt=""
                                                     style="padding: 30px; padding-bottom: 00px"/>
                                                <span class="p-2"><?php print $cart["category_name"]; ?></span>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row align-items-center mb-4 pb-1">
                                <div class="col-12">
                                    <div class="product_header">
                                        <div class="product_header_left">
                                            <div class="custom_select">
                                                <select class="form-control form-control-sm">
                                                    <option value="order">Default sorting</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="product_header_right">
                                            <div class="products_view">
                                                <a href="javascript:Void(0);" class="shorting_icon grid active"><i class="ti-view-grid"></i></a>
                                                <a href="javascript:Void(0);" class="shorting_icon list"><i class="ti-layout-list-thumb"></i></a>
                                            </div>
                                            <div class="custom_select">
                                                <select class="form-control form-control-sm">
                                                    <option value="">Showing</option>
                                                    <option value="9">9</option>
                                                    <option value="12">12</option>
                                                    <option value="18">18</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row shop_container">
                                <?php
                                require("configs/connection.php");
                                $query = mysqli_query($connection, "SELECT * FROM products, products_categories WHERE products.product_id = products_categories.product_id AND products_categories.category_id ='$categoryId' AND store_id ='$storeId' AND product_status='In stock' ORDER BY rand() LIMIT 24") or die(mysqli_error($connection));
                                if(isset($_GET["q"])){
                                    $q = $_GET["q"];
                                    $query = mysqli_query($connection, "SELECT * FROM products, products_categories WHERE products.product_id = products_categories.product_id AND store_id ='$storeId' AND products.product_name LIKE '%$q%' AND product_status='In stock'ORDER BY rand() LIMIT 24") or die(mysqli_error($connection));
                                }
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
                            <div class="row">
                                <div class="col-12">
<!--                                    <ul class="pagination mt-3 justify-content-center pagination_style1">-->
<!--                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>-->
<!--                                        <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--                                        <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--                                        <li class="page-item"><a class="page-link" href="#"><i class="linearicons-arrow-right"></i></a></li>-->
<!--                                    </ul>-->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END SECTION SHOP -->

            <!-- START FOOTER -->
            <?php require('templates/footer.php'); ?>
            <!-- END FOOTER -->



            <!-- Latest jQuery -->
            <script src="assets/js/jquery-1.12.4.min.js"></script>
            <!-- jquery-ui -->
            <script src="assets/js/jquery-ui.js"></script>
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
<?php } ?>