<?php

header('Content-Type: application/json');
require("../../configs/connection.php");
require("../../configs/validate.data.php");


if (isset($_GET["TransID"])) {
    $extTransactionId = $_GET["TransID"];


    $vxml = '<?xml version="1.0" encoding="utf-8"?>' .
        '<API3G>' .
        '<CompanyToken>9F416C11-127B-4DE2-AC7F-D5710E4C5E0A</CompanyToken>' .
        '<Request>verifyToken</Request>' .
        '<TransactionToken>' . $extTransactionId . '</TransactionToken>' .
        '</API3G>';


    $vurl = 'https://secure.3gdirectpay.com/API/v6/';
    $vch = curl_init();
    curl_setopt($vch, CURLOPT_URL, $vurl);

    // For xml, change the content-type.
    curl_setopt($vch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));

    curl_setopt($vch, CURLOPT_POST, 1);
    curl_setopt($vch, CURLOPT_POSTFIELDS, $vxml);

    curl_setopt($vch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($vch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($vch, CURLOPT_SSL_VERIFYPEER, 0);
    // ask for results to be returned

    // Send to remote and return data to caller.
    $vresult = curl_exec($vch);
    curl_close($vch);
    $xmlm = simplexml_load_string($vresult);


    $status = (string) $xmlm->ResultExplanation;
    $extTransactionId = $_GET["TransID"];

    if ($status == "Transaction Paid") {
        $status = "paid";
    }

    mysqli_query($connection, "UPDATE `payments` SET `transaction_status` = '$status' WHERE `payments`.`external_transaction_id` ='$extTransactionId' ") or die(mysqli_error($connection));
    $query = mysqli_query($connection, "SELECT * FROM payments WHERE  `external_transaction_id` ='$extTransactionId' ") or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);

    $orderId = $data["order_id"];

    mysqli_query($connection, "UPDATE orders SET order_status ='$status' WHERE order_id ='$orderId'");
    mysqli_query($connection, "INSERT INTO `order_history` (`history_id`, `order_id`, `history_time`, `history_event`) 
    VALUES (NULL, '$orderId', current_timestamp(), '$status')");
}

header("location:https://Discrounts.com/completedOrder");
