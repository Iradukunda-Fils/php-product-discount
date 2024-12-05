<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

if (isset($_GET["customer_id"])) {

    $customerId = validate($_GET["customer_id"]);

    $query = mysqli_query($connection, "SELECT * FROM orders WHERE customer_id ='$customerId' ORDER BY order_id DESC") or die(mysqli_error($connection));
    while ($data = mysqli_fetch_assoc($query)) {

        #ORDER NAME AND IMAGE
        $orderId = $data["order_id"];

        $orderQuery = mysqli_query($connection, "SELECT * FROM order_products, products WHERE order_products.product_id = products.product_id AND order_products.order_id ='$orderId' ") or die(mysqli_error($connection));
        while ($order = mysqli_fetch_assoc($orderQuery)) {

            $count = mysqli_num_rows($orderQuery);

            $data["order_name"] = $order["product_name"];

            if ($count > 1) {
                $data["order_name"] = $data["order_name"] . $order["product_name"] . " ,";
            }

            $data["order_image"] = "http://disscrounts.rw/" . $order["product_image"];
        }


        
        $orders[] = $data;
    }

    $array = array(
        'code' => 200,
        'status' => "success",
        'message' => "My Orders",
        'data' => $orders,

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
