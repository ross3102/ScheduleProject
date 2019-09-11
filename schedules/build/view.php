<?php writeHeader($SCHEDULES) ?>
        <h3 class="title">Build Schedule</h3>
        <div class="center-align">
            <a class="waves-effect waves-light btn-large blue lighten-1" href="./index.php?action=cancel">Cancel</a>
            <a class="waves-effect waves-light btn-large blue lighten-1" onclick="assembleSchedule()">Finish</a>
        </div>
        <div class="row">
            <div class="col s6">
                <h5 class="center-align">My Schedule</h5>
                <table class="centered bordered" id="builtSchedule">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Task Name</th>
                            <th>Task Duration</th>
                        </tr>
                    </thead>
                    <tbody id="builtScheduleBody">
                    <?php foreach ($task_list as $task) {
                        $task_name = $task["task_name"];
                        $task_id = $task["task_id"];
                        $category_name = $task["category_name"];
                        $task_date = $task["short_date"]; ?>
                        <tr class="NewT <?php echo $task_id ?>" style="display: none"
                            data-task-id="<?php echo $task_id ?>"
                            data-time=""
                            data-task-name="<?php echo htmlspecialchars($task_name)?>">
                            <td>
                                <i class="material-icons clickable tooltipped" data-tooltip="Remove from Schedule" onclick="removeFromSchedule(<?php echo $task_id ?>)">
                                    chevron_right</i>
                            </td>
                            <td><?php echo $task_name ?></td>
                            <td class="time"></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="center-align" style="margin: 5px"><a class="btn btn-large btn-floating red waves-effect waves-light" onclick="addNewToSchedule()"><i class="material-icons">add</i></a></div>
            </div>
            <div class="col s6">
                <h5 class="center-align">Task List</h5>
                <table class="centered bordered" id="taskList">
                    <thead>
                    <thead>
                    <tr>
                        <th></th>
                        <th>Task Name</th>
                        <th>Task Date</th>
                        <th>Category</th>
                    </tr>
                    </thead>
                    <tbody id="taskListBody">
                        <?php foreach ($task_list as $task) {
                            $task_name = $task["task_name"];
                            $task_id = $task["task_id"];
                            $category_name = $task["category_name"];
                            $category_color = $task["category_color"];
                            $task_date = $task["short_date"]; ?>
                            <tr class="T <?php echo $task_id ?>">
                                <td>
                                    <i class="material-icons clickable tooltipped" data-tooltip="Add to Schedule" onclick="addToSchedule('<?php echo $task_id ?>')">chevron_left</i>
                                </td>
                                <td style="color: <?php echo $category_color ?>"><?php echo $task_name ?></td>
                                <td style="color: <?php echo $category_color ?>"><?php echo $task_date ?></td>
                                <td style="color: <?php echo $category_color ?>"><?php echo $category_name ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    <script>

        var numNewTasks = 0;

        function addToSchedule(task_id) {
            var time = "";
            while (!(/\d{1,2}:\d{2}:\d{2}/.test(time))) {
                time = prompt("Enter a duration in the form HH:MM:SS or H:MM:SS");
                if (time == null)
                    return;
            }
            $(".T." + task_id).css("display", "none");
            var newElement = $(".NewT." + task_id);
            newElement.attr("data-time", time);
            newElement.find(".time").text(time);
            newElement.css("display", "");
            newElement.parent().append(newElement.clone());
            newElement.remove();
        }

        function addNewToSchedule() {
            var taskName = prompt("Enter a name for your new task");
            if (taskName == null || taskName === "") return;
            var time = "";
            while (!(/\d{1,2}:\d{2}:\d{2}/.test(time))) {
                time = prompt("Enter a duration in the form HH:MM:SS or H:MM:SS");
                if (time == null)
                    return;
            }
            var newRow = $("<tr class='CreatedT " + numNewTasks + "'>" +
            "   <td>" +
            "       <i class='material-icons clickable tooltipped' data-tooltip='Remove from Schedule' onclick='removeAddedFromSchedule(" + (numNewTasks++) + ")'>" +
            "           close</i>" +
            "   </td>" +
            "   <td>" + taskName + "</td>" +
            "   <td class='time'>" + time + "</td>" +
            "</tr>");
            newRow.attr("data-task-name", taskName);
            newRow.attr("data-time", time);
            newRow.attr("data-desc", "");
            $("#builtScheduleBody").append(newRow);
        }

        function removeAddedFromSchedule(task_id) {
            $(".CreatedT." + task_id).remove();
            numNewTasks--;
        }

        function removeFromSchedule(task_id) {
            $(".NewT." + task_id).css("display", "none");
            $(".T." + task_id).css("display", "")
        }

        function assembleSchedule() {
            var scheduleName = prompt("Enter a name for your new schedule");
            if (scheduleName == null || scheduleName === "") return;
            var scheduleDesc = prompt("Describe your new schedule");
            var sched = $("#builtScheduleBody").find("tr:visible").map(function() {
                return $(this).attr("data-task-name") + "-" + $(this).attr("data-time");
            });
            sched = JSON.stringify(sched);
            location.href = "./index.php?action=confirm_build_schedule&tasks=" + sched + "&schedule_name=" + scheduleName + "&schedule_desc=" + scheduleDesc;
        }

    </script>

<?php writeFooter() ?>