<?php if (isset($_GET["detail"])) {

    require("configs/connection.php");
    require("configs/test.data.php");
    require("configs/session.php");

    $sku = TestData($_GET["detail"]);
    $query = mysqli_query($connection, "SELECT * FROM products WHERE product_sku ='$sku'") or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);
    $productId = $data["product_id"];

    $productViews = $data["product_views"] + 1;

    mysqli_query($connection, "UPDATE products SET product_views = '$productViews' WHERE product_id ='$productId'") or die(mysqli_error($connection));

    
?>

<!-- -------------------------------------------------------Discount on product------------------------------------------------ -->
<?php
// Function to calculate the discount percentage on a product

function calculateDiscountPercentage($current_price, $discount_amount) {
    // Validate the current price and discount amount
    if ($current_price <= 0) {
        throw new InvalidArgumentException("Current price must be greater than zero.");
    }

    if ($discount_amount < 0) {
        throw new InvalidArgumentException("Discount amount cannot be negative.");
    }

    // Calculate the discount percentage
    $discount_percentage = ($discount_amount / $current_price) * 100;

    // Prepare the message
    $message =  round($discount_percentage, 2) . "%";

    return $message;
}




?>

<!-- ------------------------------------------------------------End Discount Section----------------------------------------- -->


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
        <title><?php print $data["product_name"]; ?> - Discrounts</title>
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
                            <h1><?php print $data["product_name"]; ?></h1>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
                            <li class="breadcrumb-item active">Product Detail</li>
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
                        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                            <div class="product-image">
                                <div class="product_img_box">
                                    <img id="product_img" src='<?php print $data["product_image"]; ?>' data-zoom-image="<?php print $data["product_image"]; ?>" alt="product_img1" />
                                    <a href="#" class="product_img_zoom" title="Zoom">
                                        <span class="linearicons-zoom-in"></span>
                                    </a>
                                </div>
                                <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">

                                    <?php

                                    $query = mysqli_query($connection, "SELECT * FROM product_images WHERE product_id ='$productId'");
                                    $count = mysqli_num_rows($query);
                                    while ($images = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <div class="item">
                                            <a href="#" class="product_gallery_item" data-image="<?php print $images["image_url"]; ?>" data-zoom-image="<?php print $images["image_url"]; ?>">
                                                <img src="<?php print $images["image_url"]; ?>" alt="product_small_img2" />
                                            </a>
                                        </div>
                                    <?php }
                                    if ($count > 0) { ?>

                                        <div class="item">
                                            <a href="#" class="product_gallery_item active" data-image="<?php print $data["product_image"]; ?>" data-zoom-image="<?php print $data["product_image"]; ?>">
                                                <img src="<?php print $data["product_image"]; ?>" alt="product_small_img1" />
                                            </a>
                                        </div>

                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="pr_detail">
                                <div class="product_description">
                                    <h4 class="product_title"><a href="#"><?php print $data["product_name"]; ?></a></h4>
                                    <div class="product_price">

                                    <!-- PRICE DISCOUNT DISPLAY -->

                                    <?php

                                    

                                    if($data['product_discount_price']){
                                        $discount_percentage = calculateDiscountPercentage($data["product_price"], $data['product_discount_price']);
                                        ?>
                                        <span class="price"><?php print $currency; ?>  <?php print number_format($data["product_price"]-$data['product_discount_price']); ?></span>
                                        <del><?php print number_format($data["product_price"]) ?></del>
                                            <div class="on_sale">
                                                <span><?php print $discount_percentage;?> Off</span>
                                            </div>
                                        <?php
                                    }else{
                                        ?>
                                        <span class="price"><?php print $currency; ?>  <?php print number_format($data["product_price"]); ?></span>
                                        <?php
                                    }
                                      ?> 

                                      <!-- END PRICE DISCOUNT DISPLAY -->

                                    </div>
                                    <div class="rating_wrap">
                                    
                                        <div class="rating">
                                            <div class="product_rate" style="width:100%"></div> 
                                        </div>
                                        <span class="rating_num"> <i class="fa fa-eye"></i> <span class="views"><?php print number_format($productViews); ?></span></span>
                                    </div>
                                    <div class="pr_desc">
                                        <p><?php print $data["product_description"]; ?></p>
                                        <br><br><br>
                                    </div>
                                    <div class="product_sort_info">
                                        <ul>
                                            <!-- <li><i class="linearicons-shield-check"></i> 1 Year AL Jazeera Brand Warranty</li> -->
                                            <li><i class="linearicons-sync"></i> 30 Days Return Policy</li>
                                            <li><i class="linearicons-bag-dollar"></i> Fast Shipping available</li>
                                        </ul>
                                    </div>
                                    <!-- <div class="pr_switch_wrap">
                            <span class="switch_lable">Color</span>
                            <div class="product_color_switch">
                                <span class="active" data-color="#87554B"></span>
                                <span data-color="#333333"></span>
                                <span data-color="#DA323F"></span>
                            </div>
                        </div>
                        <div class="pr_switch_wrap">
                            <span class="switch_lable">Size</span>
                            <div class="product_size_switch">
                                <span>xs</span>
                                <span>s</span>
                                <span>m</span>
                                <span>l</span>
                                <span>xl</span>
                            </div>
                        </div> -->
                                </div>
                                <hr />
                                <div class="cart_extra">
                                    <form action="cart" method="get">
                                        <div class="cart-product-quantity">
                                            <div class="quantity">
                                                <input type="hidden" name="product" value="<?php print $data["product_id"]; ?>">
                                                <input type="button" value="-" class="minus">
                                                <input type="text" name="quantity" value="1" title="Qty" class="qty" size="4">
                                                <input type="button" value="+" class="plus">
                                            </div>
                                        </div>
                                        <div class="cart_btn">
                                            <button class="btn btn-fill-out btn-addtocart" type="submit"><i class="icon-basket-loaded"></i> Add to cart</button>
                                            <!-- <a class="add_compare" href="#"><i class="icon-shuffle"></i></a> -->
                                            <a class="add_wishlist" href="#"><i class="icon-heart"></i></a>
                                        </div>
                                    </form>
                                </div>
                                <hr />
                                <ul class="product-meta">
                                    <li>SKU: <a href="#"><?php print $data["product_sku"]; ?></a></li>
                                    <li>Category: <a href="#">
                                            <?php
                                            $categoryQuery = mysqli_query($connection, "SELECT * FROM products_categories, categories WHERE product_id ='$productId' AND categories.category_id = products_categories.category_id");
                                            while ($category = mysqli_fetch_assoc($categoryQuery)) {
                                                print($category["category_name"] . " ");
                                                $categoryId = $category["category_id"];
                                            }
                                            ?>
                                        </a></li>
                                    <!-- <li>Tags: <a href="#" rel="tag">Cloth</a>, <a href="#" rel="tag">printed</a> </li> -->
                                </ul>

                                <div class="product_share">
<!--                                    <span>Share:</span>-->
<!--                                    <ul class="social_icons">-->
<!---->
<!--                                        <li><a href="#"><i class="ion-social-whatsapp"></i></a></li>-->
<!--                                        <li><a href="#"><i class="ion-social-facebook"></i></a></li>-->
<!--                                        <li><a href="#"><i class="ion-social-twitter"></i></a></li>-->
<!--                                        <li><a href="#"><i class="ion-social-youtube-outline"></i></a></li>-->
<!--                                        <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>-->
<!--                                    </ul>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="large_divider clearfix"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="small_divider"></div>
                            <div class="divider"></div>
                            <div class="medium_divider"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="heading_s1">
                                <h3>Related Products</h3>
                            </div>
                            <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>

                                <?php
                                require("configs/connection.php");
                                $query = mysqli_query($connection, "SELECT * FROM products ORDER BY rand() LIMIT 10") or die(mysqli_error($connection));
                                while ($data = mysqli_fetch_assoc($query)) { ?>

                                    <div class="item related_product">
                                        <div class="product">
                                            <div class="product_img">
                                                <a href="product?detail=<?php print  $data["product_sku"]; ?>">
                                                    <img src="<?php print $data["product_image"]; ?>" alt="product_img1">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="cart?product=<?php print $data["product_id"]; ?>"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <!-- <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li> -->
                                                        <!-- <li><a href="#shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li> -->
                                                        <li><a href="wishlist?product=<?php print $data["product_id"]; ?>"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="product?detail=<?php print  $data["product_sku"]; ?>"><?php print $data["product_name"]; ?></a></h6>
                                                <div class="product_price">
                                                    <span class="price"><?php print $currency; ?>  <?php print number_format($data["product_price"]); ?></span>
                                                    <!-- <del>$55.25</del>
                                                    <div class="on_sale">
                                                        <span>35% Off</span>
                                                    </div> -->
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:100%"></div>
                                                    </div>
                                                    <span class="rating_num"> <i class="fa fa-eye"></i> <span class="views"> <?php print number_format($data["product_views"]); ?></span></span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p></p>
                                                </div>
                                                <div class="pr_switch_wrap">
                                                    <div class="product_color_switch">
                                                        <!-- <span class="active" data-color="#87554B"></span>
                                                        <span data-color="#333333"></span>
                                                        <span data-color="#DA323F"></span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

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