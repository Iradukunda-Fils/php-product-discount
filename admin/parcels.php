<?php require("configs/globals.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Parcels</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
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
                                            <th>Contaiiner</th>
                                            <th>Code</th>
                                            <th>CBM</th>
                                            <th>CBM Price</th>
                                            <th>Freight</th>
                                            <th>Other</th>
                                            <th>Name</th>
                                            <th>Destination</th>
                                            <th>ETA</th>
                                            <th>Consignee</th>
                                            <th width="50">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $query = mysqli_query($connection, "SELECT * FROM  parcels, containers, container_categories, customers WHERE parcels.customer_id = customers.customer_id AND parcels.container_id = containers.container_id AND container_categories.category_id =containers.category_id AND parcel_status !='deleted' ORDER BY parcel_id DESC") or die(mysqli_error($connection));
                                        $no = 0;
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            $no++; ?>
                                            <tr>
                                                <td><?php print($no) ?></td>
                                                <td><?php print($data["container_code"]); ?> [<?php print($data["category_name"]); ?>]</td>
                                                <td><?php print($data["parcel_code"]); ?></td>
                                                <td><?php print($data["parcel_cbm"]); ?></td>
                                                <td><?php print($data["parcel_cbm_price"]); ?> <?php print($data["currency"]); ?></td>
                                                <td><?php print($data["parcel_freight_price"]); ?> <?php print($data["currency"]); ?></td>
                                                <td><?php print($data["other_charges"]); ?> <?php print($data["currency"]); ?></td>
                                                <td><?php print($data["parcel_name"]); ?></td>
                                                <td><?php print($data["parcel_destination"]); ?></td>
                                                <td><?php print($data["parcel_ship_date"]); ?></td>
                                                <td><?php print($data["customer_fname"]); ?> <?php print($data["customer_lname"]); ?></td>
                                                <td>

                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm">Action</button>
                                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference<?php print($no) ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="status?parcel=<?php print($data["parcel_id"]); ?>">Status</a>
                                                            <a class="dropdown-item" href="addStatus?parcel=<?php print($data["parcel_id"]); ?>">Add Status</a>
                                                            <a class="dropdown-item text-danger" href="?deleteParcel=<?php print($data["parcel_id"]); ?>">Delete</a>
                                                        </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="30">No</th>
                                            <th>Contaiiner</th>
                                            <th>Code</th>
                                            <th>CBM</th>
                                            <th>CBM Price</th>
                                            <th>Freight</th>
                                            <th>Other</th>
                                            <th>Name</th>
                                            <th>Destination</th>
                                            <th>ETA</th>
                                            <th>Consignee</th>
                                            <th width="50">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <a href="addParcel" class="btn btn-primary btn-rounded btn-floated"><i data-feather="plus-circle"></i></a>
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
            $(".parcels").addClass("active");
            $(".allparcels").addClass("active");
            $("#parcels").addClass("show");
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="plugins/table/datatable/datatables.js"></script>
    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
    <script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="plugins/table/datatable/button-ext/jszip.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
        $('#zero-config').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [{
                        extend: 'copy',
                        className: 'btn'
                    },
                    {
                        extend: 'csv',
                        className: 'btn'
                    },
                    {
                        extend: 'excel',
                        className: 'btn'
                    },
                    {
                        extend: 'print',
                        className: 'btn'
                    }
                ]
            },
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [8, 10, 20, 50],
            "pageLength": 8
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>