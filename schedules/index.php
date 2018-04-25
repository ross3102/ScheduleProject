<?php

include "../util/main.php";
include "../model/scheduledb.php";

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'list_schedules';
    }
}


switch ($action) {
    case 'list_schedules':
        $schedules = get_schedules_by_user_id($user["id"]);
        $modal = filter_input(INPUT_GET, "modal");
        include "view.php";
        break;
    case 'add_schedule':
        $schedule_name = filter_input(INPUT_POST, "schedule_name");
        $schedule_desc = filter_input(INPUT_POST, "schedule_desc");
        add_schedule($user["id"], $schedule_name, $schedule_desc);
        header("Location: .");
        break;
    case 'add_item':
        $schedule_id = filter_input(INPUT_POST, "schedule_id");
        $item_name = filter_input(INPUT_POST, "item_name");
        $item_duration = duration_to_int(filter_input(INPUT_POST, "item_duration"));
        $item_desc = filter_input(INPUT_POST, "item_desc");
        add_item_to_schedule($schedule_id, $item_name, $item_duration, $item_desc);
        header("Location: ./index.php?modal=" . $schedule_id);
        break;
    case 'delete_schedule':
        $schedule_id = filter_input(INPUT_GET, "schedule_id");
        delete_schedule($schedule_id);
        header("Location: .");
        break;
    case 'delete_item':
        $item_id = filter_input(INPUT_GET, "item_id");
        $schedule_id = get_item_by_id($item_id)["schedule_id"];
        delete_item($item_id);
        header("Location: ./index.php?modal=" . $schedule_id);
        break;
    case 'run':
        header("Location: ./run/index.php?schedule_id=" . filter_input(INPUT_GET, "schedule_id"));
        break;
    case 'show_build_schedule':
        header("Location: ./build/index.php");
        break;
    default:
        echo ('Unknown action: ' . $action);
        exit();
        break;
}