<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

$query = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id =0 AND category_status!='deactivated' ") or die(mysqli_error($connection));
while ($data = mysqli_fetch_assoc($query)) {

    $categoryId = $data["category_id"];

    if ($data["category_image"] == "") {
        $data["category_image"] = "http://disscrounts.rw/catalog/categories/category.png";
    } else {
        $data["category_image"] = "http://disscrounts.rw/" . $data["category_image"];
    }
    $data["sub_categories"] = [];

    $categories[] = $data;


    // $count = mysqli_num_rows($subSubQuery);
    // if($count ==0)
    // {
    //     $data["sub_categories"] = null;
    // }
    // $categories[] = $data;

}

$array = array(
    'code' => 200,
    'status' => "success",
    'message' => "All Categories",
    'data' => $categories
);

$response = json_encode($array, TRUE);
print($response);
