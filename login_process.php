<?php
session_start();
require_once ('db.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM account WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row){
    // User Not Found
    header('location: index.php?error-username=User not Found');
} else {
    if(!password_verify($password, $row['password'])){
        // Wrong Password
        header('location: index.php?error-password=Wrong Password');
    } else {
        // Correct Password
        $_SESSION['username'] = $row['username'];
        header('location: task_tracker.php');
    }
}
?>