<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/token.php");
require("../configs/validate.data.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verify user token and retrieve user ID
$userQuery = mysqli_query($connection, "SELECT * FROM users WHERE token='$token'") or die(mysqli_error($connection));
$user = mysqli_fetch_assoc($userQuery);

if (!$user) {
    $response = json_encode([
        'code' => 401,
        'status' => "Error",
        'message' => "Invalid token"
    ], TRUE);
    print($response);
    exit;
}

$userId = $user['user_id'];
$role   = $user['user_role'];

if($role=='Driver')
{

// Retrieve orders for the user

$ordersQuery = mysqli_query($connection, "SELECT * FROM orders WHERE customer_id='$userId' ORDER BY order_time DESC") or die(mysqli_error($connection));

}else{
  $ordersQuery = mysqli_query($connection, "SELECT * FROM orders ORDER BY order_time DESC") or die(mysqli_error($connection));  
}

$orders = [];

while ($order = mysqli_fetch_assoc($ordersQuery)) {
    $orderId = $order['order_id'];

    // Retrieve order items
    $orderItemsQuery = mysqli_query($connection, "SELECT products.product_id, products.product_name, products.product_price, products.product_image, order_products.quantity, order_products.total_price 
    FROM order_products 
    JOIN products ON order_products.product_id = products.product_id 
    WHERE order_products.order_id='$orderId'") or die(mysqli_error($connection));

    $orderItems = [];
    $productImage = "";
    while ($item = mysqli_fetch_assoc($orderItemsQuery)) {
        $item["product_image"] = "http://disscrounts.rw/" . $item["product_image"];
        $orderItems[] = $item;
        if (empty($productImage)) {
            $productImage = $item["product_image"]; // Get the first product image
        }
    }

    $order['items'] = $orderItems;
    // Rearrange the order array to include product_image below order_status
    $orderWithImage = [];
    foreach ($order as $key => $value) {
        $orderWithImage[$key] = $value;
        if ($key == 'order_status') {
            $orderWithImage['product_image'] = $productImage;
        }
    }

    $orders[] = $orderWithImage;
}

$responseArray = array(
    'code' => 200,
    'status' => "Success",
    'data' => $orders
);

$response = json_encode($responseArray, TRUE);
print($response);
?>
