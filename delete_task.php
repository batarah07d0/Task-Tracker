<?php
session_start();
include('db.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    
    // Periksa apakah task_id valid (misalnya, numeric dan positif)
    if (!is_numeric($task_id) || $task_id <= 0) {
        header('location: task_tracker.php');
        exit();
    }

    $sql = "DELETE FROM task WHERE task_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$task_id]);

    // Redirect atau lakukan tindakan lain setelah berhasil menghapus data.
    header('location: task_tracker.php');
} else {
    header('location: task_tracker.php');
}




?>
