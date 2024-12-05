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
        <title>Shopping cart - Discrounts</title>
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
                        <h1>Shopping Cart</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
                        <li class="breadcrumb-item active">Shopping Cart</li>
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


                            if (isset($_GET["quantity"])) {
                                $quantity = $_GET["quantity"];
                            } else {
                                $quantity = 1;
                            }

                            $query = mysqli_query($connection, "SELECT * FROM products WHERE product_id ='$productId'") or die(mysqli_error($connection));
                            $data = mysqli_fetch_assoc($query);


                            $price = $data["product_price"];
                            $total = $price * $quantity;

                            // check if the product is alread in cart

                            $query = mysqli_query($connection, "SELECT * FROM carts WHERE customer_id ='$customerId' AND product_id ='$productId'");
                            $count = mysqli_num_rows($query);
                            $cart = mysqli_fetch_assoc($query);


                            // delete the product from wishlist if it's there 

                            $query = mysqli_query($connection, "DELETE FROM wishlists WHERE product_id ='$productId'");


                            if ($count > 0) {

                                $quantity = $cart["cart_qty"] + $quantity;
                                $total = $price * $quantity;

                                mysqli_query($connection, "UPDATE carts SET cart_total ='$total' , cart_qty ='$quantity' WHERE customer_id ='$customerId' AND product_id ='$productId'");

                                $alert  = "success";
                                $msg    = "You have updated your cart!";
                                require "templates/alert.php";
                            } else {

                                mysqli_query($connection, "INSERT INTO `carts` (`cart_id`, `customer_id`, `product_id`, `cart_qty`, `cart_total`, `cart_time`) 
                            VALUES (NULL, '$customerId','$productId', '$quantity', '$total', current_timestamp())") or die(mysqli_error($connection));

                                $alert  = "success";
                                $msg    = "You have added a product in your cart!";
                                require "templates/alert.php";
                            }
                        }

                        # DELETE PRODUCT IN CART 

                        if (isset($_GET["deleteCart"])) {
                            $productId = TestData($_GET["deleteCart"]);
                            $query = mysqli_query($connection, "DELETE FROM carts WHERE product_id ='$productId'");

                            $alert  = "success";
                            $msg    = "You have deleted a product from your cart!";
                            require "templates/alert.php";
                        }
                        ?>


                        <div class="table-responsive shop_cart_table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cartTotal = 0;
                                    $query = mysqli_query($connection, "SELECT * FROM carts, products WHERE carts.product_id = products.product_id AND  customer_id ='$customerId' ORDER BY cart_id DESC") or die(mysqli_error($connection));
                                    while ($data = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="<?php print $data["product_image"]; ?>" alt="product1"></a></td>
                                            <td class="product-name" data-title="Product"><a href="#"><?php print $data["product_name"]; ?></a></td>
                                            <td class="product-price" data-title="Price"><?php print $currency; ?>  <?php print number_format($data["product_price"]); ?></td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity">
                                                    <input type="button" value="-" class="minus">
                                                    <input type="text" name="quantity" value="<?php print $data["cart_qty"]; ?>" title="Qty" class="qty" size="4">
                                                    <input type="button" value="+" class="plus">
                                                </div>
                                            </td>
                                            <td class="product-subtotal" data-title="Total"><?php print $currency; ?>  <?php print number_format($data["cart_total"]); ?></td>
                                            <td class="product-remove" data-title="Remove"><a href="?deleteCart=<?php print $data["product_id"]; ?>"><i class="ti-close"></i></a></td>
                                        </tr>
                                    <?php
                                        $cartTotal = $cartTotal + $data["cart_total"];
                                    }
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="px-0">
                                            <div class="row no-gutters align-items-center">

                                                <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
<!--                                                    <div class="coupon field_form input-group">-->
<!--                                                        <input type="text" value="" class="form-control form-control-sm" placeholder="Enter Coupon Code..">-->
<!--                                                        <div class="input-group-append">-->
<!--                                                            <button class="btn btn-fill-out btn-sm" type="submit">Apply Coupon</button>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
                                                </div>
                                                <div class="col-lg-8 col-md-6 text-left text-md-right">
                                                    <a href="./" class="btn btn-line-fill btn-sm" type="submit">Continue Shopping</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="medium_divider"></div>
                        <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
                        <div class="medium_divider"></div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="border p-3 p-md-4">
                            <div class="heading_s1 mb-3">
                                <h6>Cart Totals</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="cart_total_label">Cart Subtotal</td>
                                            <td class="cart_total_amount"><?php print $currency; ?>  <?php print number_format($cartTotal); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">Shipping</td>
                                            <td class="cart_total_amount">Free Shipping</td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">Total</td>
                                            <td class="cart_total_amount"><strong><?php print $currency; ?>  <?php print number_format($cartTotal); ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="checkout" class="btn btn-fill-out">Proceed To CheckOut</a>
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