<?php
require_once 'config.php';


$categories = mysqli_query($conn, "SELECT * FROM categories");


$where = "1";
if (!empty($_GET['category'])) {
    $cat = intval($_GET['category']);
    $where .= " AND category_id = $cat";
}
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
}

$products = mysqli_query($conn, "SELECT * FROM products WHERE $where ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>TechMall - Home</title>
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
    header h1 { margin:0; font-size:24px; }
    header .actions a {
        color:white;
        text-decoration:none;
        margin-left:15px;
        background:#1e40af;
        padding:8px 14px;
        border-radius:5px;
    }
    header .actions a:hover { background:#1d4ed8; }
    .search-bar {
        background:white;
        padding:15px 30px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        box-shadow:0 2px 4px rgba(0,0,0,0.1);
    }
    .search-bar form { display:flex; gap:10px; align-items:center; }
    .search-bar input[type="text"] {
        padding:8px;
        width:250px;
        border:1px solid #ccc;
        border-radius:5px;
    }
    .search-bar select {
        padding:8px;
        border:1px solid #ccc;
        border-radius:5px;
    }
    .search-bar button {
        background:#2563eb;
        color:white;
        border:none;
        padding:8px 14px;
        border-radius:5px;
        cursor:pointer;
    }
    .products {
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));
        gap:20px;
        padding:30px;
    }
    .card {
        background:white;
        border-radius:10px;
        box-shadow:0 2px 8px rgba(0,0,0,0.1);
        padding:15px;
        text-align:center;
        transition:transform 0.2s;
    }
    .card:hover { transform:translateY(-5px); }
    .card img {
        width:100%;
        height:200px;
        object-fit:cover;
        border-radius:8px;
    }
    .card h3 { margin:10px 0 5px; color:#111; }
    .card p { color:#444; margin-bottom:10px; }
    .price { font-weight:bold; color:#2563eb; margin-bottom:10px; }
    .card a, .card button {
        background:#2563eb;
        color:white;
        border:none;
        padding:8px 12px;
        border-radius:5px;
        text-decoration:none;
        cursor:pointer;
    }
    .card a:hover, .card button:hover { background:#1d4ed8; }
    footer {
        background:#1e293b;
        color:white;
        text-align:center;
        padding:20px;
        margin-top:40px;
    }
</style>
</head>
<body>

<header>
    <h1>🛍️ TechMall</h1>
    <div class="actions">
        <a href="cart.php">🛒 Cart</a>
        <?php if (!isset($_SESSION['client_id'])): ?>
            <a href="login.php">Login / Signup</a>
        <?php else: ?>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </div>
</header>

<div class="search-bar">
    <form method="GET">
        <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <select name="category">
            <option value="">All Categories</option>
            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                <option value="<?php echo $cat['id']; ?>" <?php if(isset($_GET['category']) && $_GET['category']==$cat['id']) echo 'selected'; ?>>
                    <?php echo $cat['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Search </button>
    </form>
</div>

<div class="products">
    <?php if (mysqli_num_rows($products) > 0): ?>
        <?php while($p = mysqli_fetch_assoc($products)): ?>
            <div class="card">
                <img src="images/<?php echo $p['image']; ?>" alt="<?php echo $p['name']; ?>">
                <h3><?php echo $p['name']; ?></h3>
                <p><?php echo substr($p['description'], 0, 60) . '...'; ?></p>
                <p class="price"><?php echo $p['price']; ?> DH</p>
                <a href="product.php?id=<?php echo $p['id']; ?>">View Details</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">No products found.</p>
    <?php endif; ?>
</div>

<footer>
    <p>📍 123 Tech Street, Casablanca | 📧 support@techmall.com</p>
    <p>© 2025 TechMall. All rights reserved.</p>
</footer>

</body>
</html>
