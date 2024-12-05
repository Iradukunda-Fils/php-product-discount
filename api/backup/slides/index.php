<?php

header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");



$query = mysqli_query($connection, "SELECT * FROM slides ") or die(mysqli_error($connection));

while ($data = mysqli_fetch_assoc($query)) {
    $data["slide_url"] = "http://disscrounts.rw/" . $data["slide_url"];

    $slides[] = $data;
}

$array = array(
    'code' => 200,
    'status' => "success",
    'message' => "Slides",
    'data' => $slides
);

$response = json_encode($array, TRUE);
print($response);
