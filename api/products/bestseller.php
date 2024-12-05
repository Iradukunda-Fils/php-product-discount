<?php

header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");


if(isset($_GET["limit"]))
{
    $limit = $_GET["limit"];
}else{
    $limit = 6;
}

$limit = 9;

$query = mysqli_query($connection, "SELECT * FROM products  ORDER BY rand() LIMIT $limit ") or die(mysqli_error($connection));

while ($data = mysqli_fetch_assoc($query)) {
    $data["product_image"] = "http://disscrounts.rw/" . $data["product_image"];

    $products[] = $data;
}

$array = array(
    'code' => 200,
    'status' => "success",
    'message' => "Bestseller products",
    'data' => $products
);

$response = json_encode($array, TRUE);
print($response);
