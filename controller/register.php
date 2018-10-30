<?php
require_once("src/helper_functions.php");

// Sanitation
$fname = clean(getPost("fname"));
$lname = clean(getPost("lname"));
$email = clean(getPost("email"));
$phone = clean(getPost("phone"));
$pass = clean(getPost("pass"));
$pass2 = clean(getPost("pass2"));

// Validation
$fnameError = $lnameError = $emailError = $phoneError = $passError = $pass2Error = "";

// $uname = "";

$isValid = false;

if (getPost("registerBtn")) {
    $isValid = true;

    if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
        $fnameError = "Only letters and white space allowed";
        $isValid = false;
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
        $lnameError = "Only letters and white space allowed";
        $isValid = false;
    }

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format";
        $isValid = false;
    }

    if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
        $phoneError = "Only numbers allowed";
        $isValid = false;
    }

    if (strlen($pass) < 6) {
        $passError = "A minimum length of 6 characters";
        $isValid = false;
    } else {
        if (strlen($pass2) < 6) {
            $pass2Error = "A minimum length of 6 characters";
            $isValid = false;
        } elseif ($pass != $pass2) {
            $pass2Error = "Confirm password and password do not match";
            $isValid = false;
        }
    }
}

// Check email unique
if ($isValid) {
    // Check email account unique
    $sql = "SELECT * FROM student WHERE email = ?";
    $res = $db->executeFetch($sql, [$email]);
    if ($res) {
        $emailError = "Email address already in use by another account";
        $isValid = false;
    }
}

// Generate user name and insert in database
if ($isValid) {
    // Example: Daniel
    $i = 1;
    $basename = strtolower(substr($fname, 0, 4));   // dani
    $uname = $basename . $i;                        // dani1
    $sql = "SELECT * FROM student WHERE username = ?";
    $res = $db->executeFetch($sql, [$uname]);
    if ($res) {
        do {
            $i++;
            $uname = $basename . $i;
            // Check availability
            $sql = "SELECT * FROM student WHERE username = ?";
            $res = $db->executeFetch($sql, [$uname]);
        } while ($res);
    }
    $hashed = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO student (firstname, lastname, username, email, phone, password, status) VALUES (?, ?, ?, ?, ?, ?, ?);";
    try {
        $db->execute($sql, [$fname, $lname, $uname, $email, $phone, $hashed, 1]);
    } catch (Exception $ex) {
        $isValid = false;
    }
}
