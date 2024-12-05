<?php

header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

$products = array();
$subcategories = array();

if (isset($_GET["category_id"])) {
    $categoryId = $_GET["category_id"];

    // Fetch products for the given category
    $query = mysqli_query($connection, "SELECT * FROM products, products_categories WHERE products.product_id = products_categories.product_id AND products_categories.category_id ='$categoryId' ORDER BY id DESC") or die(mysqli_error($connection));

    while ($data = mysqli_fetch_assoc($query)) {
        $data["product_image"] = "http://disscrounts.rw/" . $data["product_image"];
        $products[] = $data;
    }

    // Fetch subcategories for the given category
    $subcategoriesQuery = mysqli_query($connection, "SELECT * FROM categories WHERE parent_id ='$categoryId' ORDER BY category_id DESC") or die(mysqli_error($connection));

    while ($cdata = mysqli_fetch_assoc($subcategoriesQuery)) {
        if ($cdata["category_image"] == "") {
            $cdata["category_image"] = "http://disscrounts.rw/catalog/categories/category.png";
        } else {
            $cdata["category_image"] = "http://disscrounts.rw/" . $cdata["category_image"];
        }
        $cdata["sub_categories"] = [];

        // Fetch products for each subcategory
        $subcategoryProductsQuery = mysqli_query($connection, "SELECT * FROM products, products_categories WHERE products.product_id = products_categories.product_id AND products_categories.category_id ='".$cdata['category_id']."' ORDER BY id DESC") or die(mysqli_error($connection));

        while ($sdata = mysqli_fetch_assoc($subcategoryProductsQuery)) {
            $sdata["product_image"] = "http://disscrounts.rw/" . $sdata["product_image"];
            $products[] = $sdata;  // Add subcategory products to main products array
        }

        $subcategories[] = $cdata;
    }

    // Construct the response
    $array = array(
        'code' => 200,
        'status' => "success",
        'message' => "category products",
        'subcategories' => $subcategories,
        'data' => $products,
    );

    $response = json_encode($array, TRUE);
    print($response);
} else {
    $array = array(
        'code' => 400,
        'status' => "error",
        'message' => "Category ID is required"
    );
    $response = json_encode($array, TRUE);
    print($response);
}

?>
