<?php

// CHECK USER Status
require("configs/connection.php");
$user_id 	= $_COOKIE["CK_USER_ID"];

if (!isset($_COOKIE["CK_USER_ID"])) {
	header("location:./");
}

if (isset($_GET["sign"])) {
	$sign = $_GET["sign"];

	if ($sign == "out") {
		setcookie("CK_USER_ID", 0, time() + (86400 * 0), "/");
		setcookie("CK_USER_ROLE", 0, time() + (86400 * 0), "/");
		setcookie("CK_USER_USERNAME", 0, time() + (86400 * 0), "/");
		header("location:./");
	}
}
