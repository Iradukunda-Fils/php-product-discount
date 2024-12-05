<?php

header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");


if(isset($_GET["store_id"]))
{
    $store_id = $_GET["store_id"];
}else{
    $store_id = 1;
}


if (isset($_GET["query"])) {

    $q = $_GET["query"];
    
    $products =array();

    $query = mysqli_query($connection, "SELECT * FROM products WHERE product_name LIKE '%$q%' ORDER BY rand() LIMIT 20") or die(mysqli_error($connection));

    while ($data = mysqli_fetch_assoc($query)) {
        $data["product_image"] = "http://disscrounts.rw/" . $data["product_image"];

        $products[] = $data;
    }

    $array = array(
        'code' => 200,
        'status' => "success",
        'message' => "Search Results",
        'data' => $products
    );

    $response = json_encode($array, TRUE);
    print($response);
}
