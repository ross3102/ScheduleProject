<?php
$head = '<link rel="stylesheet" href="work.css">';
writeHeader($head);
?>
<div class="container">
    <h3 class="title">Task List</h3>

    <div class="btn-div center-align">
        <a href="#newCategory" class="waves-effect waves-light btn-large blue lighten-1 modal-trigger">New Category</a>
        <a href="#newTask" class="waves-effect waves-light btn-large blue lighten-1 modal-trigger<?php echo count($categories) == 0 ? " disabled": "" ?>">New Task</a>
    </div>

    <div class="modal" id="newCategory">
        <form action="." method="post">
            <div class="modal-content">
                <input type="hidden" name="action" value="add_category">
                <div class="input-field">
                    <input class="charCount" type="text" name="category_name" id="category_name" data-length="60" maxlength="60" required>
                    <label for="category_name">New Category</label>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn-flat waves-effect waves-green modal-action modal-close">Cancel</a>
                <button class="btn-flat waves-effect waves-green">Create</button>
            </div>
        </form>
    </div>

    <div class="modal" id="editCat">
        <form action="." method="post">
            <div class="modal-content">
                <input type="hidden" name="action" value="edit_category">
                <input type="hidden" name="category_id" id="edit_category_id">
                <div class="input-field">
                    <input class="charCount" type="text" name="category_name" id="edit_category_name" data-length="60" maxlength="60" required>
                    <label for="edit_category_name">Category Name</label>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn-flat waves-effect waves-green modal-action modal-close">Cancel</a>
                <button class="btn-flat waves-effect waves-green">Confirm</button>
            </div>
        </form>
    </div>

    <div class="modal" id="newTask">
        <form action="." method="post" autocomplete="on">
            <div class="modal-content">
                <input type="hidden" name="action" value="add_task">
                <div class="row">
                    <div class="input-field col s6 m5">
                        <input class="charCount" type="text" name="task_name" id="task_name" data-length="80" maxlength="80" required>
                        <label for="task_name">New Task</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <select name="task_category" id="task_category">
<!--                            <option value="-1">General</option>-->
                            <?php foreach ($categories as $category) { ?>
                                <option class="blue-text text-lighten-1" value="<?php echo $category['category_id'] ?>"><?php echo $category["category_name"] ?></option>
                            <?php } ?>
                        </select>
                        <label for="task_category">Category</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input class="datepicker" id=datepicker type="date" name="task_date" required>
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

    <div class="modal" id="editTask">
        <form action="." method="post">
            <div class="modal-content">
                <input type="hidden" name="action" value="edit_task">
                <input type="hidden" name="task_id" id="edit_task_id">
                <div class="row">
                    <div class="input-field col s6 m5">
                        <input class="charCount" type="text" name="task_name" id="edit_task_name" data-length="80" maxlength="80" required>
                        <label for="edit_task_name">Task Name</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <select name="task_category" id="edit_task_category">
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category['category_id'] ?>"><?php echo $category["category_name"] ?></option>
                            <?php } ?>
                        </select>
                        <label for="edit_task_category">Category</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input class="datepicker" id="edit_task_date" type="date" name="task_date" required>
                        <label for="edit_task_date">Due Date</label>
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
        <ul class="collapsible popout" data-collapsible="expandable">
            <?php foreach ($categories as $category) {
                $category_id = $category["category_id"];
                $category_name = $category["category_name"];
                $tasks = get_tasks_by_category_id($category_id);
                if (count($tasks) == 0)
                    collapse($category_id, 0);
                $category_active = $category["category_active"] && count($tasks) > 0 ? "active": "";?>
                <li class="collapsibleItem" id="C<?php echo $category_id ?>">
                    <div class="collapsible-header <?php echo $category_active ?>">
                        <div class="category-header-inner">
                            <?php echo $category_name ?>
                            <span class="numTasks valign-wrapper"><?php echo get_total_tasks($category_id) ?>
                                <a onclick="event.stopPropagation(); editCat(<?php echo $category_id ?>, '<?php echo addslashes($category_name) ?>')">
                                    <i style="margin: 0;" class="material-icons clickable tooltipped blue-text"
                                       data-tooltip="Edit Category">edit</i>
                                </a>
                                <i class="material-icons clickable tooltipped red-text" data-tooltip="Delete Category" onclick="
                                        event.stopPropagation();
                                        confirmDeleteCategory('<?php echo addslashes($category_name) ?>', <?php echo $category_id ?>);"
                                >delete</i></span>
                        </div>
                    </div>
                    <div class="collapsible-body">
                        <ul class="collection">
                            <?php foreach ($tasks as $task):
                                $task_id = $task["task_id"];
                                $task_name = $task["task_name"];
                                $task_date = $task["task_date"];
                                $form_date = $task["form_date"];
                                $task_completed = $task["task_completed"]; ?>
                                <li class="collection-item">
                                    <span class="secondary-content black-text valign-wrapper">
                                        <?php echo $task_date ?>
                                        &nbsp;
                                        <i class="material-icons clickable tooltipped blue-text" onclick="editTask(<?php echo $task_id ?>, '<?php echo addslashes($task_name); ?>', '<?php echo $form_date ?>', <?php echo $category_id ?>);" data-tooltip="Edit Task">edit</i>
                                    </span>
                                    <input id="CB<?php echo $task_id ?>" data-task-id="<?php echo $task_id ?>" type="checkbox"><label for="CB<?php echo $task_id ?>"><span class="black-text <?php echo $task_id ?>"><?php echo $task_name ?></span></label>
                                </li>
                            <?php endforeach; ?>
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
        $(".datepicker").pickadate();
        $(".picker").appendTo('body');
        $(".modal").modal();
        $(".charCount").characterCounter();
    });

    function editTask(task_id, task_name, task_date, category_id) {
        $("#edit_task_id").val(task_id);
        $("#edit_task_name").val(task_name);
        $("#edit_task_category").val(category_id);
        $('select').material_select();
        $("#edit_task_date").val(task_date);
        Materialize.updateTextFields();
        $("#editTask").modal('open');
    }

    function editCat(category_id, category_name) {
        $("#edit_category_id").val(category_id);
        $("#edit_category_name").val(category_name);
        Materialize.updateTextFields();
        $("#editCat").modal('open');
    }

    $(".collapsible-header").click(function() {
        var active;
        var collapsibleItem = $(this).parent();
        if (collapsibleItem.find(".collection-item")[0] == null) {
            event.stopPropagation();
            Materialize.toast("This category is empty!", 2000);
            active = 0
        }
        else {
            if ($(this).hasClass("active")) active = 0;
            else active = 1;
        }
        var category_id = collapsibleItem.attr("id").slice(1);
        var url = './index.php?action=collapse&category_id=' + category_id + '&category_active=' + active;
        var request = new XMLHttpRequest();
        request.open('GET', url, true);
        request.send();
    });

    function delCategory(category_id) {
        location.href='./index.php?action=delete_category&category_id=' + category_id;
    }

    function confirmDeleteCategory(category_name, category_id) {
        Materialize.toast('<span>Delete category: ' + category_name + '?<span><button class="btn-flat toast-action" onclick="delCategory(' + category_id + ')">Confirm</button>', 10000);
    }

    $("input[type=checkbox]").change(function() {
        var task_id = $(this).attr("data-task-id");
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
