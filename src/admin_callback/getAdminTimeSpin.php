<?php
require("../../config/config.php");
require("../classes/Database.php");
require("../admin_functions.php");  // generateHourArrayFromDB

$db = new Database();
$db->connect($databaseConfig);

$date = isset($_COOKIE["date"]) ? $_COOKIE["date"] : null;
$hourStr = isset($_COOKIE["hourStr"]) ? $_COOKIE["hourStr"] : "";

// Array (0 to 27) of Hour objects for selected date from DB
$arr = generateHourArrayFromDB($db, $date);

// Convert string time to integer
if ($hourStr != "") {
    $str = explode(":", $hourStr);
    $time = (int)$str[0] * 100 + (int)$str[1];
    // Get id in array for given hour
    $id = (((int)($time / 100)) - 8) * 2;
    if ($time % 100 != 0) {
        $id++;
    }
}

// Return if no hour has been selected yet or no admin time
if ($hourStr == "") {
    $spinHTML = "<select id='timeSpinner' class='form-control' disabled>";
    $spinHTML .= "<option value='0'>0</option>";
    $spinHTML .= "</select>";
    echo $spinHTML;
    return;
}

// Calculate id in array for time in db (800 is 0, 2130 is 27)
$id = (((int)($time / 100)) - 8) * 2;
if ($time % 100 != 0) {
    $id++;
}

$duration = $arr[$id]->getDuration();
$student = $arr[$id]->getStudent();

// Only admin and available hours are changeable
if ($student != "admin" && $student != "") {
    $spinHTML = "<select id='timeSpinner' class='form-control' disabled>";
    $spinHTML .= "<option value=''>{$duration}</option>";
    $spinHTML .= "</select>";
    echo $spinHTML;
    return;
}

$spinHTML = "<select id='timeSpinner' class='form-control'>";
if ($duration == 0) {
    $spinHTML .= "<option value='0' selected>0</option>";
} else {
    $spinHTML .= "<option value='0'>0</option>";
}

if ($duration == 30 ) {
    $spinHTML .= "<option value='30' selected>30</option>";
} else {
    $spinHTML .= "<option value='30'>30</option>";
}
// Check if next slot is available
if ($duration == 60) {
    $spinHTML .= "<option value='60' selected>60</option>";
} elseif ($student == "admin") {

}
if ($id < 27) {
    if ($arr[$id + 1]->getDuration() == -1 || (
        $arr[$id + 1]->getStudent() == "admin" &&
        $arr[$id + 1]->getDuration() == 30
    )) {
        $spinHTML .= "<option value='60'>60</option>";
    }
}

$spinHTML .= "</select>";
echo $spinHTML;
