<?php

include "../../util/main.php";
include "../../model/taskdb.php";
include "../../model/scheduledb.php";

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'build_schedule';
    }
}


switch ($action) {
    case 'build_schedule':
        $task_list = get_task_list($user["user_id"]);
        include "view.php";
        break;
    case 'confirm_build_schedule':
        // TODO ids parameter too long for get request
        $ids = json_decode(filter_input(INPUT_GET, "ids"));
        $schedule_name = filter_input(INPUT_GET, "schedule_name");
        $schedule_desc = filter_input(INPUT_GET, "schedule_desc");
        $schedule_id = add_schedule($user_id, $schedule_name, $schedule_desc);
        foreach ($ids as $id) {
            if (gettype($id) == "string") {
                $id = explode("-", $id);
                $task = get_task_by_id($id[0]);
                $task_name = $task["task_name"];
                $duration = $id[1];
                $desc = $id[2];
                add_item_to_schedule($schedule_id, $task_name, duration_to_int($duration), $desc);
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