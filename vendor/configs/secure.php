<?php

// CHECK VENDOR Status
require("configs/connection.php");
$VENDOR_id 	= $_COOKIE["CK_VENDOR_ID"];

if (!isset($_COOKIE["CK_VENDOR_ID"])) {
	header("location:./");
}

if (isset($_GET["sign"])) {
	$sign = $_GET["sign"];

	if ($sign == "out") {
		setcookie("CK_VENDOR_ID", 0, time() + (86400 * 0), "/");
		setcookie("CK_VENDOR_NAME", 0, time() + (86400 * 0), "/");
		header("location:./");
	}
}
