<?php
require("../../config/config.php");
require("../classes/Database.php");

$db = new Database();
$db->connect($databaseConfig);

$date = isset($_COOKIE["selDate"]) ? $_COOKIE["selDate"] : null;
$student = isset($_COOKIE["student"]) ? $_COOKIE["student"] : null;
$selHour = isset($_COOKIE["selHour"]) ? $_COOKIE["selHour"] : null;

$sql = "SELECT * FROM calendar WHERE date = ? AND (student = ? OR student = ?) AND duration > ? ORDER BY time;";
$res = $db->executeFetchAll($sql, [$date, $student, "admin", 0]);

// No results?
$table = "<table class='table table-bordered'><tbody>";


if (count($res) > 0) {
    // Generate table
    foreach ($res as $row) {
        $table .= "<tr>";
        $from = $row->time;
        if ($row->duration == 60) {
            $to = $from + 100;
        } else {
            $to = ($from % 100 == 0) ? $from + 30 : $from + 70;
        }
        if (strlen($from) == 3)
            $from = substr_replace($from, ':', 1, 0);
        else
            $from = substr_replace($from, ':', 2, 0);

        if (strlen($to) == 3)
            $to = substr_replace($to, ':', 1, 0);
        else
            $to = substr_replace($to, ':', 2, 0);

        // Labels
        $timeLabel = $from . " - " . $to;
        if ($row->duration == 30) {
            $timeLabel .= " *";
        }

        $selected = ($row->time == $selHour && !$row->cancelby) ? "selected" : "non-selected";

        $submit = "";
        if ($row->cancelby == null) {
            $submit="<input type='submit' class='button {$selected}' name='' value='{$timeLabel}'>";
        } else {
            $submit="<div class='non-button'>{$timeLabel}</div>";
        }

        // Show canceled only by admin and when no open alternative
        if ($row->cancelby) {
            $statusLabel = "canceled by " . $row->cancelby;
            $color = "canceled";
        } else {
            $statusLabel = ($row->student == $student) ? "booked" : "available";
            $color = ($row->student == $student) ? "booked" : "available";
        }

        // Time td
        $table .= "<td><form method='POST'><input type='hidden' name='route' value='student_calendar'><input type='hidden' name='hidePanel' value='A'><input type='hidden' name='selDate' value='{$date}'><input type='hidden' name='selHour' value={$row->time}><input type='hidden' name='statusLabel' value='{$statusLabel}'>{$submit}</form></td>";
        // Status td
        $table .= "<td class='{$color}'>{$statusLabel}</td>";
        $table .= "</tr>";
    }
}

// Empty res or only canceled bookings?
if ($table == "<table class='table table-bordered'><tbody>") {
    $table .= "<tr>";
    $table .= "<td colspan=2 class='empty-cell'>No available times on this date</td>";
    $table .= "</tr>";
    $table .= "</tbody></table>";
    echo $table;
    return;
}

$table .= "</tbody></table>";
$table .= "<div>(*) 30 min classes</div>";
echo $table;
