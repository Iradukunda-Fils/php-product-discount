<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");


$query = mysqli_query($connection, "SELECT * FROM districts") or die(mysqli_error($connection));
while ($data = mysqli_fetch_assoc($query)) {


    $districts[] = $data;
}

$array = array(
    'code' => 200,
    'status' => "success",
    'message' => "Districts",
    'data' => $districts,

);

$response = json_encode($array, TRUE);
print($response);
