<?php
require_once("src/student_functions.php");

// Get login name from session
$student = (isset($_SESSION['user'])) ? $_SESSION['user'] : null;

setcookie("student", $student);
