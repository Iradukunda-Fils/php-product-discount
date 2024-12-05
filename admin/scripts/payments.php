<?php
ob_start();
require "configs/connection.php";
require "configs/test.data.php";
require "configs/get_ip_address.php";


if (isset($_POST["recordPayment"])) {

    $customerId         = TestData($_POST["customerId"]);
    $invoiceId          = TestData($_POST["invoiceId"]);
    $userId             = $_COOKIE["CK_USER_ID"];
    $date               = date("Y-m-d");
    $ipAddress          = getUserIP();
    $amount             = TestData($_POST["amount"]);
    $currency           = TestData($_POST["currency"]);
    $note               = TestData($_POST["note"]);


    if ($query) {
        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert  = "success";
        $msg    = "You have successfully recorded a customer's payment!";
        require("templates/alert.php");
    }



    $query = mysqli_query($connection, "INSERT INTO `invoice_payments` (`payment_id`, `customer_id`, `invoice_id`, `user_id`, `payment_amount`, `currency`, `payment_date`) 
    VALUES (NULL, '$customerId', '$invoiceId', '$userId','$amount', '$currency', '$date')") or die(mysqli_error($connection));
    $customer = mysqli_fetch_assoc($query);


    $query = mysqli_query($connection, "SELECT * FROM customers WHERE customer_id ='$customerId'") or die(mysqli_error($connection));
    $customer = mysqli_fetch_assoc($query);

    // NOTIFY CUSTOMER THROUGH EMAIL

    // SEND EMAIL NOTIFICATION

    $to = $customer["customer_email"];
    $subject = "Your payment has been recorded";
    $message = "
            <html>
            <body>
            <p>Dear " . $customer['customer_fname'] . " " . $customer['customer_lname'] . "</p>
            <p>Ths is to comfirm that we have received your payment of $currency $amout </p>
        
        
            <p>Kind regards!</p>
        
            </body>
            </html>
            ";

    require("configs/email.php");
}
