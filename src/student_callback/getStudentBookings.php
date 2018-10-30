<?php
require("../../config/config.php");
require("../classes/Database.php");

const ITEMS_PAGE = 5;

$db = new Database();
$db->connect($databaseConfig);

$student = isset($_COOKIE["student"]) ? $_COOKIE["student"] : null;
$page = isset($_COOKIE["page"]) ? $_COOKIE["page"] : 1;
$selDate = isset($_COOKIE["selDate"]) ? $_COOKIE["selDate"] : null;
$selTime = isset($_COOKIE["selTime"]) ? $_COOKIE["selTime"] : null;

$items_page = ITEMS_PAGE;
$offset = ($page - 1) * $items_page;
$sql = "SELECT * FROM calendar WHERE student = ? AND date >= DATE(NOW()) AND duration > ? ORDER BY date, time LIMIT $items_page OFFSET $offset;";
$res = $db->executeFetchAll($sql, [$student, 0]);

$table = "<table class='table table-bordered table-selectable'>
    <thead>
        <tr>
            <th scope='col' colspan='2'>Date</th>
            <th scope='col'>Time</th>
            <th scope='col'>Duration</th>
        </tr>
    </thead>
    <tbody>";

// Get bookings from db
for ($i = 0; $i < $items_page; $i++) {
    if ($res && $i < count($res)) {
        // Date
        $date = $res[$i]->date;
        $time = $res[$i]->time;
        // Time
        if (strlen($res[$i]->time) == 3)
        $timeLabel = substr_replace($res[$i]->time, ':', 1, 0);
        else
        $timeLabel = substr_replace($res[$i]->time, ':', 2, 0);
        $durationLabel = ($res[$i]->duration == 30) ? "(30')" : "(60')";
        // Duration
        $duration = $res[$i]->duration;

        $selected = ($date == $selDate && $time == $selTime && !$res[$i]->cancelby) ? "selected" : "non-selected";

        $submit = "";
        if ($res[$i]->cancelby == null) {
            $submit="<input type='submit' class='{$selected}' name='selDate' value='{$date}'>";
        } else {
            $submit="<div class='non-button-left'>{$date}</div>";
        }

        // Add cancelation note
        $cancel = "";
        if ($res[$i]->cancelby) {
            $duration = "<span class='canceled'>Canceled</span>";
            $cancel = "<input type='hidden' name='isCanceled' value='true'>";
        }

        $table .= "<tr>";
        $table .= "<td colspan=2><form method='POST'><input type='hidden' name='route' value='student_bookings'>{$cancel}<input type='hidden' name='selTime' value={$time}><input type='hidden' name='page' value={$page} />{$submit}</form></td>";
        $table .= "<td>{$timeLabel}</td>";
        $table .= "<td>{$duration}</td>";
        $table .= "</tr>";
    } else {
        // Empty row
        $table .= "<tr>";
        $table .= "<td colspan=2><div class='empty'>Empty</div></td>";
        $table .= "<td><div class='empty'>Empty</div></td>";
        $table .= "<td><div class='empty'>Empty</div></td>";
        $table .= "</tr>";
    }
}

$table .= "</tbody></table>";

echo $table;
