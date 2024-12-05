<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");


$cartTotal = 0;
$query = mysqli_query($connection, "SELECT * FROM payment_methods") or die(mysqli_error($connection));
while ($data = mysqli_fetch_assoc($query)) {


    $methods[] = $data;
}

$array = array(
    'code' => 200,
    'status' => "success",
    'message' => "Payment Methods",
    'data' => $methods,

);

$response = json_encode($array, TRUE);
print($response);
