<?php
require("../../config/config.php");
require("../classes/Database.php");
require("../admin_functions.php");  // generateHourArrayFromDB

$db = new Database();
$db->connect($databaseConfig);

$date = isset($_COOKIE["date"]) ? $_COOKIE["date"] : null;
$hourLabel = isset($_COOKIE["hourStr"]) ? $_COOKIE["hourStr"] : "";

// Array (0 to 27) of Hour objects for selected date from DB
$hourArr = generateHourArrayFromDB($db, $date);

$table = "<table class='table table-bordered'><body>";
$id = 0;
for ($row = 0; $row < 7; $row++) {
    $table .= "<tr>";
    for ($id = $row * 4; $id < ($row * 4) + 4; $id++) {
        // Booked label showing only for bookings and canceled with flag
        $bookedBy = "";
        if (!$hourArr[$id]->getCancelBy() || $hourArr[$id]->getFlag() == 1) {
            $bookedBy = $hourArr[$id]->getStudent();
        }
        // Time label
        $hour = (int)($id / 2) + 8;
        $half = ($id % 2 == 1) ? ":30" : ":00";
        $time = $hour . $half;
        // Background color for cell
        $color = "";
        if ($hourArr[$id]->getDuration() == 0) {
            // Second 30 min slot for 60 min booking
            if ($hourArr[$id]->getFlag() == 1) {
                $disabled = "flag-disabled";
            } elseif ($hourArr[$id - 1]->getStudent() == "admin") {
                $disabled = "free-disabled";
            } else {
                $disabled = "booked-disabled";
            }
            $table .= "<td><input id='h{$id}' type='submit' class='button {$disabled}' name='hourLabel' value='' /></td>";
        } else {
            if ($time == $hourLabel) {
                $color = "selected ";
            }
            if ($bookedBy == "admin") {
                $color .= "free";
            } elseif ($bookedBy != "" && $hourArr[$id]->getFlag() == 1) {
                $bookedBy .= "*";
                $color .= "flag";
            } elseif ($bookedBy != "" && $hourArr[$id]->getFlag() == 0) {
                $color .= "booked";
            } else {
                $color .= "empty";
            }
            $table .= "<td><input id='h{$id}' type='submit' class='button {$color}' name='hourLabel' value='{$time} {$bookedBy}' /></td>";
        }
    }
    $table .= "</tr>";
}

$table .= "</body></table>";
echo $table;
