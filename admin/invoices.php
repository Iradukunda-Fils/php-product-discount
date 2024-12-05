<?php require("configs/globals.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CK-Invoice-<?php print date("Y-m-d h-i-s"); ?></title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="assets/css/apps/invoice.css" rel="stylesheet" type="text/css"/>
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
    <?php require("templates/sideBar.php"); ?>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row invoice layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="app-hamburger-container">
                        <div class="hamburger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-menu chat-menu d-xl-none">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </div>
                    </div>
                    <div class="doc-container">
                        <div class="tab-title">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="search">
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                    <ul class="nav nav-pills inv-list-container d-block" id="pills-tab" role="tablist">
                                        <?php
                                        $query = mysqli_query($connection, "SELECT * FROM orders, users WHERE users.user_id = orders.customer_id  ORDER BY  order_id DESC") or die(mysqli_error($connection));
                                        while ($invoice = mysqli_fetch_assoc($query)) {
                                            ?>
                                            <li class="nav-item">
                                                <div class="nav-link list-actions"
                                                     id="invoice-<?php print $invoice["order_id"]; ?>"
                                                     data-invoice-id="<?php print $invoice["order_id"]; ?>">
                                                    <div class="f-m-body">
                                                        <div class="f-head">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none"
                                                                 stroke="currentColor" stroke-width="2"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 class="feather feather-dollar-sign">
                                                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="f-body">
                                                            <p class="invoice-number">Invoice
                                                                #CK<?php print $invoice["order_id"]; ?></p>
                                                            <p class="invoice-customer-name">
                                                                <span>To:</span> <?php print $invoice["user_fname"]; ?> <?php print $invoice["user_lname"]; ?>
                                                            </p>
                                                            <p class="invoice-generated-date">
                                                                Date: <?php print $invoice["order_time"]; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="invoice-container">
                            <div class="invoice-inbox">

                                <div class="inv-not-selected">
                                    <p>Open an order from the list.</p>
                                </div>

                                <div class="invoice-header-section">
                                    <h4 class="inv-number"></h4>
                                    <div class="invoice-action">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-printer action-print" data-toggle="tooltip"
                                             data-placement="top" data-original-title="Reply">
                                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                            <rect x="6" y="14" width="12" height="8"></rect>
                                        </svg>
                                    </div>
                                </div>

                                <div id="ct" class="">
                                    <?php
                                    $query = mysqli_query($connection, "SELECT * FROM orders, users WHERE users.user_id = orders.customer_id  ORDER BY  order_id DESC") or die(mysqli_error($connection));
                                    while ($invoice = mysqli_fetch_assoc($query)) {
                                        ?>

                                        <div class="invoice-<?php print $invoice["order_id"]; ?>">
                                            <div class="content-section  animated animatedFadeInUp fadeInUp">

                                                <div class="row inv--head-section">

                                                    <div class="col-sm-6 col-12">
                                                        <h3 class="in-heading">INVOICE</h3>
                                                    </div>
                                                    <div class="col-sm-6 col-12 align-self-center text-sm-right">
                                                        <div class="company-info">
                                                            <img src="assets/img/favicon.png" height="45" alt="">
                                                            <h5 class="inv-brand-name">Discrounts</h5>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row inv--detail-section">

                                                    <div class="col-sm-7 align-self-center">
                                                        <p class="inv-to">Invoice To</p>
                                                    </div>
                                                    <div class="col-sm-5 align-self-center  text-sm-right order-sm-0 order-1">
                                                        <p class="inv-detail-title">From : Discrounts Ltd</p>
                                                    </div>

                                                    <div class="col-sm-7 align-self-center">
                                                        <p class="inv-customer-name"><?php print $invoice["user_fname"]; ?><?php print $invoice["user_lname"]; ?></p>
                                                        <p class="inv-street-addr"><?php print $invoice["address"]; ?>
                                                            , </p>
                                                        <p class="inv-email-address"><?php print $invoice["user_email"]; ?></p>
                                                        <p class="inv-email-address"><?php print $invoice["user_phone"]; ?></p>
                                                    </div>
                                                    <div class="col-sm-5 align-self-center  text-sm-right order-2">
                                                        <p class="inv-list-number"><span class="inv-title">Invoice Number : </span>
                                                            <span class="inv-number">[invoice number]</span></p>
                                                        <p class="inv-created-date"><span class="inv-title">Invoice Date : </span>
                                                            <span class="inv-date"><?php print $invoice["order_time"]; ?></span>
                                                        </p>
                                                        <p class="inv-due-date"><span
                                                                    class="inv-title">Due Date : </span> <span
                                                                    class="inv-date"><?php print $invoice["order_time"]; ?></span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row inv--product-table-section">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class="">
                                                                <tr>
                                                                    <th scope="col">S.No</th>
                                                                    <th scope="col">Items</th>
                                                                    <th class="text-right" scope="col">Qty</th>
                                                                    <th class="text-right" scope="col">Unit Price</th>
                                                                    <th class="text-right" scope="col">Amount</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $orderId = $invoice["order_id"];
                                                                $itemsQuery = mysqli_query($connection, "SELECT * FROM order_products, products WHERE order_id ='$orderId' AND products.product_id = order_products.product_id") or die(mysqli_error($connection));
                                                                $no = 0;
                                                                $total = 0;
                                                                while ($item = mysqli_fetch_assoc($itemsQuery)) {

                                                                    $no++;
                                                                    $total = $total + $item["total_price"];
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php print $no; ?></td>
                                                                        <td><?php print $item["product_name"]; ?></td>
                                                                        <td class="text-right"><?php print $item["quantity"]; ?></td>
                                                                        <td class="text-right">
                                                                            RWF <?php print $item["total_price"]/$item["quantity"]; ?></td>
                                                                        <td class="text-right">
                                                                            RWF <?php print number_format($item["total_price"])?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                        <div class="inv--payment-info">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-12">
                                                                    <h6 class=" inv-title">Payment Info:</h6>
                                                                </div>
                                                                <div class="col-sm-4 col-12">
                                                                    <p class=" inv-subtitle">Method: </p>
                                                                </div>
                                                                <div class="col-sm-8 col-12">
                                                                    <p class="">MTN MOMO</p>
                                                                </div>
                                                                <div class="col-sm-4 col-12">
                                                                    <p class=" inv-subtitle">Acc No : </p>
                                                                </div>
                                                                <div class="col-sm-8 col-12">
                                                                    <p class="">44203</p>
                                                                </div>
                                                                <div class="col-sm-4 col-12">
                                                                    <p class=" inv-subtitle">Acc Name : </p>
                                                                </div>
                                                                <div class="col-sm-8 col-12">
                                                                    <p class="">Discrounts Ltd</p>
                                                                </div>
                                                                <div class="col-sm-4 col-12">
                                                                    <p class=" inv-subtitle">Currency : </p>
                                                                </div>
                                                                <div class="col-sm-8 col-12">
                                                                    <p class="">RWF</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                        <div class="inv--total-amounts text-sm-right">
                                                            <div class="row">
                                                                <div class="col-sm-8 col-7">
                                                                    <p class="">Sub Total: </p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class="">
                                                                        RWF <?php print number_format(number_format($total)); ?></p>
                                                                </div>
                                                                <!-- <div class="col-sm-8 col-7">
                                                                    <p class="">Tax Amount: </p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class="">$0</p>
                                                                </div> -->
                                                                <div class="col-sm-8 col-7">
                                                                    <p class=" discount-rate">Discount : <span
                                                                                class="discount-percentage">0%</span>
                                                                    </p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class="">RWF 0</p>
                                                                </div>
                                                                <div class="col-sm-8 col-7 grand-total-title">
                                                                    <h4 class="">Grand Total : </h4>
                                                                </div>
                                                                <div class="col-sm-4 col-5 grand-total-amount">
                                                                    <h4 class="">
                                                                        RWF <?php print number_format(number_format($total)); ?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mt-3 mb-4 col-md-12">
                                                        <h6 class=" inv-title">Notes / Terms:</h6>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    <?php } ?>

                                </div>

                            </div>
                            <div class="inv--thankYou">
                                <div class="row">
                                    <div class="col-sm-12 col-12">
                                        <p class="">Thank you for doing Business with us.</p>
                                    </div>
                                </div>
                            </div>
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

<script>
    $(document).ready(function () {
        $("#sales").addClass("show");
        $(".orders").addClass("active");
        App.init();
    });
</script>
<script src="assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="assets/js/apps/invoice.js"></script>
</body>

</html>