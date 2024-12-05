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

$productId  = $data["product_id"];
$newQuantity = $data["quantity"];

if (!isset($productId, $newQuantity)) {
    $response = json_encode([
        'code' => 400,
        'status' => "Error",
        'message' => "Missing required parameters"
    ], TRUE);
    print($response);
    exit;
}

// Sanitize inputs
$productId = mysqli_real_escape_string($connection, $productId);
$newQuantity = (int)$newQuantity;

$query = mysqli_query($connection, "SELECT * FROM products WHERE product_id ='$productId'") or die(mysqli_error($connection));
$product = mysqli_fetch_assoc($query);

if (!$product) {
    $response = json_encode([
        'code' => 404,
        'status' => "Error",
        'message' => "Product not found"
    ], TRUE);
    print($response);
    exit;
}

$unitPrice = $product["product_price"];
$newTotal = $unitPrice * $newQuantity;

// Check if product is already in the cart
$checkCartQuery = mysqli_query($connection, "SELECT * FROM carts WHERE product_id ='$productId' AND customer_id='$userId'") or die(mysqli_error($connection));
$cartItem = mysqli_fetch_assoc($checkCartQuery);

if ($cartItem) {
    // Update the quantity and total
    $updateQuery = mysqli_query($connection, "UPDATE carts SET cart_qty='$newQuantity', cart_total='$newTotal' WHERE product_id='$productId' AND customer_id='$userId'") or die(mysqli_error($connection));
} else {
    $response = json_encode([
        'code' => 404,
        'status' => "Error",
        'message' => "Product not found in cart"
    ], TRUE);
    print($response);
    exit;
}

// Retrieve updated cart
$query = mysqli_query($connection, "SELECT products.product_id, products.product_name, products.product_price, products.product_image, carts.cart_qty, carts.cart_total 
FROM products, carts 
WHERE carts.product_id = products.product_id AND carts.customer_id = '$userId'") or die(mysqli_error($connection));

$cart = [];
$cartTotal = 0;
$numItems = 0;

while ($row = mysqli_fetch_assoc($query)) {
    $productId = $row['product_id'];
    $row["product_image"] = "http://disscrounts.rw/" . $row["product_image"];

    if (isset($cart[$productId])) {
        $cart[$productId]['cart_qty'] += $row['cart_qty'];
        $cart[$productId]['subtotal'] += $row['cart_total'];
    } else {
        $cart[$productId] = [
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'],
            'product_price' => $row['product_price'],
            'product_image' => $row["product_image"],
            'cart_qty' => $row['cart_qty'],
            'subtotal' => $row['cart_total']
        ];
    }

    $cartTotal += $row['cart_total'];
    $numItems++;
}

$responseArray = array(
    'code' => 200,
    'status' => "Success",
    'message' => "You have successfully updated the cart",
    'data' => array(
        'cart_items' => array_values($cart),
        'cart_total' => $cartTotal,
        'num_items' => $numItems
    )
);

$response = json_encode($responseArray, TRUE);
print($response);
?>
