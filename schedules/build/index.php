<?php

include "../../util/main.php";
include "../../model/taskdb.php";
include "../../model/scheduledb.php";

verify_logged();

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'build_schedule';
    }
}


switch ($action) {
    case 'build_schedule':
        $task_list = get_task_list($user["id"]);
        include "view.php";
        break;
    case 'confirm_build_schedule':
        // TODO ids parameter too long for get request
        $tasks = json_decode(filter_input(INPUT_GET, "tasks"));
        $schedule_name = filter_input(INPUT_GET, "schedule_name");
        $schedule_desc = filter_input(INPUT_GET, "schedule_desc");
        $schedule_id = add_schedule($user_id, $schedule_name, $schedule_desc);
        foreach ($tasks as $task) {
            if (gettype($task) == "string") {
                $task = explode("-", $task);
                $task_name = $task[0];
                $duration = $task[1];
                add_item_to_schedule($schedule_id, $task_name, duration_to_int($duration));
            }
        }
        header("Location: ..");
        break;
    case 'cancel':
        header("Location: ..");
        break;
    default:
        echo ('Unknown action: ' . $action);
        exit();
        break;
}