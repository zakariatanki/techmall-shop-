<?php
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    $sql = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";
    mysqli_query($conn, $sql);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    header('Location: categories.php');
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    $sql = "UPDATE categories SET name='$name', description='$description' WHERE id=$id";
    mysqli_query($conn, $sql);
}

$categories = mysqli_query($conn, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Categories - TechMall</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: white; }
        
        header {
            background: #1653d8ff;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
        }
        
        .nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .btn {
            padding: 10px 20px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        table {
            width: 100%;
            background: white;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background: #f9fafb;
            font-weight: bold;
        }
        
        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .edit-btn {
            background: #3b82f6;
            color: white;
        }
        
        .delete-btn {
            background: #ee2a2aff;
            color: white;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }
        
        .modal.active {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h2>🛒 TechMall Admin</h2>
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="categories.php">Categories</a>
            <a href="products.php">Products</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>
    
    <div class="container">
        <h1>Categories Management</h1>
        
        <button class="btn" onclick="openModal()">+ Add Category</button>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
            <tr>
                <td><?php echo $cat['id']; ?></td>
                <td><?php echo $cat['name']; ?></td>
                <td><?php echo $cat['description']; ?></td>
                <td>
                    <button class="action-btn edit-btn" onclick='editCategory(<?php echo json_encode($cat); ?>)'>Edit</button>
                    <button class="action-btn delete-btn" onclick="if(confirm('Delete?')) location.href='categories.php?delete=<?php echo $cat['id']; ?>'">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    
    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <h2>Add Category</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" rows="3"></textarea>
                </div>
                <button type="submit" name="add" class="btn">Add</button>
                <button type="button" onclick="closeModal()" style="background: #6b7280; margin-left: 10px;" class="btn">Cancel</button>
            </form>
        </div>
    </div>
    
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Edit Category</h2>
            <form method="POST">
                <input type="hidden" name="id" id="editId">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" id="editDesc" rows="3"></textarea>
                </div>
                <button type="submit" name="edit" class="btn">Update</button>
                <button type="button" onclick="closeEditModal()" style="background: #6b7280; margin-left: 10px;" class="btn">Cancel</button>
            </form>
        </div>
    </div>
    
    <script>
        function openModal() {
            document.getElementById('addModal').classList.add('active');
        }
        
        function closeModal() {
            document.getElementById('addModal').classList.remove('active');
        }
        
        function editCategory(cat) {
            document.getElementById('editId').value = cat.id;
            document.getElementById('editName').value = cat.name;
            document.getElementById('editDesc').value = cat.description;
            document.getElementById('editModal').classList.add('active');
        }
        
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }
    </script>
</body>
</html>