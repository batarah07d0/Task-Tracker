<?php
require_once ('db.php');

$username = $_POST['username'];
$password = $_POST['password'];

// Encrypt Password
$en_pass = password_hash($password, PASSWORD_BCRYPT);

// SQL Query
$sql = "INSERT INTO account (username, password) VALUES(?,?)";

// Execute SQL Query
$result = $pdo->prepare($sql);
$result->execute([$username, $en_pass]);    

header('location: index.php');
?>