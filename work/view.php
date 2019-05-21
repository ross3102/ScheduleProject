<?php
$head = '<link rel="stylesheet" href="work.css">';
writeHeader($TASK_LIST, $head);
$numCategories = count($categories);
?>
<div class="container main z-depth-4">

    <div class="fixed-action-btn toolbar">
        <a class="btn-floating btn-large red">
            <i class="large material-icons">add</i>
        </a>
        <ul>
            <li><a href="#newCategory" class="btn waves-effect waves-light modal-trigger">New Category <i class="material-icons">library_add</i></a></li>
            <li><a href="#newTask" class="btn waves-effect waves-light modal-trigger <?php if ($numCategories==0) echo "disabled" ?>">New Task <i class="material-icons">playlist_add</i></a></li>
            <!--            <li><a onclick="deleteAll()" class="waves-effect waves-light modal-trigger">Delete All <i class="material-icons">delete_sweep</i></a></li>-->
        </ul>
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
                <button class="btn-flat waves-effect waves-green">Confirm</button>
            </div>
        </form>
    </div>

    <div class="row">
        <ul class="tabs tabs-fixed-width">
            <li class="tab col s6"><a href="#task-list-view">Task List</a></li>
            <li class="tab col s6"><a href="#upcoming">Upcoming</a></li>
        </ul>
    </div>

    <div id="task-list-view">

        <?php if (count($categories) > 0) { ?>
            <ul class="collapsible popout" data-collapsible="expandable">
                <?php foreach ($categories as $category) {
                    $category_id = $category["category_id"];
                    $category_name = $category["category_name"];
                    $category_color = $category["category_color"];
                    $tasks = get_tasks_by_category_id($category_id);
                    $num_tasks = count($tasks);
//                    if ($num_tasks == 0)
//                        $task_caption = "";
//                    else
                    $task_caption = $num_tasks . " Task" . ($num_tasks != 1 ? "s": "");
                    if (count($tasks) == 0)
                        collapse($category_id, 0);
                    $category_active = $category["category_active"] && $num_tasks > 0 ? "active": ""; ?>
                    <input onclick="event.stopPropagation();" style="display: none" type="color" class="color_chooser" id="colorChooser<?php echo $category_id ?>" value="<?php echo $category_color ?>">
                    <li class="collapsibleItem" id="C<?php echo $category_id ?>">
                        <div class="collapsible-header <?php echo $category_active ?>">
                            <div class="category-header-inner">
                                <div class="color<?php echo $category_id ?>" style="display: inline-block; color: <?php echo $category_color ?>"><?php echo $category_name ?></div>
                                <span class="numTasks valign-wrapper"><?php echo $task_caption ?>
                                    <a onclick="event.stopPropagation(); addTask(<?php echo $category_id ?>)">
                                        <i style="margin: 0;" class="material-icons clickable tooltipped green-text"
                                           data-tooltip="Add Task">add</i>
                                    </a>
                                    <a onclick="event.stopPropagation(); $('#colorChooser<?php echo $category_id ?>').click()">
                                        <i style="margin: 0; color: <?php echo $category_color ?>" class="material-icons clickable tooltipped color<?php echo $category_id ?>"
                                           data-tooltip="Category Color">color_lens</i>
                                    </a>
                                    <a onclick="event.stopPropagation(); editCat(<?php echo $category_id ?>, '<?php echo htmlspecialchars(addslashes($category_name)) ?>')">
                                        <i style="margin: 0;" class="material-icons clickable tooltipped blue-text"
                                           data-tooltip="Edit Category">edit</i>
                                    </a>
                                    <i style="margin: 0;" class="material-icons clickable tooltipped red-text" data-tooltip="Delete Category" onclick="
                                            event.stopPropagation();
                                            confirmDeleteCategory('<?php echo htmlspecialchars(addslashes($category_name)) ?>', <?php echo $category_id ?>);"
                                    >delete</i>
                                </span>
                            </div>
                        </div>
                        <div class="collapsible-body">
                            <ul class="collection">
                                <?php foreach ($tasks as $task):
                                    $task_id = $task["task_id"];
                                    $task_name = $task["task_name"];
                                    $task_date = $task["table_date"];
                                    $form_date = $task["form_date"];
                                    $task_completed = $task["task_completed"]; ?>
                                    <li class="collection-item">
                                        <span class="secondary-content black-text valign-wrapper">
                                            <?php echo $task_date ?>
                                            &nbsp;
                                            <i class="material-icons clickable tooltipped blue-text" onclick="editTask(<?php echo $task_id ?>, '<?php echo htmlspecialchars(addslashes($task_name)); ?>', '<?php echo $form_date ?>', <?php echo $category_id ?>);" data-tooltip="Edit Task">edit</i>
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
    <div id="upcoming">
        <table class="highlight">
            <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $prev_date = -1;
            foreach ($all_tasks as $task):
                $task_id = $task["task_id"];
                $category_id = $task["category_id"];
                $category_name = $task["category_name"];
                $category_color = $task["category_color"];
                $task_name = $task["task_name"];
                $task_date = $task["table_date"];
                $form_date = $task["form_date"];
                $task_completed = $task["task_completed"];
                $is_new_date = $task_date != $prev_date ?>
                <tr class="color<?php echo $category_id ?>" style="color: <?php echo $category_color ?>; <?php if ($is_new_date) echo 'border-top: 1px solid lightgray'?>" onclick="editTask(<?php echo $task_id ?>, '<?php echo htmlspecialchars(addslashes($task_name)); ?>', '<?php echo $form_date ?>', <?php echo $category_id ?>);">
                    <td>
                        <span onclick="event.stopPropagation();"><input id="CBTwo<?php echo $task_id ?>" data-task-id="<?php echo $task_id ?>" type="checkbox"><label for="CBTwo<?php echo $task_id ?>"><span class="<?php echo $task_id ?> color<?php echo $category_id ?>" style="color: <?php echo $category_color ?>"><?php echo $task_name ?></span></label></span>
                    </td>
                    <td>
                        <?php echo $category_name ?>
                    </td>
                    <td>
                        <?php echo $task_date ?>
                    </td>
                </tr>
            <?php $prev_date = $task_date; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("select").material_select();
        $(".datepicker").pickadate();
        $(".picker").appendTo('body');
        $(".modal").modal({
            dismissible: false
        });
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
    
    $(".color_chooser").change(function () {
        var category_id = $(this).attr("id").substr("colorChooser".length);
        var color = $(this).val().substr(1);

        $(".color" + category_id).css("color", color);

        var url = './index.php?action=change_color&category_id=' + category_id + '&color=' + color;

        var request = new XMLHttpRequest();
        request.open('GET', url, true);
        request.send();
    });

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
        event.stopPropagation();
        var task_id = $(this).attr("data-task-id");
        var task_completed;
        if ($(this).is(':checked')) {
            task_completed = 1;
            $("#CB" + task_id).prop("checked", true);
            $("#CBTwo" + task_id).prop("checked", true);
        }
        else {
            task_completed = 0;
            $("#CB" + task_id).prop("checked", false);
            $("#CBTwo" + task_id).prop("checked", false);
        }
        var url = './index.php?action=complete&task_id=' + task_id + '&task_completed=' + task_completed;

        var request = new XMLHttpRequest();
        request.open('GET', url, true);
        request.send();
    });

    function addTask(category_id) {
        var category_select = $("#task_category");
        category_select.val(category_id);
        category_select.material_select();
        $("#newTask").modal("open");
    }

    // $(document).keypress(function(e) {
    //     var keycode = (e.keyCode ? e.keyCode : e.which);
    //     if (keycode === 116) { // T
    //         $("#newCategory").modal("close");
    //         $("#newTask").modal("open");
    //     }
    //     else if (keycode === 99) { // C
    //         $("#newTask").modal("close");
    //         $("#newCategory").modal("open");
    //     }
    // });

</script>

<?php writeFooter() ?>
