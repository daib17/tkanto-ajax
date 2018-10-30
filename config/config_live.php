<?php
/**
* Session
*/
if (session_status() == PHP_SESSION_NONE) {
    // Enable output buffering
    ob_start();
    // Start session
    session_start();
}

/**
 * Set error reporting.
 */
error_reporting(E_ALL);           // Report all type of errors
ini_set("display_errors", 1);     // Display all errors

/**
* Default timezone
*/
date_default_timezone_set('Europe/Lisbon');

/**
 * Default exception handler.
 */
set_exception_handler(function ($e) {
    echo "Uncaught exception: <p>"
        . $e->getMessage()
        . "</p><p>Code: "
        . $e->getCode()
        . "</p><pre>"
        . $e->getTraceAsString()
        . "</pre>";
});

/**
 * Database details.
 */
$databaseConfig = [
    "dsn"      => "mysql:host=shareddb1e.hosting.stackcp.net;dbname=tecnikanto-36371edd;",
    "login"    => "dibanez",
    "password" => "baba184658",
    "options"  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
];
