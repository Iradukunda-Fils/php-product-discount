<?php

header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

if (isset($_GET["product_id"])) {

    $productId = $_GET["product_id"];

    $query = mysqli_query($connection, "SELECT * FROM products WHERE product_id ='$productId'") or die(mysqli_error($connection));

    $product = mysqli_fetch_assoc($query);
    if ($product) {
        $product["product_image"] = "http://disscrounts.rw/" . $product["product_image"];

        // RELATED PRODUCTS
        $relatedQuery = mysqli_query($connection, "SELECT * FROM products ORDER BY rand() LIMIT 8") or die(mysqli_error($connection));

        $related = [];
        while ($relatedData = mysqli_fetch_assoc($relatedQuery)) {
            $relatedData["product_image"] = "http://disscrounts.rw/" . $relatedData["product_image"];
            $related[] = $relatedData;
        }

        $product["related_products"] = $related;

        // UPDATE VIEWS
        $productViews = $product["product_views"] + 1;
        mysqli_query($connection, "UPDATE products SET product_views = '$productViews' WHERE product_id ='$productId'") or die(mysqli_error($connection));

        $array = array(
            'code' => 200,
            'status' => "success",
            'message' => "Product details",
            'data' => $product
        );

        $response = json_encode($array, TRUE);
        print($response);
    } else {
        // Handle case where product_id does not exist
        $array = array(
            'code' => 404,
            'status' => "error",
            'message' => "Product not found"
        );

        $response = json_encode($array, TRUE);
        print($response);
    }
}
?>
