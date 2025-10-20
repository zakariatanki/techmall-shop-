<?php
require_once 'config.php';

if (!isset($_POST['add_to_cart'])) {
    header("Location: index.php");
    exit();
}

$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);

$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;

    if ($_SESSION['cart'][$product_id]['quantity'] > $product['stock']) {
        $_SESSION['cart'][$product_id]['quantity'] = $product['stock'];
    }
} else {
    $_SESSION['cart'][$product_id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => min($quantity, $product['stock']),
        'image' => $product['image'],
        'stock' => $product['stock']
    ];
}

header("Location: index.php");
exit();
?>
