<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

if (isset($_GET["token"])) {

    $token = validate($_GET["token"]);

    $query = mysqli_query($connection, "SELECT * FROM wishlists, products WHERE session_id ='$token' AND products.product_id = wishlists.product_id") or die(mysqli_error($connection));
    while ($data = mysqli_fetch_assoc($query)) {


        # CHECK IF THE PRODUCT IS NOT IN CART
        $productId = $data["product_id"];

        $query = mysqli_query($connection, "SELECT * FROM carts WHERE session_id ='$token' AND product_id ='$productId'") or die(mysqli_error($connection));
        $count = mysqli_num_rows($query);


        $produtId = $data["product_id"];
        $price = $data["product_price"];
        $quantity = 1;

        if ($count > 0) {

            $data = mysqli_fetch_assoc($query);
            $quantity = $quantity + $data["cart_qty"];

            $total = $price * $quantity;
            $total = $total + $data["cart_total"];

            mysqli_query($connection, "UPDATE carts  SET cart_qty ='$quantity', cart_total ='$total' WHERE session_id ='$token' AND product_id ='$productId'") or die(mysqli_error($connection));
            
        } else {

            $total = $price * $quantity;

            mysqli_query($connection, "INSERT INTO `carts` (`cart_id`, `session_id`, `customer_id`, `product_id`, `cart_qty`, `cart_total`, `cart_time`) 
            VALUES (NULL, '$token', NULL, '$productId', '$quantity', '$total', current_timestamp())") or die(mysqli_error($connection));
            
        }
    }

    mysqli_query($connection, "DELETE FROM wishlists WHERE session_id ='$token'") or die(mysqli_error($connection));


    $array = array(
        'code' => 200,
        'status' => "success",
        'message' => "You have added products in cart",
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
