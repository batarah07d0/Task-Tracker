<?php
session_start();
include('db.php');

date_default_timezone_set("Asia/Jakarta");
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $progress = $_POST['progress'];
    $time = date('Y-m-d H:i:s'); 


    $sql = "UPDATE task SET judul = ?, deskripsi = ?, progress = ? WHERE task_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$judul, $deskripsi, $progress, $task_id]);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>To-Do List | Update Task</title>
    <script>
    function updateDateTime() {
        var setdate = document.querySelector(".set_date");
        var settime = document.querySelector(".set_time");

        var currentDate = new Date();

        // Format the date as 'Thursday, May 28' (or change to your preferred format)
        var options = {
            weekday: 'long',
            month: 'long',
            day: 'numeric'
        };
        var formattedDate = currentDate.toLocaleDateString(undefined, options);

        setdate.innerHTML = formattedDate;

        var hours = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        var seconds = currentDate.getSeconds();
        var amOrPm = hours >= 12 ? "PM" : "AM";

        // Convert 24-hour format to 12-hour format
        hours = (hours % 12) || 12;

        var time = hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " +
            amOrPm;
        settime.innerHTML = time;
    }

    // Update date and time every second (1000 milliseconds)
    setInterval(updateDateTime, 1000);
    </script>
</head>

<body>
    <div class="flex justify-center items-center min-h-screen bg-[#cbd7e3]">
        <div class="h-auto  w-10/12 bg-white rounded-lg p-4">
            <div class="mt-0 text-sm text-[#8ea6c8] flex justify-between items-center">
                <p class="set_date"></p>
                <p class="set_time"></p>
            </div>
            <h1 class="text-lg text-[#063c76]">Hello, <?= $username ?>!</h1>
            <p class="text-2xl font-semibold my-1 text-[#063c76]">Update Task</p>
            <form action="edit_task.php" method="post">
                <div class="add-items flex">
                    <input type="hidden" name="task_id" value="<?= $editTask['task_id'] ?>">
                    <input
                        class="font-semibold text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 placeholder-[#063c76] text-[#063c76] shadow-sm sm:text-sm sm:leading-6"
                        type="text" name="judul" value="<?= $editTask['judul'] ?>" placeholder="Task title" required>
                    <input
                        class="font-semibold text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 placeholder-[#063c76] text-[#063c76] shadow-sm sm:text-sm sm:leading-6"
                        type="text" name="deskripsi" value="<?= $editTask['deskripsi'] ?>"
                        placeholder="Task description">
                    <div class="w-max h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-2">
                        <select
                            class="font-semibold text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] shadow-sm sm:text-sm sm:leading-6"
                            name="progress">
                            <option
                                class="font-semibold text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] shadow-sm sm:text-sm sm:leading-6"
                                value="1" <?= ($editTask['progress'] === 1) ? ' selected' : '' ?>>
                                Not yet Started</option>
                            <option
                                class="font-semibold text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] shadow-sm sm:text-sm sm:leading-6"
                                value="2" <?= ($editTask['progress'] === 2) ? ' selected' : '' ?>>On
                                Progress</option>
                            <option
                                class="font-semibold text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] shadow-sm sm:text-sm sm:leading-6"
                                value="3" <?= ($editTask['progress'] === 3) ? ' selected' : '' ?>>Waiting On
                            </option>
                        </select>
                    </div>
                    <span
                        class="h-12 w-2/12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#063c76] font-semibold items-center mx-2">
                        <?= date('l, F j', strtotime($editTask['time'])) ?></span>
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