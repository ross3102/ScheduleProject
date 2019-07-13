<?php

include "../util/main.php";
include "../model/taskdb.php";

verify_logged();

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'show_calendar';
    }
}

$month_num = date('m');
$year_num = date('Y');

$weekday = date('w', strtotime($year_num . "-" . $month_num . "-1"));

switch ($action) {
    case 'show_month':
        $month_num = filter_input(INPUT_GET, 'month');
        $year_num = filter_input(INPUT_GET, "year");
        $weekday = date('w', strtotime($year_num . "-" . $month_num . "-1"));
    case 'show_calendar':
        $categories = get_categories_by_user_id($user["id"]);
        $all_tasks = get_task_list($user["id"]);
        include "view.php";
        break;
    case 'show_hide_category':
        $category_id = filter_input(INPUT_GET, "category_id");
        $show = filter_input(INPUT_GET, "show");
        show_hide($category_id, $show);
        break;
//    case 'add_category':
//        $category_name = filter_input(INPUT_POST, "category_name");
//        add_category($user["id"], $category_name, "#000000");
//        header("Location: .");
//        break;
//    case 'add_task':
//        $category_id = filter_input(INPUT_POST, "task_category");
//        $task_name = filter_input(INPUT_POST, "task_name");
//        $task_date = filter_input(INPUT_POST, "task_date");
//        $task_date = DateTime::createFromFormat('j F, Y', $task_date);
//        add_task_to_category($category_id, $task_name, $task_date->format('Y-m-d'));
//        header("Location: .");
//        break;
//    case 'edit_category':
//        $category_id = filter_input(INPUT_POST, "category_id");
//        $category_name = filter_input(INPUT_POST, "category_name");
//        edit_category($category_id, $category_name);
//        header("Location: .");
//        break;
//    case 'edit_task':
//        $task_id = filter_input(INPUT_POST, "task_id");
//        $task_name = filter_input(INPUT_POST, "task_name");
//        $category_id = filter_input(INPUT_POST, "task_category");
//        $task_date = filter_input(INPUT_POST, "task_date");
//        $task_date = DateTime::createFromFormat('j F, Y', $task_date);
//        edit_task($task_id, $task_name, $task_date->format('Y-m-d'), $category_id);
//        header("Location: .");
//        break;
//    case 'delete_category':
//        $category_id = filter_input(INPUT_GET, "category_id");
//        delete_category($category_id);
//        header("Location: .");
//        break;
//    case 'change_color':
//        $category_id = filter_input(INPUT_GET, "category_id");
//        $color = filter_input(INPUT_GET, "color");
//        change_color($category_id, "#" . $color);
//        break;
//    case 'complete':
//        $task_id = filter_input(INPUT_GET, "task_id");
//        $task_completed = filter_input(INPUT_GET, "task_completed");
//        complete($task_id, $task_completed);
//        break;
//    case 'collapse':
//        $category_id = filter_input(INPUT_GET, "category_id");
//        $category_active = filter_input(INPUT_GET, "category_active");
//        collapse($category_id, $category_active);
//        break;
    default:
        echo ('Unknown action: ' . $action);
        exit();
}