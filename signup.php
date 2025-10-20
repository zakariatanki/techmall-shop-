<?php
require_once 'config.php';

$msg = '';

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($name == '' || $email == '' || $password == '') {
        $msg = "All fields are required.";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM clients WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $msg = "Email already exists. Try logging in.";
        } else {
            $sql = "INSERT INTO clients (name, email, password) VALUES ('$name', '$email', '$password')";
            if (mysqli_query($conn, $sql)) {
                header("Location: login.php?success=1");
                exit();
            } else {
                $msg = "Error: Could not register.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Client Signup - TechMall</title>
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
    input[type="text"], input[type="email"], input[type="password"] {
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
    p { margin-top:10px; }
    a { color:#2563eb; text-decoration:none; }
    a:hover { text-decoration:underline; }
    .error { color:red; font-weight:bold; margin-top:10px; }
</style>
</head>
<body>

<div class="container">
    <h2>Create Your Account</h2>
    <?php if ($msg != ''): ?>
        <p class="error"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>
