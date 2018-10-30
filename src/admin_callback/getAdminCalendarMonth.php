<?php
require("../../config/config.php");
require("../classes/Database.php");

$db = new Database();
$db->connect($databaseConfig);

$date = isset($_COOKIE["date"]) ? $_COOKIE["date"] : null;
$selDate = isset($_COOKIE["selDate"]) ? $_COOKIE["selDate"] : null;

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
$table = "";
// Get day of the week for the 1st of month/year
$dayOne = date('w', strtotime($year . "-" . $month . "-" . "1"));

// Get all entry for given month
$dateFrom = $year . "-" . $month . "-01";
$dateTo = $year . "-" . $month . "-" . $numDays;
$sql = "SELECT * FROM calendar WHERE date BETWEEN ? AND ? AND cancelby IS NULL;";
$res = $db->executeFetchAll($sql, [$dateFrom, $dateTo]);

// Get free/booked hours for each day
$free = [];
$booked = [];
for ($i = 0; $i < $numDays + 1; $i++) {
    $free[] = 0;
    $booked[] = 0;
}

foreach ($res as $aDay) {
    $dayNum = (int)substr($aDay->date, -2);
    if ($aDay->student == "admin" && $aDay->duration != 0) {
        $free[$dayNum]++;
    } elseif ($aDay->student != "admin" && $aDay->duration != 0) {
        $booked[$dayNum]++;
    }
}

//
// Generate table
//
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
    $selector = "";
    if ($i == $selDay && $month == $selMonth && $year == $selYear) {
        $selector .= "selected ";
    }
    if ($weekDay == 6 || $weekDay == 0) {
        $selector .= "weekend";
    } else {
        $selector .= "empty";
    }

    if ($i == $dayToday && $month == $monthToday
    && $year = $yearToday) {
        $selector .= " bold";
    }
    $date = date('Y-m-d', strtotime($year . "-" . $month . "-" . $i));
    $freeEmpty = ($free[$i] == 0) ? "free-empty" : "";
    $bookedEmpty = ($booked[$i] == 0) ? "booked-empty" : "";

    $table .= "<td><form><div class='day-label'><input type='hidden' name='route' value='admin_calendar_2'>
    <input type='hidden' name='selDate' value='{$date}'><input type='submit' class='button {$selector}' name='day' value={$i}><div class='free-mini {$freeEmpty}'>{$free[$i]}</div><div class='booked {$bookedEmpty}'>{$booked[$i]}</div></div></form></td>";
    if ($weekDay == 0) {
        $table .= "</tr>";
    }
}

// Empty cells after last day of the month
$weekDay = date('w', strtotime($year . "-" . $month . "-" . $numDays));
if ($weekDay != 0) {
    for ($i = $weekDay; $i < 7; $i++) {
        $table .= "<td><input type='submit' class='button' name='day' value='' disabled /></td>";
    }
    $table .= "</tr>";
}

$table .= "</tbody></table>";
echo $table;
