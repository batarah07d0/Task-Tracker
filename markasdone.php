<?php
session_start();
include('db.php');


    $task_id = $_GET['task_id'];

        $sql = "UPDATE task SET status = 1 WHERE task_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$task_id]);

// Redirect kembali ke halaman task_tracker.php
header('location: task_tracker.php');
?>