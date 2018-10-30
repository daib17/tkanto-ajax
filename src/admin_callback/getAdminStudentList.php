<?php
require("../../config/config.php");
require("../classes/Database.php");
require("../admin_functions.php"); // doSearch, getStudentsByStatus

$db = new Database();
$db->connect($databaseConfig);

$filterId = isset($_COOKIE["filter"]) ? $_COOKIE["filter"] : 2;
$page = isset($_COOKIE["page"]) ? $_COOKIE["page"] : 1;
$selectedID = isset($_COOKIE["selectedID"]) ? $_COOKIE["selectedID"] : null;
$search = isset($_COOKIE["search"]) ? $_COOKIE["search"] : "";

$table = "<table class='table table-bordered table-selectable'>
<thead>
<tr>
<th scope='col' colspan='2'>Name</th>
<th scope='col'>Status</th>
</tr>
</thead>
<tbody>";

$statusStr = ["Disabled", "Pending", "Active"];

if ($search != "") {
    $res = doSearch($db, $search);
    $searchInput = "<input type='hidden' name='search' value='{$search}' />";
} else {
    $res = getStudentsByStatus($db, $filterId);
    $searchInput = "";
}

if ($res != null && count($res) > 0) {
    $firstID = ($page - 1) * ITEMS_PAGE; // id for first element to draw
    $lastID = $firstID + ITEMS_PAGE;
    for ($id = $firstID; $id < $lastID; $id++) {
        $table .= "<tr>";
        if ($id < count($res)) {
            $name = $res[$id]->firstname . "&nbsp;" . $res[$id]->lastname;
            $studentID = $res[$id]->id;
            if ($studentID == $selectedID) {
                $selected = " selected";
            } else {
                $selected = "";
            }

            $table .= "<td colspan=2><form method='POST'><input type='hidden' name='route' value='admin_students_1'>{$searchInput}<input type='submit' class='{$selected}' name='name' value='{$name}'><input type='hidden' name='studentID' value={$studentID} /><input type='hidden' name='filter' value={$filterId} /><input type='hidden' name='page' value={$page} /></form></td>";
            $table .= "<td>" . $statusStr[$res[$id]->status] . "</td>";
        } else {
            $table .= "<td colspan=2>&nbsp;</td>";
            $table .= "<td><div class='empty'>Empty</div></td>";
        }
        $table .= "</tr>";
    }
} else {
    $table .= "<tr>";
    $table .= "<td colspan=3 class='no-found-text'>" . "No students in database" . "</td>";
    $table .= "</tr>";
}

$table .= "</tbody></table>";
echo $table;
