<?php

header('Content-Type: application/json');
require("../../configs/connection.php");
require("../../configs/validate.data.php");

if (isset($_GET["order_id"]) &&  isset($_GET["token"])) {

    $orderId = $_GET["order_id"];

    $query = mysqli_query($connection, "SELECT * FROM customers, orders WHERE orders.order_id ='$orderId' AND orders.customer_id = customers.customer_id") or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);

    $fname = $data["customer_fname"];
    $lname = $data["customer_lname"];
    $customer_email = $data["customer_email"];

    $zipcode = "";
    $city = $data["customer_address"];
    $country = "Rwanda";

    $number_unit = 1;
    $total = $data["order_total"];
    $unit_price = $data["order_total"];
    $pay_amount = $data["order_total"];

    // GENERATE TRANSACTION ID 

    function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $transactionId = "CK" . generateRandomString();
    $gateway = 'Visa, Mastercard, American Express, Discover, JCB, etc';


    $currency = "RWF";
    $companyToken = '9F416C11-127B-4DE2-AC7F-D5710E4C5E0A';
    $today = date("Y-m-d");
    $xml = '<API3G>' .
        '<CompanyToken>' . $companyToken . '</CompanyToken>' .
        '<Request>createToken</Request>' .
        '<Transaction>' .
        '<PaymentAmount>' . $total . '</PaymentAmount>' .
        '<PaymentCurrency>' .  $currency . '</PaymentCurrency>' .
        '<CompanyRef>'.$transactionId.'</CompanyRef>' .
        '<RedirectURL>https://Discrounts.com/api/payment/dpo/return</RedirectURL>' .
        '<BackURL>https://Discrounts.com/canceled</BackURL>' .
        '<CompanyRefUnique>0</CompanyRefUnique>' .
        '<PTL>5</PTL>' .
        '</Transaction>' .
        '<Services>' .
        '<Service>' .
        '<ServiceType>3854</ServiceType>' .
        '<ServiceDescription>Discrounts shopping</ServiceDescription>' .
        '<ServiceDate>' . $today . '</ServiceDate>' .
        '</Service>' .
        '</Services>' .
        '<customerFirstName>' . $fname . '</customerFirstName>' .
        '<customerLastName>' . $lname . '</customerLastName>' .
        '<customerZip>' . $zipcode . '</customerZip>' .
        '<customerCity>' . $city . '</customerCity>' .
        '<customerCountry>' . $country . '</customerCountry>' .
        '<customerEmail>' . $customer_email . '</customerEmail>' .
        '</API3G>';


    $url = 'https://secure.3gdirectpay.com/API/v6/';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);


    // Send to remote and return data to caller.
    $result = curl_exec($ch);
    curl_close($ch);

    $xmlm = simplexml_load_string($result);


    $TransToken = $xmlm->TransToken[0];
    $CleanToken = (string)$TransToken;

    $urlpay = 'https://secure.3gdirectpay.com/pay.asp?ID=' . $CleanToken;


    mysqli_query($connection, "INSERT INTO `payments` (`payment_id`,`payment_method_id`, `order_id`, `transaction_id`, `external_transaction_id`, `transaction_time`, `transaction_status`) 
    VALUES (NULL,'1', '$orderId', '$transactionId', '$CleanToken', NOW(), 'pending')") or die(mysqli_error($connection));

    $data = array();

    $data["transaction_id"] = $transactionId;
    $data["external_transaction_id"] = "$CleanToken";
    $data["transaction_status"] = 'pending';
    $data["redirect_url"] = $urlpay;

    $array = array(
        'code' => 200,
        'status' => "Success",
        'data' => $data,
    );

    $response = json_encode($array, TRUE);
    print($response);
} else {

    $array = array(
        'code' => 400,
        'status' => "Failed",
        'message' => "Invalid request",
    );

    $response = json_encode($array, TRUE);
    print($response);
}
