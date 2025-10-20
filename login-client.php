<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM clients WHERE email = '$email'");
    if (mysqli_num_rows($query) > 0) {
        $client = mysqli_fetch_assoc($query);
        if ($password == $client['password']) {
            $_SESSION['client_id'] = $client['id'];
            $_SESSION['client_name'] = $client['name'];
            header('Location: index.php');
            exit();
        } else {
            $error = " Incorrect password.";
        }
    } else {
        $error = " Email not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Client Login - TechMall</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 25px;
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #333; font-weight: bold; }
        input {
            width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            width: 100%; padding: 10px;
            background: #2563eb; color: white; border: none; border-radius: 5px;
            cursor: pointer; font-size: 16px;
        }
        button:hover { background: #1d4ed8; }
        .error {
            background: #fee; color: red; text-align: center;
            padding: 10px; border-radius: 5px; margin-bottom: 15px;
        }
        a { color: #2563eb; text-decoration: none; display: block; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="box">
        <h2> Client Login</h2>

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

        <a href="signup.php">Don’t have an account? Sign up</a>
    </div>
</body>
</html>
