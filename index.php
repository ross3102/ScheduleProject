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
        $failed = false;
        include "sign_up.php";
        break;
    case "sign_up":
        $password = filter_input(INPUT_POST, "password");
        $confirm = filter_input(INPUT_POST, "confirm");
        $email = filter_input(INPUT_POST, "email");
        $username = filter_input(INPUT_POST, "username");
        if (!username_in_use($username)) {
            $result = $auth->register($email, $password, $confirm, array(), null, true);
//            if ($result["error"] == 0) {
//                $auth->login($email, $password);
//                $user_id = $auth->getCurrentUID();
//                $first_name = filter_input(INPUT_POST, "first_name");
//                $last_name = filter_input(INPUT_POST, "last_name");
//                new_user($user_id, $first_name, $last_name, $username);
//            }
        } else
            $result = array("error" => 1, "message" => "The username " . $username . " is already in use.");
        $data = array("location" => $result["error"] == 0 ? "/" . $web_root . "dashboard": null, "message" => $result["message"]);
        header('Content-Type: application/json');
        echo json_encode($data);
        break;
    case "log_in":
        $email = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $result = $auth->login($email, $password);
        if ($result["error"] == 0)
            $data = array("location" => "/" . $web_root . "dashboard");
        else {
            $username = $email;
            $email = get_user_by_username($username)["email"];
            $result = $auth->login($email, $password);
            if ($result["error"] == 0)
                $data = array("location" => "/" . $web_root . "dashboard");
            else {
                $data = array("location" => null, "message" => $result["message"]);
                if ($data["message"] === "Email address / password are incorrect.")
                    $data["message"] = "Invalid Credentials";
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        break;
    case "logout":
        $auth->logout($auth->getSessionHash());
    default:
        if ($auth->isLogged()) {
            header("Location: /" . $web_root . "dashboard");
            exit();
        }
        $failed = false;
        include "view.php";
}