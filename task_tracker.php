<?php
session_start();
include('db.php');

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
    <title>To-Do List</title>
    <link rel="stylesheet" href="task_tracker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
        var amOrPm = hours >= 12 ? "PM" : "AM";

        // Convert 24-hour format to 12-hour format
        hours = (hours % 12) || 12;

        var time = hours + ":" + (minutes < 10 ? "0" : "") + minutes + " " + amOrPm;
        settime.innerHTML = time;
    }

    // Update date and time every second (1000 milliseconds)
    setInterval(updateDateTime, 1000);
    </script>
</head>

<body>
    <div class="flex justify-center items-center min-h-screen bg-[#cbd7e3]">
        <div class="h-auto  w-6/12 bg-white rounded-lg p-4">
            <div class="mt-0 text-sm text-[#8ea6c8] flex justify-between items-center">
                <p class="set_date"></p>
                <p class="set_time"></p>
            </div>
            <h1 class="text-lg text-[#063c76]">Welcome, <?= $username ?>!</h1>
            <p class="text-2xl font-semibold mt-2 text-[#063c76]">To-do List</p>
            <form action="add_task.php" method="post">
                <div class="add-items flex">
                    <input name="judul" type="text"
                        class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 placeholder-[#063c76] text-[#063c76] shadow-sm sm:text-sm sm:leading-6"
                        placeholder="Title" required>
                    <input name="deskripsi" type="text"
                        class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 placeholder-[#063c76] text-[#063c76] shadow-sm sm:text-sm sm:leading-6"
                        placeholder="Description">
                    <select
                        class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                        name="progress">
                        <option
                            class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                            value="Not Started">Not Started</option>
                        <option
                            class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                            value="On Progress">On Progress</option>
                        <option
                            class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                            value="Waiting On">Waiting On</option>
                    </select>
                    <button type="submit"
                        class="flex-none rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Add
                        Task</button>
                </div>
            </form>

            <ul class="my-4 ">
                <?php foreach ($tasks as $task) : ?>
                <li class=" mt-4" id="1">
                    <div class="flex gap-2">
                        <div class="w-9/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <p class="text-sm ml-4 text-[#063c76] font-semibold"><?= $task['judul'] ?></p>
                        </div>
                        <div class="w-9/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <p class="text-sm ml-4 text-[#063c76] font-semibold"><?= $task['deskripsi'] ?></p>
                        </div>
                        <div class="w-2/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <select
                                class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                                name="progress">
                                <option class=" text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2
                                shadow-sm sm:text-sm sm:leading-6" value="0"
                                    <?= ($task['progress'] === 0) ? ' selected' : '' ?>>Not Started
                                </option>
                                <option
                                    class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                                    value="1" <?= ($task['progress'] === 1) ? ' selected' : '' ?>>On Progress
                                </option>
                                <option
                                    class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                                    value="2" <?= ($task['progress'] === 2) ? ' selected' : '' ?>>Waiting On
                                </option>
                            </select>
                        </div>
                        <div class="w-1/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <select
                                class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                                name="status">
                                <option
                                    class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                                    value="2" <?= ($task['status'] === 1) ? ' selected' : '' ?>>Done
                                </option>
                            </select>
                        </div>
                        <span
                            class="w-2/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#063c76] font-semibold items-center "><?= date('d-m-Y', strtotime($task['time'])) ?></span>
                        <div>
                            <form method="post" action="edit_task.php?task_id=<?= $task['task_id'] ?>">
                                <button type="submit"
                                    class="flex-none rounded-md bg-red-700 px-3.5 h-12 shadow-sm hover:bg-red-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>
                        </div>
                        <div>
                            <a href="delete_task.php?task_id=<?= $task['task_id'] ?>">
                                <button type="button"
                                    class="flex-none rounded-md bg-red-700 px-3.5 h-12 shadow-sm hover:bg-red-800"><i
                                        class="fas fa-trash-alt"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <form method="post" action="logout.php">
                <button type="submit"
                    class="flex-none rounded-md bg-red-700 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-800">
                    Log Out
                </button>
            </form>

        </div>
    </div>
</body>

</html>