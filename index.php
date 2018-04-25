<?php

include "util/main.php";

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL)
        $action = "show_log_in";
}

switch ($action) {
    case "show_sign_up":
        include "sign_up.php";
        break;
    case "sign_up":
        $password = filter_input(INPUT_POST, "password");
        $confirm = filter_input(INPUT_POST, "confirm");
        $email = filter_input(INPUT_POST, "email");
        if ($auth->register($email, $password, $confirm)["error"] == 0) {
            $auth->login($email, $password);
            $user_id = $auth->getCurrentUID();
            $first_name = filter_input(INPUT_POST, "first_name");
            $last_name = filter_input(INPUT_POST, "last_name");
            $username = filter_input(INPUT_POST, "username");
            new_user($user_id, $first_name, $last_name, $username);
            header("Location: /" . $web_root . "/dashboard");
        }
        break;
    case "log_in":
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $auth->login($email, $password);
        header("Location: /" . $web_root . "/dashboard");
        break;
    case "logout":
        $auth->logout($auth->getSessionHash());
    default:
        if ($auth->isLogged()) {
            header("Location: /" . $web_root . "/dashboard");
            exit();
        }
        include "view.php";
}