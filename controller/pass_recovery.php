<?php

$email = $emailError = "";

$button = getPost("button");

if ($button == "send") {
    $isValid = true;
    // Sanitize email 
    $email = clean(getPost("email"));
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format";
        $isValid = false;
    }

    // Check email in database
    if ($isValid) {
        $sql = "SELECT * FROM student WHERE email = ?;";
        $res = $db->executeFetch($sql, [$email]);
        if (!$res) {
            $isValid = false;
        } else {
            // Send email
        }
    }
} else {
    $isValid = false;
}
