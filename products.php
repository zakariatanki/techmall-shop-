<?php
require_once 'config.php';

//hadi dyal products management dyal admin 


$msg = "";

if (isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);
    }

    $query = "INSERT INTO products (name, description, price, stock, category_id, image)
              VALUES ('$name', '$description', '$price', '$stock', '$category_id', '$image')";
    if (mysqli_query($conn, $query)) {
        $msg = "✅ Product added successfully!";
    } else {
        $msg = "❌ Error adding product.";
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    $msg = "🗑️ Product deleted.";
}

$categories = mysqli_query($conn, "SELECT * FROM categories");
$products = mysqli_query($conn, "
    SELECT p.*, c.name AS category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Manage Products</title>
<style>
    body { font-family: Arial; background:#f8fafc; margin:0; padding:0; }
    header {
        background:#1e293b;
        color:white;
        padding:15px 30px;
        display:flex;
        justify-content:space-between;
        align-items:center;
    }
    header a {
        color:white;
        background:#2563eb;
        padding:8px 14px;
        border-radius:5px;
        text-decoration:none;
    }
    header a:hover { background:#1d4ed8; }
    .container { max-width:1100px; margin:30px auto; background:white; padding:30px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1); }
    h2 { color:#2563eb; margin-bottom:20px; }
    form input, form select, form textarea {
        width:100%;
        padding:10px;
        margin:8px 0;
        border:1px solid #ccc;
        border-radius:5px;
    }
    form button {
        background:#2563eb;
        color:white;
        border:none;
        padding:10px 20px;
        border-radius:5px;
        cursor:pointer;
    }
    form button:hover { background:#1d4ed8; }
    table {
        width:100%;
        border-collapse:collapse;
        margin-top:30px;
    }
    table, th, td { border:1px solid #ddd; }
    th { background:#2563eb; color:white; padding:10px; }
    td { padding:10px; text-align:center; }
    img { width:60px; height:60px; border-radius:5px; object-fit:cover; }
    .msg { color:#2563eb; font-weight:bold; text-align:center; margin-bottom:15px; }
</style>
</head>
<body>

<header>
    <h1>🛍️ Admin - Manage Products</h1>
    <a href="admin_logout.php">Logout</a>
</header>

<div class="container">
    <h2>Add New Product</h2>
    <?php if ($msg != ''): ?>
        <p class="msg"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price (DH)" required>
        <input type="number" name="stock" placeholder="Stock Quantity" required>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <h2 style="margin-top:40px;">All Products</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price (DH)</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        <?php while ($p = mysqli_fetch_assoc($products)): ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><img src="images/<?php echo $p['image']; ?>" alt=""></td>
            <td><?php echo $p['name']; ?></td>
            <td><?php echo $p['category_name']; ?></td>
            <td><?php echo $p['price']; ?></td>
            <td><?php echo $p['stock']; ?></td>
            <td>
                <a href="admin_edit_product.php?id=<?php echo $p['id']; ?>">✏️ Edit</a> | 
                <a href="?delete=<?php echo $p['id']; ?>" onclick="return confirm('Delete this product?')">🗑️ Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
