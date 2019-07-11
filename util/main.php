<?php

include dirname(__FILE__) . "/../model/userdb.php";

$db_name = getenv('db_name');
if ($db_name == null)
    require_once dirname(__FILE__) . "/../../config.php";
else {
    $username = getenv('username');
    $password = getenv('password');
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $web_root = getenv('web_root');
    $app_title = getenv('app_title');
    $db_host = getenv('db_host');
}

try {
    $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name;
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    error_log("Unable to connect to database: " . $e->getMessage(), 0);
    echo ("Unable to connect to database: " . $e->getMessage());
    exit;
}

include(dirname(__FILE__) . "/../js/PHPAuth-master/Config.php");
include(dirname(__FILE__) . "/../js/PHPAuth-master/Auth.php");

$config = new PHPAuth\Config($db);
$auth   = new PHPAuth\Auth($db, $config);

$user_id = $auth->getCurrentUID();

$user = get_user_by_id($user_id);

function verify_logged() {
    global $auth, $web_root;
    if (!$auth->isLogged()) {
        header("Location: /" . $web_root . "index.php");
        exit();
    }
}

// Pages

$TASK_LIST = "task_list";
$SCHEDULES = "schedules";
$CALENDAR = "calendar";

function pad($num, $target) {
    $num = array_map('intval', str_split($num));
    $os = "";
    $length = count($num);
    while ($length + strlen($os) < $target) {
        $os .= "0";
    }
    return $os . implode($num);
}

function duration_to_int($item_duration) {
    $item_duration = explode(":", $item_duration);
    return $item_duration[0] * 3600 + $item_duration[1] * 60 + $item_duration[2];
}

function int_to_duration($item_duration) {
    $item_hours = intdiv($item_duration, 3600);
    $item_hours  = pad($item_hours, 1);
    $item_duration %= 3600;
    $item_minutes = intdiv($item_duration, 60);
    $item_minutes = pad($item_minutes, 2);
    $item_duration %= 60;
    $item_duration = pad($item_duration, 2);
    return $item_hours . ":" . $item_minutes . ":" . $item_duration;
}

function writeHeader($currentPage, $head='') {
    global $web_root, $app_title, $user, $auth, $TASK_LIST, $SCHEDULES, $CALENDAR;
    echo '
    <html>
    <head>
        <title>BCA Task Manager</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link type="text/css" rel="stylesheet" href="/' . $web_root . 'css/shared.css">
        <script src="/' . $web_root . 'js/jq.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        ' . $head . '
    </head>
    <body>
    <header>' . ($auth->isLogged() ? '
        <ul class="dropdown-content blue lighten-1" id="account-dropdown-big">
            <li><a class=white-text href="/' . $web_root . 'index.php?action=logout"><i class="material-icons">exit_to_app</i> Log Out</a></li>
        </ul>
        <ul class="dropdown-content" id="account-dropdown-small">
            <li><a href="/' . $web_root . 'index.php?action=logout"><i class="material-icons">exit_to_app</i> Log Out</a></li>
        </ul>
        ': '') . '
        <nav class="blue lighten-1" style="padding-left: 3%; white-space: nowrap;">
            <div class="nav-wrapper">
                <a href="/' . $web_root . 'work" class="brand-logo">' . $app_title . '</a>' .
                ($auth->isLogged() ? '
                <a data-target="slide-out" class="sidenav-trigger"><i class="material-icons clickable">menu</i></a>
                <ul id="nav_links" class="right hide-on-med-and-down">
                    <li id="page_' . $TASK_LIST . '">
                        <a href="/' . $web_root . 'work">
                            <i class="material-icons left">view_list</i> Task List
                        </a>
                    </li>
                    <li id="page_' . $CALENDAR . '">
                        <a href="/' . $web_root . 'calendar">
                            <i class="material-icons left">today</i> View Calendar
                        </a>
                    </li>
                    <li id="page_' . $SCHEDULES . '">
                        <a href="/' . $web_root . 'schedules">
                            <i class="material-icons left">timer</i> Manage Schedules
                        </a>
                    </li>
                    <li>
                    <a class="dropdown-trigger" data-target="account-dropdown-big">
                        <i class="material-icons left">person</i> Hello, ' . $user["user_first_name"] . '<i class="material-icons right">arrow_drop_down</i>
                    </a>
                    </li>
                </ul>
                <script>
                    $("#page_' . $currentPage . '").addClass("active")
                </script>
                <ul class="sidenav" id="slide-out">
                    <li><a href="/' . $web_root . 'work">
                        <i class="material-icons">view_list</i> Task List
                    </a></li>
                    <li><a href="/' . $web_root . 'calendar">
                        <i class="material-icons">today</i> View Calendar
                    </a></li>
                    <li><a href="/' . $web_root . 'schedules">
                        <i class="material-icons">timer</i> Manage Schedules
                    </a></li>
                    <li>
                        <a class="dropdown-trigger" data-target="account-dropdown-small">
                            <i class="material-icons">person</i>
                            Hello, ' . $user["user_first_name"] . '
                            <i class="material-icons right">arrow_drop_down</i>
                        </a>
                    </li>
                </ul>': '') .
            '</div>
        </nav>
    </header>
    <main>
        <div class="row pageLayout">
            <div class="col s12">
    ';
}

function writeFooter() {
    global $app_title;
    echo '
    </div>
    </div>
    </main>
    <footer class="page-footer blue lighten-1">
        <div class="container">
            <div class="row">
                <div class="col s6">
                <h4>' . $app_title . '</h4>
                    <p>By Ross Newman</p>
                </div>
                <div class="col s6">
                    <h5>BCA Task Manager has ' . numUsers() . ' users!</h5>
                    <!--<h5>Contact</h5>
                    <ul>
                        <li>Cell: 201-994-9454</li>
                    </ul>-->
                </div>
            </div>
        </div>
    </footer>
    </body>
    <script>
        $(document).ready(function() {
            $(".tooltipped").tooltip({
                "enterDelay": 200,
                "position": "top"
            });
            $(".sidenav").sidenav();
            $(".dropdown-trigger").dropdown({
                hover: true,
                coverTrigger: false
            });
        });
    </script>
    </html>';
}

function create_dashboard_item($link, $title, $description, $icon) {
    echo "<a class='collection-item avatar' href='../" . $link . "'>
            <i class='material-icons circle red'>" . $icon . "</i>
            <h6 class='dash-title'>" . $title . "</h6>
            <p class='small-text'>" . $description . "</p>
        </a>";
}

function addTime($time, $duration) {
    $secs = strtotime($duration) - strtotime("00:00:00");
    return date("h:i:s",strtotime($time)+$secs);
}