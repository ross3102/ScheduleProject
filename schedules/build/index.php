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
        $names = array_values(get_object_vars(json_decode(filter_input(INPUT_GET, "names"))));
        $times = array_values(get_object_vars(json_decode(filter_input(INPUT_GET, "times"))));
        $schedule_name = filter_input(INPUT_GET, "schedule_name");
        $schedule_desc = filter_input(INPUT_GET, "schedule_desc");
        $schedule_id = add_schedule($user_id, $schedule_name, $schedule_desc);
        for ($t = 0; $t < count($names) - 2; $t++) {
            add_item_to_schedule($schedule_id, $names[$t], duration_to_int($times[$t]));
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