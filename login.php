<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM admins WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        if ($password == $admin['password']) { 
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Wrong password!';
        }
    } else {
        $error = 'Email not found!';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - TechMall</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #1d4ed8;
        }
        .error {
            background: #fee;
            color: red;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2> Admin Login</h2>
        
        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
        
        <div class="link">
            <a href="login-client.php">Client Login</a>
        </div>
    </div>
</body>
</html>
