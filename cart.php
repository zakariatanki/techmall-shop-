<?php
require_once 'config.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id"));
        $_SESSION['cart'][$product_id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => 1
        ];
    }
    header("Location: cart.php");
    exit();
}

if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Cart - TechMall</title>
<style>
    body { font-family: Arial; background:#f8fafc; padding:20px; }
    table {
        width:100%;
        border-collapse:collapse;
        background:white;
        box-shadow:0 2px 10px rgba(0,0,0,0.1);
    }
    th, td {
        padding:15px;
        text-align:center;
        border-bottom:1px solid #eee;
    }
    th { background:#2563eb; color:white; }
    .btn {
        background:#2563eb;
        color:white;
        padding:8px 12px;
        border:none;
        border-radius:5px;
        text-decoration:none;
    }
    .btn:hover { background:#1d4ed8; }
    footer {
        background:#1e293b;
        color:white;
        text-align:center;
        padding:15px;
        margin-top:40px;
    }
</style>
</head>
<body>

<h1>🛒 My Cart</h1>
<a href="index.php" class="btn">⬅ Back to Shop</a>
<br><br>

<?php if (empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Product</th>
            <th>Price (DH)</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php foreach ($_SESSION['cart'] as $id => $item): 
            $line_total = $item['price'] * $item['quantity'];
            $total += $line_total;
        ?>
        <tr>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['price']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo $line_total; ?></td>
            <td><a href="cart.php?remove=<?php echo $id; ?>" class="btn">Remove</a></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="3" style="text-align:right;">Total:</th>
            <th><?php echo $total; ?> DH</th>
            <th></th>
        </tr>
    </table>
<?php endif; ?>

<footer>
    <p>© 2025 TechMall | Casablanca, Morocco</p>
</footer>

</body>
</html>
