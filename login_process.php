<?php
session_start();
require_once ('db.php');

$username = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT * FROM useraccount WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);


if(!$row){
    echo "User not found.";
} else {
    if(!password_verify($password, $row['password'])){
        echo "Wrong password";
    } else {
        // $_SESSION['user_id'] = $row['id_user'];
        $_SESSION['username'] = $row['username'];
        header('location: dia.php');
    }

}


?>
