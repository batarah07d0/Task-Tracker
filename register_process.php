<?php
require_once ('db.php');

$username = $_POST['username'];
$password = $_POST['password'];

$en_pass = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO useraccount (username,password) VALUES(?,?)";

$result = $pdo->prepare($sql);
$result->execute([$username, $en_pass]);    

header('Location: index.php');


?>
