<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/validate.data.php");

if (isset($_GET["customer_id"]) && isset($_GET["payment_method_id"]) && isset($_GET["order_notes"]) && isset($_GET["token"])) {

    $token              = validate($_GET["token"]);
    $customerId         = validate($_GET["customer_id"]);
    $paymentMethodId    = validate($_GET["payment_method_id"]);
    $orderNotes         = validate($_GET["order_notes"]);

    # CHECK TOKEN VALIDITY

    $query = mysqli_query($connection, "SELECT * FROM tokens WHERE token ='$token'");
    $count = mysqli_num_rows($query);

    if ($count == 1) {

        # UPDATE CART || CUSTOMER ID

        mysqli_query($connection, "UPDATE carts SET customer_id ='$customerId' WHERE session_id ='$token'") or die(mysqli_error($connection));

        #GENERATE TRACKING NUMBER

        function generateRandomString($length = 8)
        {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $orderTrackId   = "CK" . generateRandomString();

        # SAVE ORDER INFO

        if ($paymentMethodId == 3) {
            $status = "processing";
        } else {
            $status = 'pending';
        }

        mysqli_query($connection, "INSERT INTO `orders` (`order_id`, `customer_id`, `order_total`,`order_track_id`,`order_notes`, `order_time`, `payment_method_id`, `order_status`) 
    VALUES (NULL, '$customerId', '0','$orderTrackId','$orderNotes', current_timestamp(), '$paymentMethodId', '$status')") or die(mysqli_error($connection));

        $orderId = mysqli_insert_id($connection);

        # ORDER PRODUCTS 

        $query = mysqli_query($connection, "SELECT * FROM carts WHERE session_id ='$token'") or die(mysqli_error($connection));
        $orderTotal = 0;
        while ($data = mysqli_fetch_assoc($query)) {
            $productId = $data["product_id"];
            $orderTotal = $orderTotal + $data["cart_total"];
            $orderQty = $data["cart_qty"];

            mysqli_query($connection, "INSERT INTO `order_products` (`order_product_id`, `order_id`, `order_qty`,`product_id`) VALUES (NULL, '$orderId', '$orderQty','$productId')") or die(mysqli_error($connection));
        }

        # UPDATE ORDER

        mysqli_query($connection, "UPDATE orders SET order_total ='$orderTotal' WHERE order_id ='$orderId'") or die(mysqli_error($connection));

        #ORDER HISTORY

        mysqli_query($connection,"INSERT INTO `order_history` (`history_id`, `order_id`, `history_time`, `history_event`) VALUES (NULL, '$orderId', current_timestamp(), 'Created')");

        #DELETE CART & TOKEN

        mysqli_query($connection, "DELETE FROM carts WHERE session_id ='$token'");

        mysqli_query($connection, "DELETE FROM `tokens` WHERE `tokens`.`token` = '$token'");



        $query = mysqli_query($connection, "SELECT * FROM orders WHERE order_id ='$orderId'") or die(mysqli_error($connection));
        while ($data = mysqli_fetch_assoc($query)) {

            $order = $data;
        }


        $query = mysqli_query($connection, "SELECT * FROM order_products, products WHERE order_products.product_id = products.product_id AND order_products.order_id ='$orderId' ") or die(mysqli_error($connection));

        while ($data = mysqli_fetch_assoc($query)) {
            $products[] = $data;
        }

        $array = array(
            'code' => 200,
            'status' => "success",
            'message' => "Your order has been placed",
            'order_info' => $order,
            'order_products' => $products,

        );

        $response = json_encode($array, TRUE);
        print($response);
    } else {
        $array = array(
            'code' => 400,
            'status' => "Failed",
            'message' => "Your token is expired",
        );

        $response = json_encode($array, TRUE);
        print($response);
    }
} else {

    $array = array(
        'code' => 400,
        'status' => "Failed",
        'message' => "Invalid request",
    );

    $response = json_encode($array, TRUE);
    print($response);
}
