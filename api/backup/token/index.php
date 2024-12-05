<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");


if (isset($_GET["username"]) && isset($_GET["key"]) && isset($_GET["token"])) {

    if ($_GET["username"] == 'Discrounts' && $_GET["key"] == "04dfe1f6e2d25c8073dc7237150f9fb67541186b") {


        function generateRandomString($length = 500)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $token = $_GET["token"];

        $query = mysqli_query($connection, "SELECT * FROM tokens WHERE token ='$token'");
        $count = mysqli_num_rows($query);

        if ($count == 1) {
            $data = mysqli_fetch_assoc($query);
            $token = $data["token"];
        } else {
            $token = generateRandomString();
            mysqli_query($connection, "INSERT INTO `tokens` (`token_id`, `token`, `token_created_time`) VALUES (NULL, '$token', current_timestamp())");
        }

        $array = array(
            'code' => 200,
            'status' => "success",
            'message' => "Access token",
            'token' => $token
        );

        $response = json_encode($array, TRUE);
        print($response);
    }
} else {

    $array = array(
        'code' => 400,
        'status' => "Failed",
        'message' => "Access denied",
    );

    $response = json_encode($array, TRUE);
    print($response);
}
