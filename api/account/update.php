<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$token = $data["token"];
$names = $data["names"];
$phone = $data["phone"];
$email = $data["email"];
$address = $data["address"];


$nameParts = explode(' ', $names);
$firstName = array_shift($nameParts);
$secondName = !empty($nameParts) ? implode(' ', $nameParts) : '';

$query = "UPDATE `users` 
          SET `user_name` = '$secondName',
              `user_lname` = '$secondName',
              `user_fname` = '$firstName',
              `user_phone` = '$phone',
              `user_email` = '$email',
              `address` = '$address',
              `user_role` = 'Customer',
              `token` = '$token',
              `user_status` = 'active'
          WHERE `token` = '$token'";

mysqli_query($connection,$query);

$data = array();
$query = mysqli_query($connection,"SELECT * FROM users WHERE token ='$token'")or die(mysqli_error($connection));
$data = mysqli_fetch_assoc($query);


$array = array(
    'code' => 200,
    'status' => "Success",
    'message' => "You have successfully updated your profile.",
    'data' => $data
);

$response = json_encode($array, TRUE);
print($response);