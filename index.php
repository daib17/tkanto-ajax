<?php
require_once("config/autoload.php");
require_once("config/config.php");
require_once("src/helper_functions.php");
// require "src/classes/Database.php";

// Global variables
// $headerAction = "Log out";
$controller = [];
$view = [];
$db = new Database();
$db->connect($databaseConfig);
// $sql = null;
// $resultset = null;

// Route
$route = getPost("route") ?? getGet("route");

switch ($route) {
    case "":
    case "login":
        $title = "Tk | Login";
        $controller = ["controller/login.php"];
        $view = ["incl/navbar_login.php", "view/login.php", "incl/footer.php"];
        break;
    case "register":
        $title = "Tk | Register";
        $controller = ["controller/register.php"];
        $view = ["incl/navbar_login.php", "view/register.php", "incl/footer.php"];
        break;
    case "student_calendar":
        if (!($_SESSION["user"] ?? null)) {
            header("Location: ?route=login");
            exit();
        }
        $title = "Tk | Student";
        $controller = ["controller/student_calendar.php"];
        $view = ["incl/navbar_logout.php", "view/student_calendar.php", "incl/footer_loading.php"];
        break;
    case "student_bookings":
        if (!($_SESSION["user"] ?? null)) {
            header("Location: ?route=login");
            exit();
        }
        $title = "Tk | Student";
        $controller = ["controller/student_bookings.php"];
        $view = ["incl/navbar_logout.php", "view/student_bookings.php", "incl/footer_loading.php"];
        break;
    case "student_recent":
        if (!($_SESSION["user"] ?? null)) {
            header("Location: ?route=login");
            exit();
        }
        $title = "Tk | Student";
        $controller = ["controller/student_recent.php"];
        $view = ["incl/navbar_logout.php", "view/student_recent.php", "incl/footer_loading.php"];
        break;
    case "admin_students_1":
        if (!$_SESSION["user"] || $_SESSION["user"] != "admin") {
            header("Location: ?route=login");
            exit();
        }
        $title = "Tk | Admin";
        $controller = ["controller/admin_students_1.php"];
        $view = ["incl/navbar_logout.php", "view/admin_students_1.php", "incl/footer_loading.php"];
        break;
    case "admin_students_2":
        if (!$_SESSION["user"] || $_SESSION["user"] != "admin") {
            header("Location: ?route=login");
            exit();
        }
        $title = "Tk | Admin";
        $controller = ["controller/admin_students_2.php"];
        $view = ["incl/navbar_logout.php", "view/admin_students_2.php", "incl/footer_loading.php"];
        break;
    case "admin_recent":
        if (!$_SESSION["user"] || $_SESSION["user"] != "admin") {
            header("Location: ?route=login");
            exit();
        }
        $title = "Tk | Admin";
        $controller = ["controller/admin_recent.php"];
        $view = ["incl/navbar_logout.php", "view/admin_recent.php", "incl/footer_loading.php"];
        break;
    case "admin_calendar_1":
        if (!$_SESSION["user"] || $_SESSION["user"] != "admin") {
            header("Location: ?route=login");
            exit();
        }
        $title = "Tk | Admin";
        $controller = ["controller/admin_calendar_1.php"];
        $view = ["incl/navbar_logout.php", "view/admin_calendar_1.php", "incl/footer_loading.php"];
        break;
    case "admin_calendar_2":
        if (!$_SESSION["user"] || $_SESSION["user"] != "admin") {
            header("Location: ?route=login");
            exit();
        }
        $title = "Tk | Admin";
        $controller = ["controller/admin_calendar_2.php"];
        $view = ["incl/navbar_logout.php", "view/admin_calendar_2.php", "incl/footer_loading.php"];
        break;
    case "admin_stats":
        if (!$_SESSION["user"] || $_SESSION["user"] != "admin") {
            header("Location: ?route=login");
            exit();
        }
        $title = "Tk | Admin";
        $controller = ["controller/admin_stats.php"];
        $view = ["incl/navbar_logout.php", "view/admin_stats.php", "incl/footer_loading.php"];
        break;
    case "pass_recovery":
        $title = "Tk | Recovery";
        $controller = ["controller/pass_recovery.php"];
        $view = ["incl/header.php", "view/pass_recovery.php", "incl/footer.php"];
        break;
}

require "incl/header.php";

// Controller
foreach ($controller as $value) {
    require $value;
}

// Render view
foreach ($view as $value) {
    require $value;
}
