<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$names = validate($data["names"]);
$phone = validate($data["phone"]);
$email = validate($data["email"]);
$address = validate($data["address"]);
$password = sha1(validate($data["password"]));


$nameParts = explode(' ', $names);
$firstName = array_shift($nameParts);
$secondName = !empty($nameParts) ? implode(' ', $nameParts) : '';
function generate_token($length = 52)
{
    return bin2hex(random_bytes($length / 2));
}

// Example usage:
$token = generate_token();

// check if the phone is available

$query = mysqli_query($connection, "SELECT * FROM users WHERE user_phone ='$phone'") or die(mysqli_error($connection));
$count = mysqli_num_rows($query);
if ($count >= 1) {

    $query = mysqli_query($connection,"SELECT * FROM users WHERE user_phone ='$phone'")or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);


    $array = array(
        'code' => 400,
        'status' => "Failed",
        'message' => "Your phone number is already registered",
        'data' => $data
    );
} else {

    mysqli_query($connection, "INSERT INTO `users` (`user_id`, `user_name`, `user_lname`, `user_fname`, `user_phone`, `user_email`,`address`, `user_password`, `user_role`, `token`, `user_status`) 
VALUES (NULL, '$secondName', '$secondName', '$firstName', '$phone', '$email','$address', '$password', 'Customer', '$token', 'active')") or die(mysqli_error($connection));

    $data["token"] = $token;

    $query = mysqli_query($connection,"SELECT * FROM users WHERE token ='$token'")or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);

    $array = array(
        'code' => 200,
        'status' => "Success",
        'message' => "Successful registration",
        'data' => $data
    );
}
$response = json_encode($array, TRUE);
print($response);