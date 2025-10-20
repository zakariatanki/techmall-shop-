<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);
$product = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT p.*, c.name as category_name 
    FROM products p 
    JOIN categories c ON p.category_id = c.id 
    WHERE p.id = $id
"));

if (!$product) {
    echo "<h2>Product not found.</h2>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $product['name']; ?> - TechMall</title>
<style>
    body { font-family: Arial; background:#f8fafc; margin:0; padding:0; }
    header {
        background:#2563eb;
        color:white;
        padding:15px 30px;
        display:flex;
        justify-content:space-between;
        align-items:center;
    }
    header a {
        color:white;
        text-decoration:none;
        margin-left:15px;
        font-weight:bold;
    }
    .container {
        max-width:1000px;
        margin:40px auto;
        background:white;
        padding:30px;
        border-radius:10px;
        box-shadow:0 2px 10px rgba(0,0,0,0.1);
        display:flex;
        gap:30px;
    }
    img {
        max-width:400px;
        height:auto;
        border-radius:10px;
    }
    .info h2 { color:#2563eb; margin-bottom:15px; }
    .info p { color:#444; line-height:1.6; margin-bottom:10px; }
    .price {
        font-size:22px;
        font-weight:bold;
        color:#111;
        margin:15px 0;
    }
    .qty-control {
        display:flex;
        align-items:center;
        margin-bottom:20px;
    }
    .qty-control button {
        background:#2563eb;
        color:white;
        border:none;
        width:35px;
        height:35px;
        font-size:18px;
        border-radius:5px;
        cursor:pointer;
    }
    .qty-control input {
        width:60px;
        text-align:center;
        font-size:16px;
        margin:0 10px;
        padding:5px;
    }
    .add-btn {
        background:#2563eb;
        color:white;
        border:none;
        padding:10px 20px;
        border-radius:5px;
        cursor:pointer;
        font-size:16px;
    }
    .add-btn:hover { background:#1d4ed8; }
    footer {
        background:#1e293b;
        color:white;
        text-align:center;
        padding:20px;
        margin-top:50px;
    }
</style>
<script>
function changeQty(amount) {
    const input = document.getElementById('qty');
    let value = parseInt(input.value);
    const max = parseInt(input.getAttribute('max'));
    value += amount;
    if (value < 1) value = 1;
    if (value > max) value = max;
    input.value = value;
}
</script>
</head>
<body>

<header>
    <h1 style="margin:0;">🛍️ TechMall</h1>
    <a href="index.php">← Back to Home</a>
</header>

<div class="container">
    <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    <div class="info">
        <h2><?php echo $product['name']; ?></h2>
        <p><strong>Category:</strong> <?php echo $product['category_name']; ?></p>
        <p><?php echo $product['description']; ?></p>
        <p class="price"><?php echo $product['price']; ?> DH</p>
        <p><strong>In stock:</strong> <?php echo $product['stock']; ?></p>

        <form method="POST" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            
            <div class="qty-control">
                <button type="button" onclick="changeQty(-1)">−</button>
                <input type="number" id="qty" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" readonly>
                <button type="button" onclick="changeQty(1)">+</button>
            </div>

            <button type="submit" name="add_to_cart" class="add-btn">Add to Cart 🛒</button>
        </form>
    </div>
</div>

<footer>
    <p>📍 123 Tech Street, Casablanca | 📧 support@techmall.com</p>
    <p>© 2025 TechMall. All rights reserved.</p>
</footer>

</body>
</html>
