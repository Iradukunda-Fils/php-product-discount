<!-- START HEADER -->
<header class="header_wrap fixed-top">
    <div class="top-header light_skin bg_dark d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="header_topbar_info">
                        <div class="header_offer">
                            <span>Free Delivery Over 250,000 RWF at your doorstep</span>
                        </div>
                        <div class="download_wrap">
                            <span class="mr-3">Download App</span>
                            <ul class="icon_list text-center text-lg-left">
                                <li><a href="#"><i class="fab fa-apple"></i></a></li>
                                <li><a href="#"><i class="fab fa-android"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="lng_dropdown">
                            <select name="countries" class="custome_select">
                                <option value='RW' data-image="assets/images/rwanda.png" data-title="Rwanda">Rwanda</option>
                                <option value='Zambia' data-image="assets/images/zambia.png" data-title="Zambia">Zambia</option>
                            </select>
                        </div>
                        <div class="ml-3">
                            <select name="countries" class="custome_select">
                                <option value='USD' data-title="RWF">RWF</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="middle-header dark_skin">
        <div class="container">
            <div class="nav_block">
                <a class="navbar-brand" href="./">
                    <img class="logo_light" src="assets/images/logo.png" alt="logo"/>
                    <img class="logo_dark" src="assets/images/logo.png" alt="logo"/>
                </a>
                <div class="product_search_form rounded_input">
                    <form action="search">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="custom_select">

                                    <select class="first_null" name="category">


                                        <option value="">All Categories</option>
                                        <?php require("configs/connection.php");
                                        $query = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id =0 AND category_status !='deactivated' ");
                                        while ($cart = mysqli_fetch_assoc($query)) { ?>

                                            <option value="<?php print $cart["category_id"]; ?>"><?php print $cart["category_name"]; ?></option>

                                            <?php

                                            $parentId = $cart["category_id"];

                                            $subQuery = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id ='$parentId' AND category_status !='deactivated'") or die(mysqli_error($connection));
                                            while ($subCat = mysqli_fetch_assoc($subQuery)) {
                                                ?>

                                                <option value="<?php print $subCat["category_id"]; ?>"> &nbsp;&nbsp;&nbsp;<?php print $subCat["category_name"]; ?></option>

                                            <?php }
                                        } ?>

                                    </select>
                                </div>
                            </div>
                            <input class="form-control" placeholder="Search Product..." required="" name="q"
                                   type="text">
                            <button type="submit" class="search_btn2"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    <li><a href="myaccount" class="nav-link"><i class="linearicons-user"></i></a></li>
                    <!--                    <li><a href="wishlist" class="nav-link"><i class="linearicons-heart"></i><span-->
                    <!--                                    class="wishlist_count">-->
                    <!--                                --><?php
                    //                                $query = mysqli_query($connection, "SELECT * FROM wishlists WHERE session_id ='$sessionId'") or die(mysqli_error($connection));
                    //                                $count = mysqli_num_rows($query);
                    //                                print $count;
                    //                                ?>
                    <!--                            </span></a></li>-->
                    <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="cart"
                                                          data-toggle="dropdown"><i class="linearicons-bag2"></i><span
                                    class="cart_count"><?php
                                $query = mysqli_query($connection, "SELECT * FROM carts WHERE session_id ='$sessionId'");
                                print $count = mysqli_num_rows($query);
                                ?>
                            </span><span class="amount"><span class="currency_symbol">RWF</span>
                                <?php
                                $sum = 0;
                                $query = mysqli_query($connection, "SELECT * FROM carts WHERE   session_id ='$sessionId' ORDER BY cart_id DESC") or die(mysqli_error($connection));
                                while ($cart = mysqli_fetch_assoc($query)) {
                                    $sum = $sum + $cart["cart_total"];
                                }

                                print number_format($sum);
                                ?>
                            </span></a>
                        <div class="cart_box cart_right dropdown-menu dropdown-menu-right">
                            <ul class="cart_list">
                                <?php
                                $cartTotal = 0;
                                $query = mysqli_query($connection, "SELECT * FROM carts, products WHERE carts.product_id = products.product_id AND  session_id ='$sessionId' ORDER BY cart_id DESC") or die(mysqli_error($connection));
                                while ($cart = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <li>
                                        <a href="cart?deleteCart=<?php print $cart["product_id"]; ?>"
                                           class="item_remove"><i class="ion-close"></i></a>
                                        <a href="#"><img src="<?php print $cart["product_image"]; ?>"
                                                         alt="cart_thumb1"><?php print $cart["product_name"]; ?></a>
                                        <span class="cart_quantity"> <?php print $cart["cart_qty"]; ?> x <span
                                                    class="cart_amount"> <span
                                                        class="price_symbole">RWF </span></span> <?php print number_format($cart["product_price"]); ?></span>
                                    </li>
                                    <?php
                                    $cartTotal = $cartTotal + $cart["cart_total"];
                                }
                                ?>

                            </ul>
                            <div class="cart_footer">
                                <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"> <span
                                                class="price_symbole">RWF </span></span><?php print number_format($cartTotal); ?>
                                </p>
                                <p class="cart_buttons"><a href="cart" class="btn btn-fill-line view-cart">View Cart</a><a
                                            href="checkout" class="btn btn-fill-out checkout">Checkout</a></p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-6 col-3">
                    <div class="categories_wrap">
                        <button type="button" data-toggle="collapse" data-target="#navCatContent" aria-expanded="false"
                                class="categories_btn categories_menu">
                            <span>All Categories </span><i class="linearicons-menu"></i>
                        </button>
                        <div id="navCatContent" class="navbar collapse">
                            <ul>
                                <?php require("configs/connection.php");
                                $count = 0;
                                $query = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id =0 ORDER BY category_name ");
                                while ($cart = mysqli_fetch_assoc($query)) {
                                $count++;

                                if ($count < 10) {
                                    ?>
                                    <li><a class="dropdown-item nav-link nav_item" href="category?path=<?php print $cart["category_id"]; ?>">
                                            <img src="<?php print $cart["category_image"]; ?> " style="width: 30px; height: 30px"> <span><?php print $cart["category_name"]; ?></span></a></li>
                                <?php }

                                }?>
                                <li>
<!--                                    <ul class="more_slide_open">-->
<!--                                        <li><a class="dropdown-item nav-link nav_item" href="login.html"><i-->
<!--                                                        class="flaticon-fax"></i> <span>Fax Machine</span></a></li>-->
<!--                                        <li><a class="dropdown-item nav-link nav_item" href="register.html"><i-->
<!--                                                        class="flaticon-mouse"></i> <span>Mouse</span></a></li>-->
<!--                                    </ul>-->
                                </li>
                            </ul>
                            <div class="more_categories">More Categories</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-6 col-9">
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler side_navbar_toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSidetoggle" aria-expanded="false">
                            <span class="ion-android-menu"></span>
                        </button>
                        <div class="pr_search_icon">
                            <a href="javascript:void(0);" class="nav-link pr_search_trigger"><i
                                        class="linearicons-magnifier"></i></a>
                        </div>
                        <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                            <ul class="navbar-nav">
                                <li class="dropdown">
                                    <a class="nav-link  active" href="./">Home</a>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle nav-link" href="category?path=207" data-toggle="dropdown">Wholesale</a>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <?php
                                            $subQuery = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id ='207' AND category_status !='deactivated'") or die(mysqli_error($connection));
                                            while ($subCat = mysqli_fetch_assoc($subQuery)) {
                                            ?>
                                            <li><a class="dropdown-item nav-link nav_item" href="category?path=<?php print $subCat["category_id"]; ?>"> <?php print $subCat["category_name"]; ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>

                                <li class="dropdown">
                                    <a class="dropdown-toggle nav-link" href="category?path=211" data-toggle="dropdown">Groceries</a>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <?php
                                            $subQuery = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id ='211' AND category_status !='deactivated'") or die(mysqli_error($connection));
                                            while ($subCat = mysqli_fetch_assoc($subQuery)) {
                                                ?>
                                                <li><a class="dropdown-item nav-link nav_item" href="category?path=<?php print $subCat["category_id"]; ?>"> <?php print $subCat["category_name"]; ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>

                                <li class="dropdown">
                                    <a class="dropdown-toggle nav-link" href="category?path=217" data-toggle="dropdown">Beverages</a>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <?php
                                            $subQuery = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id ='217' AND category_status !='deactivated'") or die(mysqli_error($connection));
                                            while ($subCat = mysqli_fetch_assoc($subQuery)) {
                                                ?>
                                                <li><a class="dropdown-item nav-link nav_item" href="category?path=<?php print $subCat["category_id"]; ?>"> <?php print $subCat["category_name"]; ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                                <li><a class="nav-link nav_item" href="about">About Us</a></li>

                                <li><a class="nav-link nav_item" href="contact">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="contact_phone contact_support">
                            <i class="linearicons-phone-wave"></i>
                            <span>+250 782 230 807</span>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END HEADER -->