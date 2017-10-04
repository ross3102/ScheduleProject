<?php writeHeader('') ?>
<div class="container" id="build_schedule">
    <h3 class="title">Build Schedule</h3>
    <div class="center-align">
        <a class="waves-effect waves-light btn" href="./index.php?action=cancel">Cancel</a>
        <a class="waves-effect waves-light btn" onclick="assembleSchedule()">Add</a>
    </div>
    <div class="row">
        <div class="col s6">
            <div class="collection with-header" id="builtSchedule">
                <div class="collection-header"><h5>My Schedule</h5></div>
            </div>
        </div>
        <div class="col s6">
            <div class="collection with-header" id="taskList">
                <div class="collection-header"><h5>Task List</h5></div>
                <?php foreach ($task_list as $task) {
                    $task_name = $task["task_name"];
                    $task_id = $task["task_id"];
                    $category_name = $task["category_name"];
                    $task_date = $task["task_date"];?>
                    <div class="collection-item" id="T<?php echo $task_id ?>">
                        <i class="material-icons" onclick="addToSchedule('<?php echo $task_id ?>', '<?php echo $task_name ?>', '<?php echo $category_name ?>')">chevron_left</i>
                        <span><?php echo $task_name ?></span>
                        <i class="material-icons tooltipped" data-tooltip="<?php echo $task_date ?>">event</i>
                        <span class="badge"><?php echo $category_name ?></span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    function addToSchedule(task_id, task_name, category_name) {
        $("#T" + task_id).remove();
        console.log(task_id, task_name, category_name);
        var oc = 'removeFromSchedule(&quot;' + task_id + '&quot;, &quot;' + task_name + '&quot;, &quot;' + category_name + '&quot;)';
        var newElement = '<div class="collection-item" id="T' + task_id + '"><i class="material-icons" onclick="' + oc + '">chevron_right</i><span>' + task_name + '</span><span class="badge">' + category_name + '</span></div>';
        $("#builtSchedule").append(newElement);
    }

    function removeFromSchedule(task_id, task_name, category_name) {
        $("#T" + task_id).remove();
        var oc = 'addToSchedule(&quot;' + task_id + '&quot;, &quot;' + task_name + '&quot;, &quot;' + category_name + '&quot;)';
        var newElement = '<div class="collection-item" id="T' + task_id + '"><i class="material-icons" onclick="' + oc + '">chevron_left</i><span>' + task_name + '</span><span class="badge">' + category_name + '</span></div>';
        $("#taskList").append(newElement);
    }

    function assembleSchedule() {
        var sched = $("#builtSchedule").find(".collection-item").map(function() {
            return this.id.slice(1);
        });
        console.log(sched);
    }

</script>

<?php writeFooter() ?>