<?php

header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

if(isset($_GET["limit"]))
{
    $limit = $_GET["limit"];
}else{
    $limit = 40;
}

if(isset($_GET["store_id"]))
{
    $store_id = $_GET["store_id"];
}else{
    $store_id = 1;
}

$limit = 12;

$query = mysqli_query($connection, "SELECT * FROM products  ORDER BY product_id DESC LIMIT $limit ") or die(mysqli_error($connection));

while ($data = mysqli_fetch_assoc($query)) {
    $data["product_image"] = "http://disscrounts.rw/" . $data["product_image"];

    $products[] = $data;
}

$array = array(
    'code' => 200,
    'status' => "success",
    'message' => "New arrivals products",
    'data' => $products
);

$response = json_encode($array, TRUE);
print($response);
