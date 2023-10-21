<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="task_tracker.css">
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

    function checked(id) {
        var checked_green = document.getElementById("check" + id);
        checked_green.classList.toggle('green');
        var strike_unstrike = document.getElementById("strike" + id);
        strike_unstrike.classList.toggle('strike_none');
    }
    </script>
</head>

<body>
    <div class="flex justify-center items-center min-h-screen bg-[#cbd7e3]">
        <div class="h-auto  w-96 bg-white rounded-lg p-4">
            <div class="mt-0 text-sm text-[#8ea6c8] flex justify-between items-center">
                <p class="set_date"></p>
                <p class="set_time"></p>
            </div>
            <p class="text-2xl font-semibold mt-2 text-[#063c76]">To-do List</p>
            <div class="add-items d-flex">
                <input name="new_task" type="text"
                    class="min-w-0 flex-auto rounded-md border-0 bg-[#e4efff] px-6 py-2 text-black shadow-sm focus:ring-2 focus:ring-[#8ea6c8] sm:text-sm sm:leading-6"
                    placeholder="What do you want to do?">
                <button type="submit"
                    class="flex-none rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Add</button>
            </div>
            <ul class="my-4 ">
                <li class=" mt-4" id="1">
                    <div class="flex gap-2">
                        <div class="w-9/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <span id="check1"
                                class=" w-7 h-7 bg-white rounded-full border border-white transition-all cursor-pointer hover:border-[#36d344] flex justify-center items-center"
                                onclick="checked(1)"><i class="text-white fa fa-check"></i></span>
                            <strike id="strike1" class="strike_none text-sm ml-4 text-[#5b7a9d] font-semibold">take out
                                the trash</strike>
                        </div>
                        <span
                            class="w-1/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#5b7a9d] font-semibold items-center ">9:00
                            AM</span>
                    </div>
                </li>
                <li class=" mt-4" id="2">
                    <div class="flex gap-2">
                        <div class="w-9/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <span id="check2"
                                class=" w-7 h-7 bg-white rounded-full border border-white transition-all cursor-pointer hover:border-[#36d344] flex justify-center items-center"
                                onclick="checked(2)"><i class="text-white fa fa-check"></i></span>
                            <strike id="strike2" class="strike_none text-sm ml-4 text-[#5b7a9d] font-semibold">do
                                homework </strike>
                        </div>
                        <span
                            class="w-1/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#5b7a9d] font-semibold items-center ">12:00
                            PM</span>
                    </div>
                </li>
                <li class=" mt-4" id="3">
                    <div class="flex gap-2">
                        <div class="w-9/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <span id="check3"
                                class=" w-7 h-7 bg-white rounded-full border border-white transition-all cursor-pointer hover:border-[#36d344] flex justify-center items-center"
                                onclick="checked(3)"><i class="text-white fa fa-check"></i></span>
                            <strike id="strike3" class="strike_none  text-sm ml-4 text-[#5b7a9d] font-semibold">go to
                                grocery store</strike>
                        </div>
                        <span
                            class="w-1/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#5b7a9d] font-semibold items-center ">1:00
                            PM</span>
                    </div>
                </li>
                <li class=" mt-4" id="4">
                    <div class="flex gap-2">
                        <div class="w-9/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <span id="check4"
                                class=" w-7 h-7 bg-white rounded-full border border-white transition-all cursor-pointer hover:border-[#36d344] flex justify-center items-center"
                                onclick="checked(4)"><i class="text-white fa fa-check"></i></span>
                            <strike id="strike4" class="strike_none text-sm ml-4 text-[#5b7a9d] font-semibold">run 5
                                kilometers</strike>
                        </div>
                        <span
                            class="w-1/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#5b7a9d] font-semibold items-center ">4:20
                            PM</span>
                    </div>
                </li>
                <li class=" mt-4" id="5">
                    <div class="flex gap-2">
                        <div class="w-9/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <span id="check5"
                                class=" w-7 h-7 bg-white rounded-full border border-white transition-all cursor-pointer hover:border-[#36d344] flex justify-center items-center"
                                onclick="checked(5)"><i class="text-white fa fa-check"></i></span>
                            <strike id="strike5" class="strike_none text-sm ml-4 text-[#5b7a9d] font-semibold">load the
                                dishwasher</strike>
                        </div>
                        <span
                            class="w-1/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#5b7a9d] font-semibold items-center ">9:00
                            PM</span>
                    </div>
                </li>
                <li class=" mt-4" id="6">
                    <div class="flex gap-2">
                        <div class="w-9/12 h-12 bg-[#e0ebff] rounded-[7px] flex justify-start items-center px-3">
                            <span id="check6"
                                class=" w-7 h-7 bg-white rounded-full border border-white transition-all cursor-pointer hover:border-[#36d344] flex justify-center items-center"
                                onclick="checked(6)"><i class="text-white fa fa-check"></i></span>
                            <strike id="strike6" class="strike_none text-sm ml-4 text-[#5b7a9d] font-semibold">Take out
                                the trash</strike>
                        </div>
                        <span
                            class="w-1/4 h-12 bg-[#e0ebff] rounded-[7px] flex justify-center text-sm text-[#5b7a9d] font-semibold items-center ">9:00
                            AM</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>