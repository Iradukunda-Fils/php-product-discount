<?php
require("configs/connection.php");
require("secure.php");

#GENERATE CODE

$digits_needed = 6;
$random_number = ''; // set up a blank string
$count = 0;
while ($count < $digits_needed) {
  $random_digit = mt_rand(0, 9);

  $random_number .= $random_digit;
  $count++;
}

$code             = "CK" . $random_number;

?>
