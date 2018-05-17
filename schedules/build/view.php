<?php writeHeader('') ?>
        <h3 class="title">Build Schedule</h3>
        <div class="center-align">
            <a class="waves-effect waves-light btn-large blue lighten-1" href="./index.php?action=cancel">Cancel</a>
            <a class="waves-effect waves-light btn-large blue lighten-1" onclick="assembleSchedule()">Add</a>
        </div>
        <div class="row">
            <div class="col s6">
                <h5 class="center-align">My Schedule</h5>
                <table class="centered striped" id="builtSchedule">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Task Name</th>
                            <th>Task Duration</th>
                        </tr>
                    </thead>
                    <tbody id="builtScheduleBody"></tbody>
                </table>
            </div>
            <div class="col s6">
                <h5 class="center-align">Task List</h5>
                <table class="centered striped" id="taskList">
                    <thead>
                    <thead>
                    <tr>
                        <th></th>
                        <th>Task Name</th>
                        <th>Task Date</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="taskListBody">
                        <?php foreach ($task_list as $task) {
                            $task_name = $task["task_name"];
                            $task_id = $task["task_id"];
                            $category_name = $task["category_name"];
                            $task_date = $task["task_date_short"];
                            $task_complete = $task["task_completed"]; ?>
                            <tr id="T<?php echo $task_id ?>">
                                <td>
                                    <i class="material-icons clickable" onclick="addToSchedule('<?php echo $task_id ?>', '<?php echo htmlspecialchars(addslashes($task_name)) ?>', '<?php echo htmlspecialchars(addslashes($category_name)) ?>', '<?php echo $task_date ?>')">chevron_left</i>
                                </td>
                                <td><?php echo $task_name ?></td>
                                <td><?php echo $task_date ?></td>
                                <td><?php echo $category_name ?></td>
                                <td><?php if ($task_complete) { ?><i class="material-icons green-text">check</i><?php } ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    <script>
        function addToSchedule(task_id, task_name, category_name, task_date) {
            var time;
            while (!(/\d{1,2}:\d{2}:\d{2}/.test(time))) {
                time = prompt("Enter a duration in the form HH:MM:SS or H:MM:SS");
                if (time == null)
                    return;
            }
            $("#T" + task_id).remove();
            var oc = 'removeFromSchedule(&quot;' + task_id + '&quot;, &quot;' + task_name + '&quot;, &quot;' + category_name + '&quot;, &quot;' + task_date + '&quot;)';
            var newElement = '<tr id="T' + task_id + '" data-task-id="' + task_id + '" data-time="' + time + '" data-desc="<?php if (false) { ?>Imported from Task List. Category: ' + category_name + '. Due Date: ' + task_date + '<?php } ?>"><td><i class="material-icons" onclick="' + oc + '">chevron_right</i></td><td>' + task_name + '</td><td>' + time + '</td></tr>';
            $("#builtScheduleBody").append(newElement);
        }

        function removeFromSchedule(task_id, task_name, category_name, task_date) {
            $("#T" + task_id).remove();
            var oc = 'addToSchedule(&quot;' + task_id + '&quot;, &quot;' + task_name + '&quot;, &quot;' + category_name + '&quot;, &quot;' + task_date + '&quot;)';
            var newElement = '<tr id="T' + task_id + '"><td><i class="material-icons" onclick="' + oc + '">chevron_left</i></td><td>' + task_name + '</td><td>' + task_date + '</td><td>' + category_name + '</td></tr>';
            $("#taskListBody").append(newElement);
        }

        function assembleSchedule() {
            var scheduleName = prompt("Enter a name for your new schedule");
            if (scheduleName == null || scheduleName === "") return;
            var scheduleDesc = prompt("Describe your new schedule");
            var sched = $("#builtScheduleBody").find("tr").map(function() {
                return $(this).attr("data-task-id") + "-" + $(this).attr("data-time") + "-" + $(this).attr("data-desc");
            });
            sched = JSON.stringify(sched);
            location.href = "./index.php?action=confirm_build_schedule&ids=" + sched + "&schedule_name=" + scheduleName + "&schedule_desc=" + scheduleDesc;
        }

    </script>

<?php writeFooter() ?>