<?php
ob_start();
require "configs/connection.php";
require "configs/test.data.php";
require "configs/get_ip_address.php";

if (isset($_POST["topUp"])) {

    $customerId         = TestData($_POST["customerId"]);
    $userId             = $_COOKIE["CK_USER_ID"];
    $date               = date("Y-m-d");
    $ipAddress          = getUserIP();
    $activity           = "credit";
    $amount             = TestData($_POST["amount"]);
    $currency           = TestData($_POST["currency"]);
    $note               = TestData($_POST["note"]);

    $rate = TestData($_POST["rate"]);

    // if ($currency == "RWF") {
    //     $rate = 1016.5;
    //     $amount = round($amount / $rate, 3);
    // } else if ($currency == "Yuan") {
    //     $rate = 6.36;
    //     $amount = round($amount / $rate, 3);
    // } else {
    //     $rate = 1;
    // }

    // BANK CHARGES 

    if ($amount <= 3000) {
        $charges = 50;
    } elseif ($amount > 3000 && $amount <= 5000) {
        $charges = 70;
    } elseif ($amount > 5000 && $amount <= 10000) {
        $charges = 110;
    } elseif ($amount > 10000 && $amount <= 15000) {
        $charges = 140;
    } elseif ($amount > 15000 && $amount <= 20000) {
        $charges = 160;
    } elseif ($amount > 20000 && $amount <= 30000) {
        $charges = 180;
    } elseif ($amount > 30000 && $amount <= 50000) {
        $charges = 200;
    } elseif ($amount > 50000 && $amount <= 60000) {
        $charges = 240;
    } elseif ($amount > 60000 && $amount <= 100000) {
        $charges = 250;
    } elseif ($amount > 100000 && $amount <= 150000) {
        $charges = 300;
    } elseif ($amount > 150000 && $amount <= 200000) {
        $charges = 350;
    }




    mysqli_query($connection, "INSERT INTO `wallet_transactions` (`transaction_id`, `customer_id`, `user_id`, `transaction_date`, `transaction_time`, `transaction_ip`, `transaction_activity`, `transaction_amount`, `transaction_currency`, `transaction_exchange_rate`, `transaction_note`, `transaction_status`) 
    VALUES (NULL, '$customerId', '$userId', '$date', current_timestamp(), '$ipAddress', '$activity', '$amount', '$currency', '$rate', '$note', 'successful')") or die(mysqli_error($connection));

    $activity = "debit";
    $note   = "Bank Charges";

    mysqli_query($connection, "INSERT INTO `wallet_transactions` (`transaction_id`, `customer_id`, `user_id`, `transaction_date`, `transaction_time`, `transaction_ip`, `transaction_activity`, `transaction_amount`, `transaction_currency`, `transaction_exchange_rate`, `transaction_note`, `transaction_status`) 
    VALUES (NULL, '$customerId', '$userId', '$date', current_timestamp(), '$ipAddress', '$activity', '$charges', '$currency', '$rate', '$note', 'successful')") or die(mysqli_error($connection));

    // CHECK CUSTOMER'S WALLET BALANCE

    $query = mysqli_query($connection, "SELECT * FROM customers WHERE customer_id ='$customerId'") or die(mysqli_error($connection));
    $customer = mysqli_fetch_assoc($query);


    $currentBalance = $customer["customer_wallet"];

    $amount = $amount - $charges;
    $amount = $amount * $rate;
    $deposit = $amount;
    $newBalance = $currentBalance + $amount;

    // UPDATE BALANCE

    mysqli_query($connection, "UPDATE `customers` SET `customer_wallet` = '$newBalance' WHERE `customers`.`customer_id` = '$customerId'");


    if ($query) {
        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert  = "success";
        $msg    = "You have successfully toped up customer's wallet!";
        require("templates/alert.php");
    }

    // NOTIFY CUSTOMER THROUGH EMAIL

    $query = mysqli_query($connection, "SELECT * FROM customers WHERE customer_id ='$customerId'") or die(mysqli_error($connection));
    $customer = mysqli_fetch_assoc($query);

    // SEND EMAIL NOTIFICATION

    $to = $customer["customer_email"];
    $subject = "Your wallet has been credited";
    $message = "
            <html>
            <body>
            <p>Dear " . $customer['customer_fname'] . " " . $customer['customer_lname'] . "</p>
            <p>Your wallet has been credited ¥$amount </p>
        
            <p>You have deposited ¥$deposit  , and $$charges  was cut as Bank Charges. </p>
            <p> Your new Balance is ¥$newBalance </p>
        
            <p>Kind regards!</p>
        
            </body>
            </html>
            ";

    require("configs/email.php");
}


if (isset($_POST["debit"])) {

    $customerId         = TestData($_POST["customerId"]);
    $userId             = $_COOKIE["CK_USER_ID"];
    $date               = date("Y-m-d");
    $ipAddress          = getUserIP();
    $activity           = "debit";
    $amount             = TestData($_POST["amount"]);
    $currency           = TestData($_POST["currency"]);
    $note               = TestData($_POST["note"]);

    // if ($currency == "RWF") {
    //     $rate = 1016.5;
    //     $amount = round($amount / $rate, 3);
    // } else if ($currency == "Yuan") {
    //     $rate = 6.36;
    //     $amount = round($amount / $rate, 3);
    // } else {
    //     $rate = 1;
    // }

    $rate = 1;

    mysqli_query($connection, "INSERT INTO `wallet_transactions` (`transaction_id`, `customer_id`, `user_id`, `transaction_date`, `transaction_time`, `transaction_ip`, `transaction_activity`, `transaction_amount`, `transaction_currency`, `transaction_exchange_rate`, `transaction_note`, `transaction_status`) 
    VALUES (NULL, '$customerId', '$userId', '$date', current_timestamp(), '$ipAddress', '$activity', '$amount', '$currency', '$rate', '$note', 'successful')") or die(mysqli_error($connection));


    // CHECK CUSTOMER'S WALLET BALANCE

    $query = mysqli_query($connection, "SELECT * FROM customers WHERE customer_id ='$customerId'") or die(mysqli_error($connection));
    $customer = mysqli_fetch_assoc($query);

    $currentBalance = $customer["customer_wallet"];
    $newBalance = $currentBalance - $amount;

    // UPDATE BALANCE

    mysqli_query($connection, "UPDATE `customers` SET `customer_wallet` = '$newBalance' WHERE `customers`.`customer_id` = '$customerId'");


    if ($query) {
        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert  = "success";
        $msg    = "You have successfully debitted customer's wallet!";
        require("templates/alert.php");


        // NOTIFY CUSTOMER THROUGH EMAIL

        $query = mysqli_query($connection, "SELECT * FROM customers WHERE customer_id ='$customerId'") or die(mysqli_error($connection));
        $customer = mysqli_fetch_assoc($query);

        // SEND EMAIL NOTIFICATION

        $to = $customer["customer_email"];
        $subject = "Your wallet has been credited";
        $message = "
            <html>
            <body>
            <p>Dear " . $customer['customer_fname'] . " " . $customer['customer_lname'] . "</p>
            <p>Your wallet has been debited ¥$amount </p>
        
            <p> Your new Balance is ¥$newBalance </p>
        
            <p>Kind regards!</p>
        
            </body>
            </html>
            ";

        require("configs/email.php");
    }
}

ob_end_flush();
