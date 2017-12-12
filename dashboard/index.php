<?php

include "../util/main.php";

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'list_options';
    }
}


switch ($action) {
    case 'list_options':
        break;
    default:
        echo ('Unknown action: ' . $action);
        exit();
        break;
}

$head = '<link rel="stylesheet" href="dashboard.css">';

writeHeader($head);

?>

<div class="container">
    <h3 class="title">Action Dashboard</h3>
    <div class="collection">
        <?php
            create_dashboard_item("schedules", "Manage Schedules",
                "Run or edit existing schedules or create a new one!", "view_list");
            create_dashboard_item("work", "Task List",
                "Write down upcoming tasks or assignments", "view_agenda");
            create_dashboard_item("calendar", "Calendar",
                "Click to see your calendar", "today")
        ?>
    </div>
</div>

<?php writeFooter() ?>