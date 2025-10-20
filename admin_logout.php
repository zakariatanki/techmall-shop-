<?php
require_once 'config.php'; 


unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_id']);

session_destroy();

header("Location: admin_login.php");
exit();
?>
