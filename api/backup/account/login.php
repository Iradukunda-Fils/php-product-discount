<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$phone = $data["phone"];
$password = sha1($data["password"]);

// check if the phone is available

$query = mysqli_query($connection, "SELECT * FROM users WHERE user_phone ='$phone' AND user_password='$password'") or die(mysqli_error($connection));
$count = mysqli_num_rows($query);

$data = mysqli_fetch_assoc($query);

if ($count == 1) {
    $array = array(
        'code' => 200,
        'status' => "Success",
        'message' => "You have successfully logged in",
        'data' => $data
    );
    
} else {

    $array = array(
        'code' => 401,
        'status' => "Failed",
        'message' => "Invalid credentials",
        'data' => null
    );

}

$response = json_encode($array, TRUE);
print($response);