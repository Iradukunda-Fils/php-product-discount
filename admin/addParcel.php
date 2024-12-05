<?php require("configs/globals.php");

if (isset($_GET["container"])) {
    $containerId = $_GET["container"];
    $query = mysqli_query($connection, "SELECT * FROM containers WHERE container_id ='$containerId'") or die(mysqli_error($containerId));
    $containerInfo = mysqli_fetch_assoc($query);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Shipment Registration </title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
    <link href="assets/css/customers/customer-profile.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->

    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
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

                        <div class="skills layout-spacing ">
                            <div class="widget-content widget-content-area">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <h3 class="">Shipment Registration</h3>
                                    <?php require("scripts/main.php"); ?>

                                    <div class="row">

                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Container ID</label>
                                                <select name="container_id" id="containerId" class="form-control">
                                                    <?php $query = mysqli_query($connection, "SELECT * FROM containers ORDER BY container_id DESC") or die(mysqli_error($connection));
                                                    while ($container = mysqli_fetch_assoc($query)) { ?>
                                                        <option value="<?php print $container["container_id"]; ?>"><?php print $container["container_code"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Consignee</label>
                                                <select name="customer_id" id="" class="form-control">
                                                    <?php $query = mysqli_query($connection, "SELECT * FROM customers ORDER BY customer_id DESC") or die(mysqli_error($connection));
                                                    while ($customer = mysqli_fetch_assoc($query)) { ?>
                                                        <option value="<?php print $customer["customer_id"]; ?>"><?php print $customer["customer_fname"]; ?> <?php print $customer["customer_lname"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Parcel Name</label>
                                                <input type="text" class="form-control" placeholder="" name="parcelName" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Freight Price</label>
                                                <input type="text" class="form-control" placeholder="" name="freightPrice" value="" required>
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Doc Price</label>
                                                <input type="text" class="form-control" placeholder="" name="docPrice" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Other Charges</label>
                                                <input type="text" class="form-control" placeholder="" name="otherCharges" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>CBM</label>
                                                <input type="text" class="form-control" placeholder="" name="cbm" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>CBM Price</label>
                                                <input type="text" class="form-control" placeholder="" name="cbmPrice" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select name="currency" id="" class="form-control">

                                                    <option value="USD">USD</option>
                                                    <option value="RWF">RWF</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Destination</label>
                                                <input type="text" class="form-control" placeholder="Destination" name="parcelDestination" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>ETA</label>
                                                <input type="date" class="form-control" placeholder="Date" name="parcelShippingDate" value="<?php print $containerInfo["container_eta"]; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Shipment Notes</label>
                                                <textarea name="parcelDescription" class="form-control">
                                                </textarea>
                                                <script>
                                                    CKEDITOR.replace('parcelDescription');
                                                </script>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary " type="submit" name="addParcel">Save Shipment Info</button>
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
        $(document).ready(function() {
            $(".parcels").addClass("active");
            $(".addParcel").addClass("active");
            $("#parcels").addClass("show");

            $("#containerId").change(function() {
                var containerId = $("#containerId").find(":selected").val();
                var url = window.location.origin + window.location.pathname + "?container=" + containerId;
                location.href = url;
            });
            App.init();
        });

        var ss = $(".basic").select2({
            tags: true,
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
</body>

</html>