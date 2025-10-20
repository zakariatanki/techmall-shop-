<?php
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];
$total_clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM clients"))['count'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
$total_categories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM categories"))['count'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - TechMall</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background-color: white; }
        
        header {
            background: blue;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
        }
        
        .nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 15px;
            border-radius: 5px;
        }
        
        .nav a:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        h1 {
            margin-bottom: 30px;
            color: #333;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-card h3 {
            color: #666666ff;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .quick-links {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .link-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: transform 0.3s;
        }
        
        .link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .link-card .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .stats, .quick-links {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h2>🛒 TechMall Admin</h2>
        </div>
        <div class="nav">
            <span>Welcome, <?php echo $_SESSION['admin_name']; ?></span>
            <a href="dashboard.php">Dashboard</a>
            <a href="categories.php">Categories</a>
            <a href="products.php">Products</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>
    
    <div class="container">
        <h1>Dashboard</h1>
        
        <div class="stats">
            <div class="stat-card">
                <h3>Total Products</h3>
                <div class="number"><?php echo $total_products; ?></div>
            </div>
            
            <div class="stat-card">
                <h3>Total Clients</h3>
                <div class="number"><?php echo $total_clients; ?></div>
            </div>
            
            <div class="stat-card">
                <h3>Total Orders</h3>
                <div class="number"><?php echo $total_orders; ?></div>
            </div>
            
            <div class="stat-card">
                <h3>Categories</h3>
                <div class="number"><?php echo $total_categories; ?></div>
            </div>
        </div>
        
        <h2 style="margin-bottom: 20px;">Quick Actions</h2>
        
        <div class="quick-links">
            <a href="categories.php" class="link-card">
                <div class="icon">📁</div>
                <h3>Manage Categories</h3>
                <p>Add, Edit, Delete Categories</p>
            </a>
            
            <a href="products.php" class="link-card">
                <div class="icon">📦</div>
                <h3>Manage Products</h3>
                <p>Add, Edit, Delete Products</p>
            </a>
            
            <a href="index.php" class="link-card">
                <div class="icon">🛍️</div>
                <h3>View Shop</h3>
                <p>See customer view</p>
            </a>
        </div>
    </div>
</body>
</html>