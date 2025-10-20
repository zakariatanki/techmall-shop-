<?php
require_once 'config.php';


$msg = '';

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == '' || $password == '') {
        $msg = "All fields are required.";
    } else {
        $query = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $admin = mysqli_fetch_assoc($result);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_id'] = $admin['id'];

            header("Location: products.php");
            exit();
        } else {
            $msg = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login - TechMall</title>
<style>
    body { font-family: Arial; background:#f8fafc; margin:0; padding:0; }
    .container {
        max-width:400px;
        margin:100px auto;
        background:white;
        padding:30px;
        border-radius:10px;
        box-shadow:0 2px 8px rgba(0,0,0,0.1);
        text-align:center;
    }
    h2 { color:#2563eb; margin-bottom:20px; }
    input[type="email"], input[type="password"] {
        width:100%;
        padding:10px;
        margin:8px 0;
        border:1px solid #ccc;
        border-radius:5px;
    }
    button {
        background:#2563eb;
        color:white;
        border:none;
        padding:10px 20px;
        border-radius:5px;
        cursor:pointer;
        width:100%;
    }
    button:hover { background:#1d4ed8; }
    .error { color:red; font-weight:bold; margin-top:10px; }
</style>
</head>
<body>

<div class="container">
    <h2>Admin Login</h2>

    <?php if ($msg != ''): ?>
        <p class="error"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>
