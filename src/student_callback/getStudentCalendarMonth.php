<?php
require("../../config/config.php");
require("../classes/Database.php");

$db = new Database();
$db->connect($databaseConfig);

$date = isset($_COOKIE["date"]) ? $_COOKIE["date"] : null;
$selDate = isset($_COOKIE["selDate"]) ? $_COOKIE["selDate"] : null;
$student = isset($_COOKIE["student"]) ? $_COOKIE["student"] : null;

// This is the month/year to be show in the calendar
// $day = date("j", strtotime($date));
$month = date("n", strtotime($date));
$year = date("Y", strtotime($date));

// Day, month and year from a previously selected date
$selDay = date("j", strtotime($selDate));
$selMonth = date("n", strtotime($selDate));
$selYear = date("Y", strtotime($selDate));

// Today
$dayToday = date("j");
$monthToday = date("n");
$yearToday = date("Y");

// Get number of days in month
$numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
// Get day of the week for the 1st of month/year
$dayOne = date('w', strtotime($year . "-" . $month . "-" . "1"));

// Get all entry for given month
$dateFrom = $year . "-" . $month . "-01";
$dateTo = $year . "-" . $month . "-" . $numDays;
$sql = "SELECT * FROM calendar WHERE (student = ? OR student = ?) AND duration > ? AND date BETWEEN ? AND ?;";
$res = $db->executeFetchAll($sql, [$student, "admin", 0, $dateFrom, $dateTo]);
// Extract dates with booked and available times
$bookedDates = [];
$availDates = [];
$canceledDates = [];
foreach ($res as $booking) {
    if ($booking->student == "admin") {
        array_push($availDates, $booking->date);
    } elseif (!$booking->cancelby) {
        array_push($bookedDates, $booking->date);
    } else {
        array_push($canceledDates, $booking->date);
    }
}

$table = "<table class='table table-bordered'>
    <thead>
        <tr>
            <th class='day-label'>Mon</th>
            <th class='day-label'>Tue</th>
            <th class='day-label'>Wed</th>
            <th class='day-label'>Thu</th>
            <th class='day-label'>Fri</th>
            <th class='day-label'>Sat</th>
            <th class='day-label'>Sun</th>
        </tr>
    </thead>
    <tbody>";

// Empty cells before day one
$emptyCells = $dayOne == 0 ? 6 : $dayOne - 1;
for ($i = 1; $i < $emptyCells + 1; $i++) {
    if ($i == 1) {
        $table .= "<tr>";
    }
    $table .= "<td><input type='submit' class='button' name='day' value='' disabled /></td>";
}

// Cells for every day of the month
for ($i = 1; $i < $numDays + 1; $i++) {
    $weekDay = date('w', strtotime($year . "-" . $month . "-" . $i));
    if ($weekDay == 1) {
        $table .= "<tr>";
    }
    $date = date('Y-m-d', strtotime($year . "-" . $month . "-" . $i));
    $selector = "";
    if ($i == $selDay && $month == $selMonth && $year == $selYear) {
        $selector = "selected ";
    }


    // One single book makes color green
    if (in_array($date, $bookedDates)) {
        $selector .= "booked";
    } elseif (in_array($date, $canceledDates)) {
        $selector .= "canceled ";
    } elseif ($weekDay == 6 || $weekDay == 0) {
        $selector .= "weekend";
    } else {
        $selector .= "normal";
    }

    if ($i == $dayToday && $month == $monthToday && $year = $yearToday) {
        $selector .= " bold";
    }

    if (in_array($date, $availDates)) {
        $asterisk = "*";
    } else {
        $asterisk = "";
    }

    $table .= "<td><div><form method='POST'><input type='hidden' name='hidePanel' value='A'><input type='hidden' name='route' value='student_calendar'><input type='hidden' name='selDate' value='{$date}'><input type='submit' class='button {$selector}' name='day' value='{$i}{$asterisk}'></form></div></td>";
    if ($weekDay == 0) {
        $table .= "</tr>";
    }
}

// Empty cells after last day of the month
$weekDay = date('w', strtotime($year . "-" . $month . "-" . $numDays));
if ($weekDay != 0) {
    for ($day = $weekDay; $day < 7; $day++) {
        $table .= "<td><input type='submit' class='button' name='day' value='' disabled /></td>";
    }
}

$table .= "</tr>";
$table .= "</tbody></table><div>(*) Dates with available times</div>";
echo $table;
