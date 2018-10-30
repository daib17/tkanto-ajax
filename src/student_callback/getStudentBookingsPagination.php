<?php
require("../../config/config.php");
require("../classes/Database.php");

const ITEMS_PAGE = 5;

$db = new Database();
$db->connect($databaseConfig);

$student = isset($_COOKIE["student"]) ? $_COOKIE["student"] : null;
$actualPage = isset($_COOKIE["page"]) ? $_COOKIE["page"] : 1;

$sql = "SELECT * FROM calendar WHERE student = ? AND date >= DATE(NOW()) AND duration > ?;";
$res = $db->executeFetchAll($sql, [$student, 0]);
if (!$res || count($res) < ITEMS_PAGE + 1) {
    echo "";
}

$pages = ceil(count($res) / ITEMS_PAGE);
// Pagination
$table = "";
$table .= "<nav>";
$table .= "<ul class='pagination justify-content-center'>";

for ($id = 1; $id < $pages + 1; $id++) {
    $active = ($id == $actualPage) ? "active" : "";
    $table .= "<form method='POST'><input type='hidden' name='route' value='student_bookings'><li class='page-item {$active}'><input type='submit' class='page-link' name='page' value={$id}></li></form>";
}

$table .= "</ul>";
$table .= "</nav>";
echo $table;
