<?php
require("../../config/config.php");
require("../classes/Database.php");
require("../admin_functions.php"); // doSearch, getStudentsByStatus

$db = new Database();
$db->connect($databaseConfig);

$filterId = isset($_COOKIE["filter"]) ? $_COOKIE["filter"] : 2;
$actualPage = isset($_COOKIE["page"]) ? $_COOKIE["page"] : 1;
$search = isset($_COOKIE["search"]) ? $_COOKIE["search"] : "";

if ($search != "") {
    $res = doSearch($db, $search);
    $searchInput = "<input type='hidden' name='search' value='{$search}' />";
} else {
    $res = getStudentsByStatus($db, $filterId);
    $searchInput = "";
}

if ($res == null || count($res) < ITEMS_PAGE + 1) {
    return "";
}

$pages = ceil((count($res) / ITEMS_PAGE));
// Pagination
$table = "";
$table .= "<nav>";
$table .= "<ul class='pagination justify-content-center'>";

for ($id = 1; $id < $pages + 1; $id++) {
    $active = $id == $actualPage ? "active" : "";
    $table .= "<form method='POST'><input type='hidden' name='route' value='admin_students_1'>{$searchInput}<input type='hidden' name='filter' value={$filterId}/><li class='page-item {$active}'><input type='submit' class='page-link' name='page' value={$id}></li></form>";
}

$table .= "</ul>";
$table .= "</nav>";
echo $table;
