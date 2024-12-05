<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

if (isset($_GET["order_id"])) {

    $orderId = validate($_GET["order_id"]);

    $query = mysqli_query($connection, "SELECT * FROM orders , payment_methods WHERE order_id ='$orderId' AND payment_methods.payment_method_id = `orders`.`payment_method_id`") or die(mysqli_error($connection));
    while ($data = mysqli_fetch_assoc($query)) {

        $order = $data;
    }

    # PRODUCTS

    $query = mysqli_query($connection, "SELECT * FROM order_products, products WHERE order_products.product_id = products.product_id AND order_products.order_id ='$orderId' ") or die(mysqli_error($connection));

    while ($data = mysqli_fetch_assoc($query)) {
        $data["product_image"] = "http://disscrounts.rw/" . $data["product_image"];
        $products[] = $data;
    }

    #HISTORY


    $query = mysqli_query($connection, "SELECT * FROM order_history WHERE order_id ='$orderId' ") or die(mysqli_error($connection));

    while ($data = mysqli_fetch_assoc($query)) {
        $history[] = $data;
    }


    $array = array(
        'code' => 200,
        'status' => "success",
        'message' => "Order Info",
        'order_info' => $order,
        'order_products' => $products,
        'order_history' => $history,

    );

    $response = json_encode($array, TRUE);
    print($response);
} else {

    $array = array(
        'code' => 400,
        'status' => "Failed",
        'message' => "Invalid request",
    );

    $response = json_encode($array, TRUE);
    print($response);
}
