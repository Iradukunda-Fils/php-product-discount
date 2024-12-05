<?php

header('Content-Type: application/json');
require("../../configs/connection.php");
require("../../configs/validate.data.php");


if (isset($_GET["order_id"])) {
    $orderId = $_GET["order_id"];

    $query = mysqli_query($connection, "SELECT * FROM payments WHERE order_id ='$orderId'") or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);

    $array = array(
        'code' => 200,
        'status' => "Success",
        'data' => $data,
    );

    $response = json_encode($array, TRUE);
    print($response);
}
