<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // Periksa apakah task_id valid (misalnya, numeric dan positif)
    if (is_numeric($task_id) && $task_id > 0) {
        // Perbarui status tugas menjadi 1 untuk menandai sebagai "Completed"
        $sql = "UPDATE task SET status = 1 WHERE task_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$task_id]);

        // Setel pesan sukses
        $_SESSION['update_success_message'] = 'Task marked as completed successfully.';
    }
}

// Redirect kembali ke halaman task_tracker.php
header('location: task_tracker.php');
?>