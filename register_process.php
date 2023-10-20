<?php
require_once ('db.php');

$username = $_POST['username'];
$password = $_POST['password'];

$en_pass = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO account (username, password) VALUES(?,?)";

$result = $pdo->prepare($sql);
$result->execute([$username, $en_pass]);    

header('location: index.php');
?>