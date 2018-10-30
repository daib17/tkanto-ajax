<?php
require("../../config/config.php");
require("../classes/Database.php");

$db = new Database();
$db->connect($databaseConfig);

$student = isset($_COOKIE["student"]) ? $_COOKIE["student"] : null;

$sql = "(SELECT *, bookdate AS d, 'book' AS action FROM calendar WHERE student
= ? AND duration > ?) UNION ALL (SELECT *, canceldate AS d, 'cancel' AS action FROM calendar WHERE student
= ? AND duration > ?) ORDER BY d DESC LIMIT 15;";
$res = $db->executeFetchAll($sql, [$student, 0, $student, 0]);

$table = "<table class='table table-bordered table-selectable'>
    <thead>
        <tr>
            <th scope'col'>Action</th>
            <th scope'col'>Booking</th>
            <th scope'col'>Log</th>
        </tr>
    </thead>
    <tbody>";

// Empty log
if (!$res) {
    $table .= "<tr>";
    $table .= "<td colspan=3 class='empty-cell'>Log is empty.</td>";
    $table .= "</tr>";
    $table .= "</tbody></table>";
    echo $table;
    return;
}

foreach ($res as $row) {
    $table .= "<tr>";
    // From
    $from = sprintf("%04d", $row->time);
    $from = substr_replace($from, ":", 2, 0);
    $from = ltrim($from, "0");
    $timeLabel = $from;
    // Format dates
    $date = date('j M', strtotime($row->date));
    // Entries with no cancel date get null 'd' column after select
    if (!$row->d) {
        continue;
    }
    $action = ($row->action == "cancel") ? "cancel (" . $row->cancelby . ")" : "book";
    $booking =  $date . " (" . $timeLabel . ")";
    $log = date('j M H:i', strtotime($row->d));

    $table .= "<td class='text'>$action</td>";
    $table .= "<td class='text'>$booking</td>";
    $table .= "<td class='text'>$log</td>";
    $table .= "</tr>";
}

$table .= "</tbody></table>";
echo $table;
