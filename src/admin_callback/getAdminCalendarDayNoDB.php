<?php
require("../../config/config.php");
require("../admin_functions.php");  // generateHourArrayFromDB



$table = "<table class='table table-bordered'><body>";
$id = 0;
for ($row = 0; $row < 7; $row++) {
    $table .= "<tr>";
    for ($id = $row * 4; $id < ($row * 4) + 4; $id++) {
        // Time label
        $hour = (int)($id / 2) + 8;
        $half = ($id % 2 == 1) ? ":30" : ":00";
        $time = $hour . $half;
        // Background color for cell
        $color = "";
        $table .= "<td><input id='h{$id}' type='submit' class='button empty' name='hourLabel' value='{$time}' /></td>";
    }
    $table .= "</tr>";
}

$table .= "</body></table>";
