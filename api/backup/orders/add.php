<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/token.php");
require("../configs/validate.data.php");

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data === null) {
    $response = json_encode([
        'code' => 400,
        'status' => "Error",
        'message' => "Invalid JSON data"
    ], TRUE);
    print($response);
    exit;
}

$address  = $data["address"];
$notes    = $data["notes"];

$orderNo  = "MRT".rand(0000,9999);

// Retrieve cart items and calculate total
$cartQuery = mysqli_query($connection, "SELECT * FROM carts WHERE customer_id='$userId'") or die(mysqli_error($connection));
$cartTotal = 0;
$cartItems = [];

while ($row = mysqli_fetch_assoc($cartQuery)) {
    $cartTotal += intval($row['cart_total']);
    $cartItems[] = $row;
}

if (empty($cartItems)) {
    $response = json_encode([
        'code' => 400,
        'status' => "Error",
        'message' => "Cart is empty"
    ], TRUE);
    print($response);
    exit;
}

// Insert order
$orderQuery = mysqli_query($connection,"INSERT INTO `orders` (`order_id`, `customer_id`, `payment_method_id`, `order_track_id`, `order_total`, `order_notes`, `delivery_address`, `order_time`, `order_updated_time`, `order_status`) 
VALUES (NULL, '$userId', '1', '$orderNo', $cartTotal, '$notes', '$address', current_timestamp(), current_timestamp(), 'pending')") or die(mysqli_error($connection));

// Get the inserted order ID
$orderId = mysqli_insert_id($connection);

// Insert order items
foreach ($cartItems as $item) {
    $productId = $item['product_id'];
    $quantity = $item['cart_qty'];
    $total = intval($item['cart_total']);

    $orderItemQuery = mysqli_query($connection, "INSERT INTO `order_products` (`order_product_id`, `order_id`, `product_id`, `quantity`, `total_price`) 
    VALUES (NULL, '$orderId', '$productId', '$quantity', $total)") or die(mysqli_error($connection));
}

// Clear the cart
$clearCartQuery = mysqli_query($connection, "DELETE FROM carts WHERE customer_id='$userId'") or die(mysqli_error($connection));

// Retrieve order details
$orderDetailsQuery = mysqli_query($connection, "SELECT * FROM orders WHERE order_id='$orderId'") or die(mysqli_error($connection));
$orderDetails = mysqli_fetch_assoc($orderDetailsQuery);

// Retrieve order items
$orderItemsQuery = mysqli_query($connection, "SELECT products.product_id, products.product_name, products.product_price, products.product_image, order_products.quantity, order_products.total_price 
FROM order_products 
JOIN products ON order_products.product_id = products.product_id 
WHERE order_products.order_id='$orderId'") or die(mysqli_error($connection));

$orderItems = [];
while ($row = mysqli_fetch_assoc($orderItemsQuery)) {
    $row["product_image"] = "http://disscrounts.rw/" . $row["product_image"];
    $orderItems[] = $row;
}

$responseArray = array(
    'code' => 200,
    'status' => "Success",
    'message' => "Thank you for placing order with us, proceed to payment to confirm your order",
    'data' => array(
        'order_details' => $orderDetails,
        'order_items' => $orderItems
    )
);

$response = json_encode($responseArray, TRUE);
print($response);
?>
