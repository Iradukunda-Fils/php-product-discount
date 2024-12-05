<?php require("configs/globals.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Slides</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->



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
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing" id="cancel-row">

                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <?php require("scripts/main.php"); ?>
                        <div class="widget-content widget-content-area br-6">
                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config" class="table table-hover non-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="30">No</th>
                                            <th width="200">Image</th>
                                            <th>Name</th>
                                            <th width="50">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $query = mysqli_query($connection, "SELECT * FROM  slides") or die(mysqli_error($connection));
                                        $no = 0;
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            $no++; ?>
                                            <tr>
                                                <td><?php print($no) ?></td>
                                                <td><img src="../<?php print($data["slide_url"]); ?>" alt="slide" class="img-fluid"></td>
                                                <td><?php print($data["slide_name"]); ?></td>
                                                <td>

                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm">Action</button>
                                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference<?php print($no) ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="?deleteSlide=<?php print($data["slide_id"]); ?>">Delete</a>
                                                        </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th width="30">Image</th>
                                            <th>Name</th>
                                            <th width="50">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <a href="addSlide" class="btn btn-primary btn-rounded btn-floated"><i data-feather="plus-circle"></i> Add New</a>

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

    <script>
        $(document).ready(function() {
            $(".design").addClass("active");
            $(".slides").addClass("active");
            $("#design").addClass("show");

            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>