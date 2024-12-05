<?php
require("configs/connection.php");
require("configs/test.data.php");
require("configs/session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="Devslab Ltd" name="author">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="keywords" content="">


        <!-- SITE TITLE -->
        <title>Wishlist - Discrounts</title>
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
                        <h1>Wishlist</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">Wishlist</li>
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
                <div class="row">
                    <div class="col-12">

                        <?php

                        if (isset($_GET["product"])) {
                            $productId = TestData($_GET["product"]);

                            #Check if the product is in wishlist

                            $query = mysqli_query($connection, "SELECT * FROM wishlists WHERE session_id ='$sessionId' AND product_id ='$productId'") or die(mysqli_error($connection));
                            $count = mysqli_num_rows($query);

                            if ($count == 1) {
                                $alert  = "success";
                                $msg    = "This product is already in your wishlist!";
                                require "templates/alert.php";
                            } else {

                                mysqli_query($connection, "INSERT INTO `wishlists` (`wishlist_id`, `session_id`, `customer_id`, `product_id`) 
                                VALUES (NULL, '$sessionId', NULL, '$productId')") or die(mysqli_error($connection));

                                $alert  = "success";
                                $msg    = "You have added a product in your wishlist!";
                                require "templates/alert.php";
                            }
                        }

                        # DELETE PRODUCT IN WIHLIST

                        if (isset($_GET["deleteWishlist"])) {
                            $productId = TestData($_GET["deleteWishlist"]);
                            $query = mysqli_query($connection, "DELETE FROM wishlists WHERE product_id ='$productId'");

                            $alert  = "success";
                            $msg    = "You have deleted a product from your wishlist!";
                            require "templates/alert.php";
                        }

                        ?>
                        <div class="table-responsive wishlist_table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-stock-status">Stock Status</th>
                                        <th class="product-add-to-cart"></th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query = mysqli_query($connection, "SELECT * FROM wishlists, products WHERE wishlists.product_id = products.product_id AND  session_id ='$sessionId' ORDER BY wishlist_id DESC") or die(mysqli_error($connection));
                                    while ($data = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="<?php print $data["product_image"]; ?>" alt="product1"></a></td>
                                            <td class="product-name" data-title="Product"><a href="#"><?php print $data["product_name"]; ?></a></td>
                                            <td class="product-price" data-title="Price">RWF <?php print number_format($data["product_price"]); ?></td>
                                            <td class="product-stock-status" data-title="Stock Status"><span class="badge badge-pill badge-success">In Stock</span></td>
                                            <td class="product-add-to-cart"><a href="cart?product=<?php print $data["product_id"]; ?>" class="btn btn-fill-out"><i class="icon-basket-loaded"></i> Add to Cart</a></td>
                                            <td class="product-remove" data-title="Remove"><a href="?deleteWishlist=<?php print $data["product_id"]; ?>"><i class="ti-close"></i></a></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->

    </div>
    <!-- END MAIN CONTENT -->

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