<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

if (isset($_GET["product_id"])  && isset($_GET["customer_id"])  && isset($_GET["token"])) {

    $token = validate($_GET["token"]);
    $productId = validate($_GET["product_id"]);
    $customerId = validate($_GET["customer_id"]);

    #Check if the product is in wishlist

    $query = mysqli_query($connection, "SELECT * FROM wishlists WHERE session_id ='$token' AND product_id ='$productId'") or die(mysqli_error($connection));
    $count = mysqli_num_rows($query);

    if ($count == 1) {
        
        $message    = "This product is already in your wishlist!";
        
    } else {

        mysqli_query($connection, "INSERT INTO `wishlists` (`wishlist_id`, `session_id`, `customer_id`, `product_id`) 
        VALUES (NULL, '$token', '$customerId', '$productId')") or die(mysqli_error($connection));

        
        $message    = "You have added a product in your wishlist!";
        
    }


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
