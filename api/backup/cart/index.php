<?php
header('Content-Type: application/json');
require("../configs/connection.php");
require("../configs/token.php");
require("../configs/validate.data.php");


$cart = [];
$cartTotal = 0;
$numItems = 0;

$query = mysqli_query($connection, "SELECT products.product_id, products.product_name, products.product_price,products.product_image, carts.cart_qty, carts.cart_total 
FROM products, carts 
WHERE carts.product_id = products.product_id AND carts.customer_id = '$userId'") or die(mysqli_error($connection));


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
    'message' => "Your cart products",
    'data' => array(
        'cart_items' => array_values($cart),
        'cart_total' => $cartTotal,
        'num_items' => $numItems
    )
);

$response = json_encode($responseArray, TRUE);
print($response);
?>