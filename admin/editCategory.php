<?php require("configs/globals.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$categoryId = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM categories WHERE category_id ='$categoryId'") or die(mysqli_error($connection));
$category = mysqli_fetch_assoc($query);
$categoryDescription = $category["category_description"];
$categoryImage = $category["category_image"];
$categoryName = $category["category_name"];
$parentId = $category["parent_id"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Edit Category</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
    <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css"/>
    <!--  END CUSTOM STYLE FILE  -->
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
    <?php
    require("templates/sideBar.php");
    ?>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-spacing">

                <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing offset-md-2">

                    <div class="skills layout-spacing">
                        <div class="widget-content widget-content-area">
                            <form action="" method="post" enctype="multipart/form-data" class="p-5">
                                <h3 class="">Edit Category</h3>
                                <?php require("scripts/main.php"); ?>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input name="id" type="hidden" value="<?php print $categoryId; ?>">
                                            <input type="text" class="form-control" placeholder="Category Name"
                                                   name="categoryName" value="<?php echo $categoryName; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 ">
                                        <div class="form-group">
                                            <select class="form-control" name="parentId">
                                                <option value="">-- Parent category --</option>
                                                <?php
                                                $catQuery = mysqli_query($connection, "SELECT * FROM categories ORDER BY category_name ASC") or die(mysqli_error($connection));
                                                while ($category = mysqli_fetch_assoc($catQuery)) {
                                                    $selected = ($category["category_id"] == $parentId) ? "selected" : "";
                                                    ?>
                                                    <option value="<?php print $category["category_id"]; ?>" <?php print $selected; ?>><?php print $category["category_name"]; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="categoryDescription" placeholder="Category Description"
                                                      class="form-control" id="" cols="30"
                                                      rows="5"><?php echo $categoryDescription; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Category Image</label>
                                            <input type="file" name="categoryImage" class="form-control">
                                            <?php if ($categoryImage): ?>
                                                <img src="../<?php echo $categoryImage; ?>" alt="Category Image"
                                                     style="width: 100px; height: auto;" class="p-2 border-dark">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="editCategory">Save Info</button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php require("templates/footer.php"); ?>
    </div>
    <!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="plugins/select2/select2.min.js"></script>
<script src="plugins/select2/custom-select2.js"></script>
<script>
    $(document).ready(function () {
        $(".catalog").addClass("active");
        $(".categories").addClass("active");
        $("#catalog").addClass("show");

        App.init();
    });
</script>
<script src="assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
</body>

</html>