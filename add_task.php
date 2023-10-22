<?php
session_start();
include('db.php');

// if (!isset($_SESSION['task_id'])) {
//     header('location: task_tracker.php');
//     exit();
// }



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $progress = $_POST['progress'];
    $status = "Not Completed"; // Status default
    $time = new DateTime($_POST['time']); // Gunakan objek DateTime untuk memproses waktu
     // Format waktu ke dalam string sesuai dengan format TIMESTAMP
    $formattedTime = $time->format('Y-m-d H:i:s'); 


    $sql = "INSERT INTO task (judul, deskripsi, progress, status, time) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$judul, $deskripsi, $progress, $status, $formattedTime]);
 
}



header('location: task_tracker.php');
?>
