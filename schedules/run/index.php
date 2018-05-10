<?php

include "../../util/main.php";
include "../../model/scheduledb.php";

verify_logged();

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'confirm';
    }
}


switch ($action) {
    case 'confirm':
        $schedule_id = filter_input(INPUT_GET, "schedule_id");
        $items = get_items_by_schedule_id($schedule_id);
        $schedule = get_schedule_by_id($schedule_id);
        include "confirm_run.php";
        break;
    case 'run':
        $schedule_id = filter_input(INPUT_GET, "schedule_id");
        $items = get_items_by_schedule_id($schedule_id);
        $schedule = get_schedule_by_id($schedule_id);
        include "view.php";
        break;
}