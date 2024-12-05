<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

if (isset($_GET["token"])) {

    $token = validate($_GET["token"]);

    
    $query = mysqli_query($connection, "SELECT * FROM wishlists, products WHERE wishlists.product_id = products.product_id AND  session_id ='$token' ORDER BY wishlist_id DESC") or die(mysqli_error($connection));
    while ($data = mysqli_fetch_assoc($query)) {

        $data["product_image"] = "http://disscrounts.rw/" . $data["product_image"];
        $data["session_id"] = null;
        $products[] = $data;

        
    }

    $array = array(
        'code' => 200,
        'status' => "success",
        'message' => "Wishlist products",
        'total' => $cartTotal,
        'data' => $products,
        
    );

    $response = json_encode($array, TRUE);
    print($response);

} else {

    $array = array(
        'code' => 400,
        'status' => "failed",
        'message' => "Invalid request",
    );

    $response = json_encode($array, TRUE);
    print($response);
}
