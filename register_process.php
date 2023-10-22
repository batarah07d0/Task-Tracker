<?php
require_once ('db.php');

// Sanitize and validate user input
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


// Encrypt Password
$en_pass = password_hash($password, PASSWORD_BCRYPT);

// SQL Query
$sql = "INSERT INTO account (username, password) VALUES(?,?)";

// Execute SQL Query
$result = $pdo->prepare($sql);
$result->execute([$username, $en_pass]);    

header('location: index.php');
?>


$username = $_POST['username'];
$password = $_POST['password'];

$en_pass = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO useraccount (username,password) VALUES(?,?)";

$result = $pdo->prepare($sql);
$result->execute([$username, $en_pass]);    

header('Location: index.php');


?>

