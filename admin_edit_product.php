<?php
require_once 'config.php';


if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}


if (!isset($_GET['id'])) {
    header("Location: admin_manage_products.php");
    exit();
}

$id = intval($_GET['id']);


$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found");
}

$msg = '';


if (isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $description = trim($_POST['description']);
    $stock = intval($_POST['stock']);

 
    $image = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "images/$image");
    }

 
    $update_query = "UPDATE products SET 
                        name='$name',
                        price=$price,
                        category_id=$category_id,
                        description='$description',
                        stock=$stock,
                        image='$image'
                     WHERE id=$id";

    if (mysqli_query($conn, $update_query)) {
        $msg = "✅ Product updated successfully!";
        $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        $product = mysqli_fetch_assoc($result);
    } else {
        $msg = "Error updating product: " . mysqli_error($conn);
    }
}


$categories = mysqli_query($conn, "SELECT * FROM categories");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Product - TechMall Admin</title>
<style>
body { font-family: Arial; background:#f5f5f5; margin:0; padding:0; }
.container { max-width:600px; margin:50px auto; background:white; padding:20px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1); }
h2 { color:#2563eb; margin-bottom:20px; }
input, select, textarea { width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:5px; }
button { background:#2563eb; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; }
button:hover { background:#1d4ed8; }
.success { background:#d1fae5; color:green; padding:10px; border-radius:5px; margin-bottom:15px; }
</style>
</head>
<body>

<div class="container">
    <h2>Edit Product</h2>

    <?php if($msg != ''): ?>
        <div class="success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>

        <label>Category:</label>
        <select name="category_id" required>
            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                <option value="<?php echo $cat['id']; ?>" <?php if($cat['id'] == $product['category_id']) echo 'selected'; ?>>
                    <?php echo $cat['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Description:</label>
        <textarea name="description" rows="4" required><?php echo $product['description']; ?></textarea>

        <label>Stock:</label>
        <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>

        <label>Image (optional):</label>
        <input type="file" name="image">

        <button type="submit" name="update">Update Product</button>
    </form>

    <p><a href="products.php">Back to Products</a></p>
</div>

</body>
</html>
