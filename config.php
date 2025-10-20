<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'techmall';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed");
}
?>