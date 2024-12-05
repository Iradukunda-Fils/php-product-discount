<?php

session_start();

if (isset($_COOKIE["CKSESSIONID"])) {
    $sessionId = $_COOKIE["CKSESSIONID"];
} else {


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

    $sessionId = sha1(generateRandomString());

    setcookie("CKSESSIONID", $sessionId , time() + (86400 * 30), "/");
}

if (isset($_GET["logout"])) {
    // Destroy cookies
    setcookie("CKSESSIONID", "", time() - 3600, "/");
    setcookie("CKCUSTOMERID", "", time() - 3600, "/");
    setcookie("CKCUSTOMERNAME", "", time() - 3600, "/");

    // Destroy session

    session_unset();
    session_destroy();

    // Redirect to login page
    header("Location: login");
    exit();
}

$customerId = $_COOKIE["CKCUSTOMERID"];
