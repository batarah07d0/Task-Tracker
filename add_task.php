<?php
session_start();
include('db.php');

date_default_timezone_set("Asia/Jakarta");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $progress = $_POST['progress'];
    $status = "Not Completed"; // Status default
    $time = date('Y-m-d H:i:s'); // Format waktu ke dalam string sesuai dengan format TIMESTAMP

    $sql = "INSERT INTO task (user_id, judul, deskripsi, progress, status, time) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $judul, $deskripsi, $progress, $status, $time]);

    // Setel format buat di tampilan web doang biar keren urutan di Penangggalan Indonesia
    $formattedTime = date('d-m-Y H:i:s', strtotime($time));
}

header('location: task_tracker.php');
?>