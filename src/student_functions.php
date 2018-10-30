<?php

const ITEMS_PAGE = 5;

/**
* Make reservation for student at date/time.
*/
function doBooking($db, $date, $time, $student) {
    try {
        $db->beginTransaction();
        // Get details for available hour from database
        $sql = "SELECT * FROM calendar WHERE date = ? AND time = ? AND student = ?;";
        $res = $db->executeFetch($sql, [$date, $time, "admin"]);
        if (!$res) {
            throw new Exception();
        }
        // Update first slot
        $now = date("Y-m-d H:i:s");
        $sql = "UPDATE calendar SET student = ?, bookdate = ? WHERE date = ? AND time = ? AND student = ?;";
        $db->execute($sql, [$student, $now, $date, $time, "admin"]);
        // Update second slot
        if ($res->duration == 60) {
            $time2 = ($time % 100 == 0) ? $time + 30 : $time + 70;
            $db->execute($sql, [$student, $now, $date, $time2, "admin"]);
        }
        $db->commit();
    } catch (Exception $ex) {
        $db->rollBack();
        throw new Exception("Booking failed: time no longer available.");
    }
}

/**
* Cancel booking.
*/
function cancelBooking($db, $date, $time, $student) {
    try {
        $db->beginTransaction();
        // Get booking from db
        $sql = "SELECT * FROM calendar WHERE date = ? AND time = ? AND student = ? AND canceldate IS NULL;";
        $res = $db->executeFetch($sql, [$date, $time, $student]);
        if (!$res) {
            throw new Exception();
        }
        // Update first slot
        $now = date("Y-m-d H:i:s");
        $sql = "UPDATE calendar SET canceldate = ?, cancelby = ?, flag = ? WHERE date = ? AND time = ? AND student = ? AND canceldate IS NULL;";
        $db->execute($sql, [$now, $student, 1, $date, $time, $student]);
        // Update second slot
        if ($res->duration == 60) {
            $time2 = ($time % 100 == 0) ? $time + 30 : $time + 70;
            $db->execute($sql, [$now, $student, 1, $date, $time2, $student]);
        }
        $db->commit();
    } catch (Exception $ex) {
        $db->rollBack();
        throw new Exception("Cancel operation failed.");
    }
}
