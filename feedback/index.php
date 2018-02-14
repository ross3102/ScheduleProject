<?php

include "../util/main.php";

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'show_form';
    }
}

switch ($action) {
    case 'show_form':
        include "view.php";
        break;
    case 'send':
        header("Location: ../dashboard/index.php");
        break;
}