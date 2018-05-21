<?php

include "../util/main.php";
verify_logged();

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
            create_dashboard_item("work", "Task List",
                "Write down upcoming tasks or assignments in an organized planner.", "view_agenda");
            create_dashboard_item("schedules", "Manage Schedules (Beta)",
                "Use this tool to manage your time effectively. Set aside time to complete your work and " .
                "establish deadlines to motivate you not to procrastinate! Don't worry if you run out of time, " .
                "because the deadlines can be extended when time runs out, but try to set reasonable goals and " .
                "strive to complete them!", "view_list");
/*  TODO: Add the following:
 *            create_dashboard_item("notes", "Notes",
 *                "Create and view small reminders and other notes", "edit");
 *            create_dashboard_item("calendar", "Calendar",
 *                "Click to see your calendar", "today");
 *
 *            create_dashboard_item("feedback", "Give feedback",
 *                "Have a question? Comment? Concern? Feedback is always appreciated", "comment");
 *
 */
        ?>
    </div>
</div>

<?php writeFooter() ?>