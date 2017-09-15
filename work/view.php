<?php
$head = '<link rel="stylesheet" href="work.css">';
writeHeader($head);
?>
<div class="container">

    <h3 class="title">Task List</h3>

    <div class="btn-div center-align">
        <a href="#newCategory" class="waves-effect waves-light btn modal-trigger">New Category</a>
        <a href="#newTask" class="waves-effect waves-light btn modal-trigger">New Task</a>
    </div>

    <div class="modal" id="newCategory">
        <form action="." method="post">
            <div class="modal-content">
                <input type="hidden" name="action" value="add_category">
                <div class="input-field">
                    <input type="text" name="category_name" id="category_name" required>
                    <label for="category_name">New Category</label>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn-flat waves-effect waves-green modal-action modal-close">Cancel</a>
                <button class="btn-flat waves-effect waves-green">Create</button>
            </div>
        </form>
    </div>

    <div class="modal" id="newTask">
        <form action="." method="post">
            <div class="modal-content">
                <input type="hidden" name="action" value="add_task">
                <div class="row">
                    <div class="input-field col s6 m5">
                        <input type="text" name="task_name" id="task_name" required>
                        <label for="task_name">New Task</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <select name="task_category" id="task_category">
                            <option value="-1">General</option>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category['category_id'] ?>"><?php echo $category["category_name"] ?></option>
                            <?php } ?>
                        </select>
                        <label for="task_category">Category</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input id=datepicker type="date" name="task_date" required>
                        <label for="datepicker">Due Date</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn-flat waves-effect waves-green modal-action modal-close">Cancel</a>
                <button class="btn-flat waves-effect waves-green">Create</button>
            </div>
        </form>
    </div>
    <?php if (count($categories) > 0) { ?>
        <ul class="collapsible" data-collapsible="expandable">
            <?php foreach ($categories as $category) {
                $category_id = $category["category_id"];
                $category_name = $category["category_name"];
                $tasks = get_tasks_by_category_id($category_id);?>
                <li>
                    <div class="collapsible-header"><div class="category-header-inner"><?php echo $category_name ?><span class="numTasks"><?php echo get_total_tasks($category_id) ?></span></div></div>
                    <div class="collapsible-body">
                        <ul class="collection">
                            <?php foreach ($tasks as $task) {
                                $task_id = $task["task_id"];
                                $task_name = $task["task_name"];
                                $task_date = $task["task_date"];
                                $task_completed = $task["task_completed"];
                                $color = ($task_completed ? "grey": "black") . "-text"?>
                                <li class="collection-item">
                                    <span class="secondary-content <?php echo $color . " " . $task_id; ?>"><?php echo $task_date ?></span>
                                    <input id="C<?php echo $task_id ?>" type="checkbox" <?php if ($task_completed == 1) echo "checked" ?>><label for="C<?php echo $task_id ?>"><span class="<?php echo $color . " " . $task_id ?>"><?php echo $task_name ?></span></label>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>

<script>
    $(document).ready(function() {
        $("select").material_select();
        $("#datepicker").pickadate();
        $(".picker").appendTo('body');
        $(".modal").modal();
    });

    $("input[type=checkbox]").change(function() {
        var task_id = $(this).attr("id").slice(1);
        var task_completed;
        if ($(this).is(':checked')) {
            task_completed = 1;
        }
        else {
            task_completed = 0;
        }
        var text = $("." + task_id);
        text.toggleClass("black-text");
        text.toggleClass("grey-text");
        var url = './index.php?action=complete&task_id=' + task_id + '&task_completed=' + task_completed;
        var request = new XMLHttpRequest();
        request.open('GET', url, true);
        request.send();
    });
</script>

<?php writeFooter() ?>
