<?php
require("../../config/config.php");
require("../classes/Database.php");
require("../admin_functions.php");  // generateHourArrayFromDB

$db = new Database();
$db->connect($databaseConfig);

// $date = isset($_COOKIE["date"]) ? $_COOKIE["date"] : null;
// $hourStr = isset($_COOKIE["hourStr"]) ? $_COOKIE["hourStr"] : "";

// Array (0 to 27) of Hour objects for selected date from DB
// $arr = generateHourArrayFromDB($db, $date);

// Get all active students from database
$sql = "SELECT * FROM student WHERE status LIKE ? AND username != ? ORDER BY lastname, firstname;";
$res = $db->executeFetchAll($sql, [2, "admin"]);

$spinHTML = "<select id='studentSpinner' class='form-control'>";
$spinHTML .= "<option value='noStudent'>Select student</option>";

foreach ($res as $row) {
    $spinHTML .= "<option value='{$row->username}'>{$row->firstname} {$row->lastname}</option>";
}

$spinHTML .= "</select>";
echo $spinHTML;
