<?php require("configs/globals.php");

if (isset($_GET["customer"])) {
    $customerId = $_GET["customer"];
    $query = mysqli_query($connection, "SELECT * FROM customers WHERE customer_id  ='$customerId'") or die(mysqli_error($containerId));
    $customer = mysqli_fetch_assoc($query);


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <title>Debit <?php print $customer["customer_fname"]; ?> <?php print $customer["customer_lname"]; ?>'s wallet </title>
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
                                        <h3 class="">Debit <?php print $customer["customer_fname"]; ?> <?php print $customer["customer_lname"]; ?>'s wallet</h3>
                                        <?php require("scripts/wallet.php"); ?>

                                        <input type="hidden" name="customerId" value="<?php print $customer["customer_id"]; ?>" id="">

                                        <div class="row">
                                           
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input type="text" class="form-control" placeholder="" name="amount" value="" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Currency</label>
                                                    <select name="currency" id="" class="form-control">

                                                        <!-- <option value="USD">USD</option>
                                                        <option value="RWF">RWF</option> -->
                                                        <option value="Yuan">Yuan</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Notes</label>
                                                    <textarea name="note" class="form-control">
                                                </textarea>
                                                    <script>
                                                        CKEDITOR.replace('note');
                                                    </script>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary " type="submit" name="debit">Top Up Wallet</button>
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
                $(".wallets").addClass("active");

            
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

<?php } ?>