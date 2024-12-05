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

$limit = 9;
#

$query = mysqli_query($connection, "SELECT * FROM products  WHERE  product_discount_price != 0 ORDER BY rand() LIMIT $limit") or die(mysqli_error($connection));

while ($data = mysqli_fetch_assoc($query)) {

    $normal_price = $data["product_price"];
    $discount_price = $data["product_discount_price"];

    $discount = round($discount_price * 100 / $normal_price);
    

    $data["product_discount"] = "$discount"."%";
    $data["product_image"] = "http://disscrounts.rw/" . $data["product_image"];

    $products[] = $data;
}

$array = array(
    'code' => 200,
    'status' => "success",
    'message' => "Specials products",
    'data' => $products
);

$response = json_encode($array, TRUE);
print($response);
