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
                        <tr id="NewT<?php echo $task_id ?>" style="display: none"
                            data-task-id="<?php echo $task_id ?>"
                            data-time=""
                            data-desc="<?php if (false) { ?>Imported from Task List. Category: <?php echo $category_name ?>. Due Date: <?php echo $task_date;  } ?>">
                            <td>
                                <i class="material-icons clickable tooltipped" data-tooltip="Remove from Schedule" onclick="removeFromSchedule(<?php echo $task_id ?>)">
                                    chevron_right</i>
                            </td>
                            <td><?php echo $task_name ?></td>
                            <td class="time"></td>
                        </tr>
                    <? } ?>
                    </tbody>
                </table>
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
                            <tr id="T<?php echo $task_id ?>">
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
        function addToSchedule(task_id) {
            var time;
            while (!(/\d{1,2}:\d{2}:\d{2}/.test(time))) {
                time = prompt("Enter a duration in the form HH:MM:SS or H:MM:SS");
                if (time == null)
                    return;
            }
            $("#T" + task_id).css("display", "none");
            var newElement = $("#NewT" + task_id);
            newElement.attr("data-time", time);
            newElement.find(".time").text(time);
            newElement.css("display", "");
            newElement.parent().append(newElement.clone());
            newElement.remove();
        }

        function removeFromSchedule(task_id) {
            $("#NewT" + task_id).css("display", "none");
            $("#T" + task_id).css("display", "")
        }

        function assembleSchedule() {
            var scheduleName = prompt("Enter a name for your new schedule");
            if (scheduleName == null || scheduleName === "") return;
            var scheduleDesc = prompt("Describe your new schedule");
            var sched = $("#builtScheduleBody").find("tr:visible").map(function() {
                return $(this).attr("data-task-id") + "-" + $(this).attr("data-time") + "-" + $(this).attr("data-desc");
            });
            sched = JSON.stringify(sched);
            location.href = "./index.php?action=confirm_build_schedule&ids=" + sched + "&schedule_name=" + scheduleName + "&schedule_desc=" + scheduleDesc;
        }

    </script>

<?php writeFooter() ?>