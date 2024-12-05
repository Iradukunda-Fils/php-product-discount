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
        <title>Checkout - Discrounts</title>
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
                        <h1>Checkout</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
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

                <?php require("configs/scripts.php"); ?>

<!--                <div class="row">-->
<!--                    <div class="col-lg-6">-->
<!--                        <div class="toggle_info">-->
<!--                            <span><i class="fas fa-user"></i>Returning customer? <a href="#loginform" data-toggle="collapse" class="collapsed" aria-expanded="false">Click here to login</a></span>-->
<!--                        </div>-->
<!--                        <div class="panel-collapse collapse login_form" id="loginform">-->
<!--                            <div class="panel-body">-->
<!--                                <p>If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p>-->
<!--                                <form method="post">-->
<!--                                    <div class="form-group">-->
<!--                                        <input type="text" required="" class="form-control" name="email" placeholder="Username Or Email">-->
<!--                                    </div>-->
<!--                                    <div class="form-group">-->
<!--                                        <input class="form-control" required="" type="password" name="password" placeholder="Password">-->
<!--                                    </div>-->
<!--                                    <div class="login_footer form-group">-->
<!--                                        <div class="chek-form">-->
<!--                                            <div class="custome-checkbox">-->
<!--                                                <input class="form-check-input" type="checkbox" name="checkbox" id="remember" value="">-->
<!--                                                <label class="form-check-label" for="remember"><span>Remember me</span></label>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <a href="#">Forgot password?</a>-->
<!--                                    </div>-->
<!--                                    <div class="form-group">-->
<!--                                        <button type="submit" class="btn btn-fill-out btn-block" name="login">Log in</button>-->
<!--                                    </div>-->
<!--                                </form>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-lg-6">-->
<!--                        <div class="toggle_info">-->
<!--                            <span><i class="fas fa-tag"></i>Have a coupon? <a href="#coupon" data-toggle="collapse" class="collapsed" aria-expanded="false">Click here to enter your code</a></span>-->
<!--                        </div>-->
<!--                        <div class="panel-collapse collapse coupon_form" id="coupon">-->
<!--                            <div class="panel-body">-->
<!--                                <p>If you have a coupon code, please apply it below.</p>-->
<!--                                <div class="coupon field_form input-group">-->
<!--                                    <input type="text" value="" class="form-control" placeholder="Enter Coupon Code..">-->
<!--                                    <div class="input-group-append">-->
<!--                                        <button class="btn btn-fill-out btn-sm" type="submit">Apply Coupon</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col-12">-->
<!--                        <div class="medium_divider"></div>-->
<!--                        <div class="divider center_icon"><i class="linearicons-credit-card"></i></div>-->
<!--                        <div class="medium_divider"></div>-->
<!--                    </div>-->
<!--                </div>-->

                <form action="" method="POST">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="order_review">
                                <div class="heading_s1">
                                    <h4>Your Orders</h4>
                                </div>
                                <div class="table-responsive order_table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cartTotal = 0;
                                            $query = mysqli_query($connection, "SELECT * FROM carts, products WHERE carts.product_id = products.product_id AND  session_id ='$sessionId' ORDER BY cart_id DESC") or die(mysqli_error($connection));
                                            while ($data = mysqli_fetch_assoc($query)) {
                                            ?>
                                                <tr>
                                                    <td><?php print $data["product_name"]; ?> <span class="product-qty">x <?php print $data["cart_qty"]; ?></span></td>
                                                    <td>RWF <?php print number_format($data["product_price"]); ?></td>
                                                </tr>
                                            <?php
                                                $cartTotal = $cartTotal + $data["cart_total"];
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>SubTotal</th>
                                                <td class="product-subtotal">RWF <?php print number_format($cartTotal); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td>Free Shipping</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td class="product-subtotal">RWF <?php print number_format($cartTotal); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="payment_method">
                                    <div class="heading_s1">
                                        <h4>Payment</h4>
                                    </div>
                                    <div class="payment_option">

                                        <?php
                                        if ($cartTotal > 2000000) {
                                            $query = mysqli_query($connection, "SELECT * FROM payment_methods WHERE payment_method_id !=1 ORDER BY payment_method_id DESC ");
                                        } else {

                                            $query = mysqli_query($connection, "SELECT * FROM payment_methods ORDER BY payment_method_id DESC ");
                                        }

                                        while ($paymentMethod = mysqli_fetch_assoc($query)) {

                                        ?>
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio" name="payment_method_id" id="exampleRadios<?php print $paymentMethod["payment_method_id"]; ?>" value="<?php print $paymentMethod["payment_method_id"]; ?>" checked>
                                                <label class="form-check-label" for="exampleRadios<?php print $paymentMethod["payment_method_id"]; ?>"><?php print $paymentMethod["payment_method_name"]; ?></label>
                                                <p data-method="option<?php print $paymentMethod["payment_method_id"]; ?>" class="payment-text"><?php print $paymentMethod["payment_method_info"]; ?> </p>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <button type="submit" name="placeOrder" class="btn btn-fill-out btn-block">Place Order</button>
                            </div>

                        </div>

                    </div>
                </form>

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