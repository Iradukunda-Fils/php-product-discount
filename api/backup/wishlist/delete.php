<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

if (isset($_GET["product_id"])  && isset($_GET["token"])) {

    $token = validate($_GET["token"]);
    $productId = validate($_GET["product_id"]);

    mysqli_query($connection, "DELETE FROM wishlists WHERE session_id ='$token' AND product_id ='$productId'") or die(mysqli_error($connection));

    $message = 'You removed a product on your wishlist';


    $array = array(
        'code' => 200,
        'status' => "success",
        'message' => $message,
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
