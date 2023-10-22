<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $progress = $_POST['progress'];
    $time = new DateTime($_POST['time']);
    $formattedTime = $time->format('Y-m-d H:i:s');

    $sql = "UPDATE task SET judul = ?, deskripsi = ?, progress = ?, time = ? WHERE task_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$judul, $deskripsi, $progress, $formattedTime,$task_id]);

    // Redirect kembali ke halaman task_tracker.php setelah pembaruan
    header('location: task_tracker.php');
} else {
    if (isset($_GET['task_id'])) {
        $task_id = $_GET['task_id'];

        // Periksa apakah task_id valid (misalnya, numeric dan positif)
        if (is_numeric($task_id) && $task_id > 0) {
            $sql = "SELECT * FROM task WHERE task_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$task_id]);
            $editTask = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($editTask) {
                // Tampilkan formulir khusus untuk pembaruan
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="task_tracker.css">
                    <title>Update Task</title>
                </head>
                <body>
                    <div class="container">
                        <h1>Update Task</h1>
                        <form action="edit_task.php" method="post">
                            <input type="hidden" name="task_id" value="<?= $editTask['task_id'] ?>">
                            <input type="text" name="judul" value="<?= $editTask['judul'] ?>" placeholder="Task title" required>
                            <input type="text" name="deskripsi" value="<?= $editTask['deskripsi'] ?>" placeholder="Task description">
                            <input type="datetime-local" name="time" value="<?= date('Y-m-d\TH:i', strtotime($editTask['time'])) ?>">
                            <select name="progress">
                                <option value="Not yet started"<?= ($editTask['progress'] === 'Not yet started') ? ' selected' : '' ?>>Not yet started</option>
                                <option value="In progress"<?= ($editTask['progress'] === 'In progress') ? ' selected' : '' ?>>In progress</option>
                                <option value="Waiting on"<?= ($editTask['progress'] === 'Waiting on') ? ' selected' : '' ?>>Waiting on</option>
                            </select>
                            <button type="submit">Update Task</button>
                        </form>
                    </div>
                </body>
                </html>
                <?php
            } else {
                // Task tidak ditemukan
                header('location: task_tracker.php');
            }
        } else {
            // Task ID tidak valid
            header('location: task_tracker.php');
        }
    } else {
        // Parameter task_id tidak ada
        header('location: task_tracker.php');
    }
}
?>
