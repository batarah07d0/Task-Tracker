<?php
session_start();
include('db.php');

// if (!isset($_SESSION['user_id'])) {
//     header('location: index.php');
//     exit();
// }

// $user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];



// Ambil daftar tugas dari database
$sql = "SELECT * FROM task";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="task_tracker.css">
    <title>To-Do List</title>
</head>
<body>
    <div class="container">
    <h1>Welcome, <?= $username ?>!</h1>
        <h1>To-Do List</h1>
        <form action="add_task.php" method="post">
            <input type="text" name="judul" placeholder="Task title" required>
            <input type="text" name="deskripsi" placeholder="Task description">
            <input type="datetime-local" name="time">
            <select name="progress">
                <option value="Not yet started">Not yet started</option>
                <option value="In progress">In progress</option>
                <option value="Waiting on">Waiting on</option>
            </select>
            <button type="submit">Add Task</button>
        </form>

        <h2>Your Tasks:</h2>
        <ul>
            <?php foreach ($tasks as $task) : ?>
                <li>
                    <h3><?= $task['judul'] ?></h3>
                    <p><?= $task['deskripsi'] ?></p>
                    <p>Progress: <?= $task['progress'] ?></p>
                    <p>Status: <?= $task['status'] ?></p>
                    <p>Time: <?= date('Y-m-d H:i', strtotime($task['time'])) ?></p>
                    <a href="edit_task.php?task_id=<?= $task['task_id'] ?>">Edit</a>
                    <a href="delete_task.php?task_id=<?= $task['task_id'] ?>">Delete</a>
                    <a href="markasdone.php?task_id=<?= $task['task_id'] ?>">Mark Completed</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
