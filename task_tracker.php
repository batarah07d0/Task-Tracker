<?php
session_start();
include('db.php');

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Ambil daftar tugas dari database
$sql = "SELECT * FROM task WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            <h1 class="text-lg text-[#063c76]">Welcome, <?= $username ?>!</h1>
            <p class="text-2xl font-semibold mt-2 text-[#063c76]">To-do List</p>
            <form class="mb-3" action="add_task.php" method="post">
                <div class="add-items flex">
                    <input name="judul" type="text"
                        class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 placeholder-[#063c76] text-[#063c76] shadow-sm sm:text-sm sm:leading-6"
                        placeholder="Title" required>
                    <input name="deskripsi" type="text"
                        class="text-center w-3/12 flex-auto rounded-md bg-[#e0ebff] mr-2 placeholder-[#063c76] text-[#063c76] shadow-sm sm:text-sm sm:leading-6"
                        placeholder="Description">
                    <select
                        class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                        name="progress">
                        <option
                            class="text-[#063c76] text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                            value="1">Not Started</option>
                        <option
                            class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                            value="2">On Progress</option>
                        <option
                            class="text-center min-w-0 flex-auto rounded-md bg-[#e0ebff] mr-2 shadow-sm sm:text-sm sm:leading-6"
                            value="3">Waiting On</option>
                    </select>
                    <button type="submit"
                        class="flex-none rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Add
                        Task</button>
                </div>
            </form>
            <p class="text-lg font-semibold text-[#063c76]">Not Completed</p>
            <ul class="mb-3" id="notcomp">
                <?php foreach ($tasks as $task) : ?>
                <?php if ($task['status'] == 0) : ?>
                <li class="mb-2" id="1">
                    <div class="flex gap-2">
                        <div class="w-6/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <p class="text-sm ml-4 text-[#063c76] font-semibold"><?= $task['judul'] ?></p>
                        </div>
                        <div class="w-9/12 h-auto bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <p class="text-sm ml-4 text-[#063c76] font-semibold"><?= $task['deskripsi'] ?></p>
                        </div>
                        <div class="w-2/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center items-center px-3">
                            <p class="text-sm text-[#063c76] font-semibold">
                                <?php if ($task['progress'] == 1) {echo "Not yet Started";} elseif ($task['progress'] == 2) { echo "On Progress";} elseif ($task['progress'] == 3) {echo "Waiting On";} else {echo "Unknown";}?>
                            </p>
                        </div>
                        <span
                            class="w-2/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#063c76] font-semibold items-center"><?= date('l, F j', strtotime($task['time'])) ?></span>
                        <div>
                            <form method="post" action="markasdone.php?task_id=<?= $task['task_id'] ?>">
                                <button type="submit"
                                    class="flex-none rounded-md bg-[#6ade11] px-3.5 h-12 shadow-sm hover:bg-[#74d429] check">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        </div>

                        <div>
                            <form method="post" action="edit_task.php?task_id=<?= $task['task_id'] ?>">
                                <button type="submit"
                                    class="flex-none rounded-md bg-indigo-500 px-3.5 h-12 shadow-sm hover:bg-indigo-400">
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
                <<<<<<< HEAD <?php endforeach; ?> </ul>
                    <form method="post" action="logout.php">
                        =======
                        <?php endif; ?>
                        <?php endforeach; ?>
            </ul>
            <p class="text-lg font-semibold text-[#063c76]">Completed</p>
            <ul class="mb-3" id="comp">
                <?php foreach ($tasks as $task) : ?>
                <?php if ($task['status'] == 1) : ?>
                <li class="mb-2" id="1">
                    <div class="flex gap-2">
                        <div class="w-6/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <p class="text-sm ml-4 text-[#063c76] font-semibold">
                                <?= $task['status'] == 1 ? '<s>' : '' ?><?= $task['judul'] ?><?= $task['status'] == 1 ? '</s>' : '' ?>
                            </p>
                        </div>
                        <div class="w-9/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <p class="text-sm ml-4 text-[#063c76] font-semibold">
                                <?= $task['status'] == 1 ? '<s>' : '' ?><?= $task['deskripsi'] ?><?= $task['status'] == 1 ? '</s>' : '' ?>
                            </p>
                        </div>
                        <span
                            class="w-3/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#063c76] font-semibold items-center">
                            <?= $task['status'] == 1 ? '<s>' : '' ?><?= date('l, F j', strtotime($task['time'])) ?><?= $task['status'] == 1 ? '</s>' : '' ?>
                        </span>
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
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <form method="post" action="form/logout.php">
                >>>>>>> batara
                <button type="submit"
                    class="flex-none rounded-md bg-red-700 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-800">
                    Log Out
                </button>
            </form>

        </div>
    </div>
</body>

</html>