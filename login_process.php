<?php
session_start();
require_once ('db.php');

$username = $_POST['username'];
$password = $_POST['password'];

// Sanitize and validate user input
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
        header('location: index.php?error-password=Wrong Password&username=' . urlencode($username));
    } else {
        // Correct Password
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['user_id'];
        header('location: task_tracker.php');
    }
}
?>