<?php
header('Content-Type: application/json');
require("../configs/connection.php");

$query = mysqli_query($connection, "SELECT * FROM stores") or die(mysqli_error($connection));
while ($data = mysqli_fetch_assoc($query)) {

    $data["flag"] = "http://disscrounts.rw/" . $data["flag"];

    $stores[] = $data;
}

$array = array(
    'code' => 200,
    'status' => "success",
    'message' => "Stores",
    'data' => $stores,

);

$response = json_encode($array, TRUE);
print($response);