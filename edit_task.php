<?php
session_start();
include('db.php');

date_default_timezone_set("Asia/Jakarta");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $progress = $_POST['progress'];
    $time = date('Y-m-d H:i:s'); 


    $sql = "UPDATE task SET judul = ?, deskripsi = ?, progress = ?, time = ? WHERE task_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$judul, $deskripsi, $progress, $time, $task_id]);
    $formattedTime = date('d-m-Y H:i:s', strtotime($time));

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
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Update Task</title>
</head>

<body>
    <div class="flex justify-center items-center min-h-screen bg-[#cbd7e3]">
        <div class="h-auto  w-6/12 bg-white rounded-lg p-4">
            <p class="text-2xl font-semibold m-2 text-[#063c76]">Update Task</p>
            <form action="edit_task.php" method="post">
                <div class="add-items flex">
                    <input type="hidden" name="task_id" value="<?= $editTask['task_id'] ?>">
                    <input
                        class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 placeholder-[#063c76] text-[#063c76] shadow-sm sm:text-sm sm:leading-6"
                        type="text" name="judul" value="<?= $editTask['judul'] ?>" placeholder="Task title" required>
                    <input
                        class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 placeholder-[#063c76] text-[#063c76] shadow-sm sm:text-sm sm:leading-6"
                        type="text" name="deskripsi" value="<?= $editTask['deskripsi'] ?>"
                        placeholder="Task description">
                    <select
                        class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                        name="progress">
                        <option
                            class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                            value="0" <?= ($editTask['progress'] === 0) ? ' selected' : '' ?>>
                            Not Started</option>
                        <option
                            class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                            value="1" <?= ($editTask['progress'] === 1) ? ' selected' : '' ?>>On
                            Progress</option>
                        <option
                            class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                            value="2" <?= ($editTask['progress'] === 2) ? ' selected' : '' ?>>Waiting On
                        </option>
                    </select>
                    <button
                        class="flex-none rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                        type="submit">Update</button>
                </div>
            </form>
        </div>
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