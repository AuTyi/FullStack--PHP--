<?php
session_start();
$conn = new mysqli('localhost','root','root','blog');
$username = $_SESSION['username'];
$result = $conn->query("SELECT `id` FROM `users` WHERE `email`='$username'"); //get users from db

$row = $result->fetch_assoc();
$user_id = $row['id'];

$result = $conn->query("DELETE FROM `tokens` WHERE `user_id`='$user_id'");//delete rememberme 
unset($_SESSION['username']);
session_destroy();
header("Location: login.php"); //back to login page
?>