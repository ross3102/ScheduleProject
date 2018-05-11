<?php
include "../util/main.php";

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL)
        $action = "show_activate";
}

switch ($action) {
    case "activate":
        $key = filter_input(INPUT_POST, "key");
        $result = $auth->activate($key);
        header('Content-Type: application/json');
        echo json_encode($result);
        break;
    case "show_resend":
        include "resend.php";
        break;
    case "resend":
        $email = filter_input(INPUT_POST, "email");
        $result = $auth->resendActivation($email, true);
        header('Content-Type: application/json');
        echo json_encode($result);
        break;
    default:
        include "view.php";
}