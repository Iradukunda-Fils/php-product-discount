<?php require("configs/globals.php");

if (isset($_GET["id"])) {
    $productId = $_GET["id"];
    $query = mysqli_query($connection, "SELECT * FROM products WHERE product_id ='$productId'");
    $product = mysqli_fetch_assoc($query);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php print $product["product_name"]; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components/custom-media_object.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL CUSTOM STYLES -->
</head>

<body class="sidebar-noneoverflow">
    <!--  BEGIN NAVBAR  -->
    <?php require("templates/navBar.php"); ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>


        <!--  BEGIN SIDEBAR  -->
        <?php require("templates/sideBar.php");  ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="container">
                <div class="container">

                    <div id="navSection" data-spy="affix" class="nav  sidenav">
                        <div class="sidenav-content">
                            <a href="#product_info" class="active nav-link">Info</a>
                            <a href="#product_images" class="nav-link">Images</a>
                            <a href="#mediaObjectAlignment" class="nav-link">Options</a>
                        </div>
                    </div>

                    <div class="row layout-top-spacing">
                        <div id="product_info" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Product Details</h4>
                                            <a href="?addImage&id=<?php print $product["product_id"]; ?>" class="btn btn-outline-info btn-rounded float-right mt-n4 mr-4"><i data-feather="edit-3"></i></a>

                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">

                                    <div class="media">
                                        <img class="rounded" src="https://Discrounts.com/<?php print $product["product_image"]; ?>" alt="pic1">
                                        <div class="media-body">
                                            <h4 class="media-heading"><?php print $product["product_name"]; ?></h4>
                                            <p class="media-text"><?php print $product["product_description"]; ?>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <?php if (isset($_GET["addImage"])) { ?>
                            <div id="product_images" class="col-lg-12 col-md-12 layout-spacing">
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>Add image</h4>

                                                <?php require("scripts/main.php"); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content widget-content-area">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="row">

                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <input type="file" name="productImage" class="form-control" required>
                                                        <input type="hidden" name="productId" value="<?php print $productId; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <button class="btn  btn-outline-primary btn-rounded  mt-1 " type="submit" name="addProductImage"><i data-feather="upload"></i></button>
                                                </div>

                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        <div id="product_images" class="col-lg-12 col-md-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Images</h4>

                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a href="?addImage&id=<?php print $product["product_id"]; ?>" class="btn btn-outline-info btn-sm btn-rounded float-right mt-n5 mr-2"><i data-feather="plus-circle"></i></a>

                                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active m"></li>
                                                    <?php $query = mysqli_query($connection, "SELECT * FROM product_images WHERE product_id ='$productId'");
                                                    while ($image = mysqli_fetch_assoc($query)) { ?>
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                                    <?php } ?>
                                                </ol>
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="d-block w-100" src="https://Discrounts.com/<?php print $product["product_image"]; ?>" alt="F">
                                                    </div>

                                                    <?php $query = mysqli_query($connection, "SELECT * FROM product_images WHERE product_id ='$productId'");
                                                    while ($image = mysqli_fetch_assoc($query)) { ?>
                                                        <div class="carousel-item">
                                                            <img class="d-block w-100" src="assets/img/1.jpg" alt="Second slide">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require("templates/footer.php"); ?>

            <!--  END CONTENT AREA  -->

        </div>
        <!-- END MAIN CONTAINER -->
        <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
        <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
        <script src="bootstrap/js/popper.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="plugins/blockui/jquery.blockUI.min.js"></script>
        <script src="assets/js/app.js"></script>

        <script>
            $(document).ready(function() {
                $(".catalog").addClass("active");
                $(".products").addClass("active");
                $("#catalog").addClass("show");
                App.init();
            });
        </script>
        <script src="plugins/highlight/highlight.pack.js"></script>
        <script src="assets/js/custom.js"></script>
        <!-- END GLOBAL MANDATORY SCRIPTS -->
        <script src="assets/js/scrollspyNav.js"></script>
</body>

</html>