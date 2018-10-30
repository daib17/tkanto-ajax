<?php
require(__DIR__ . "/classes/Hour.php");
const ITEMS_PAGE = 5;   // Number of students per page

/**
*   Get students from database
*
*   @param int $status (0)disabled, (1)pending, (2)active, (3)all
*/
function getStudentsByStatus($db, $status = 2)
{
    if ($status == 3) {
        $sql = "SELECT * FROM student WHERE username NOT LIKE 'admin' ORDER BY lastname, firstname;";
        $res = $db->executeFetchAll($sql);
    } else {
        $sql = "SELECT * FROM student WHERE username NOT LIKE 'admin' AND status = ? ORDER BY lastname, firstname;";
        $res = $db->executeFetchAll($sql, [$status]);
    }
    return $res;
}


/**
*
*/
function getStudentByID($db, $id)
{
    $sql = "SELECT * FROM student WHERE id = ?";
    $res = $db->executeFetch($sql, [$id]);
    return $res;
}


/**
*
*/
function doSearch($db, $search)
{
    $search = "%" . $search . "%";
    $sql = "SELECT * FROM student WHERE username <> 'admin' AND (firstname LIKE ? OR lastname LIKE ?);";
    $res = $db->executeFetchAll($sql, [$search, $search]);
    return $res;
}


/**
*
*/
function getSpinnerFilter($status, $search) {
    $filterType = ["Disabled", "Pending", "Active", "All"];
    // Generate select spinner
    $select = "<select id='showFilter' class='form-control w-25'>";
    foreach ($filterType as $key => $value) {
        if ($key == $status) {
            $select .= "<option value='{$key}' selected='selected'>" . $value . "</option>";
        } else {
            $select .= "<option value='{$key}'>{$value}</option>";
        }
    }

    if ($search != "") {
        $select .= "<option selected='selected'></option>";
    }

    $select .= "</select>";
    return $select;
}


/**
* Spinner for Admin - Students - Edit details form
*/
function getSpinnerStatus($status) {
    $status;    // status 0 does not exist in panel B
    $filterType = ["Disabled", "Pending", "Active"];
    // Generate select spinner
    $select = "<select name='status' class='spinner-large form-control-lg w-50'>";
    foreach ($filterType as $key => $value) {
        if ($key == $status) {
            $select .= "<option value='{$key}'selected='selected'>" . $value . "</option>";
        } else {
            $select .= "<option value='{$key}'>{$value}</option>";
        }
    }
    $select .= "</select>";
    return $select;
}


/**
* Get hours from database for date and convert to array.
* Array with length 28 represents hours between 8 and 21:30
*
* @return array of Hour objects.
*/
function generateHourArrayFromDB($db, $date) {
    $hourArr = [];
    for ($i = 0; $i < 28; $i++) {
        $hourArr[] = new Hour();
    }
    $sql = "SELECT * FROM calendar WHERE date = ? AND (cancelby IS NULL OR flag = ?);";
    $res = $db->executeFetchAll($sql, [$date, 1]);
    foreach ($res as $row) {
        // Calculate id in array for time in db (800 is 0, 2130 is 27)
        $id = (((int)($row->time / 100)) - 8) * 2;
        if ($row->time % 100 != 0) {
            $id++;
        }
        $hourArr[$id]->setStudent($row->student);
        $hourArr[$id]->setTime($row->time);
        $hourArr[$id]->setDuration($row->duration);
        $hourArr[$id]->setUpdated($row->updated);
        $hourArr[$id]->setFlag($row->flag);
        $hourArr[$id]->setCancelBy($row->cancelby);
    }
    return $hourArr;
}


/**
* Insert or update calendar database with new value from spinner.
*
* @return array updated $hoursArray
*/
function updateCalendarDB($db, $date, $student, $hourStr, $spin)
{
    // Array (0 to 27) of Hour objects for selected date from DB
    $arr = generateHourArrayFromDB($db, $date);

    // Convert hour "11:30" to integer 1130
    $val = explode(":", $hourStr);
    $time = $val[0] * 100 + $val[1];

    // Get array id for time (830 is 0)
    $id = (((int)($time / 100)) - 8) * 2;
    if ($time % 100 != 0) {
        $id++;
    }

    // New value same as old OR trying zero an already zero?
    if ($arr[$id]->getDuration() == $spin || ($arr[$id]->getDuration() == -1 && $spin == 0)) {
        return;
    }

    // From 0 to 30 or 60 (New entry in database)
    if ($arr[$id]->getStudent() == "") {
        $sql = "INSERT INTO calendar (date, student, time, duration) VALUES (?, ?, ?, ?);";
        $db->execute($sql, [$date, $student, $time, $spin]);
        // 60?
        if ($spin == 60) {
            $time = ($time % 100 == 0) ? $time += 30 : $time += 70;
            // Insert OR Update if second slot already booked by admin
            if ($arr[$id + 1]->getStudent() == "") {
                $sql = "INSERT INTO calendar (date, student, time, duration) VALUES (?, ?, ?, ?);";
                $db->execute($sql, [$date, $student, $time, 0]);
            } else {
                $sql = "UPDATE calendar SET duration = ? WHERE date = ? AND time = ?;";
                $db->execute($sql, [0, $date, $time]);
            }
        }
        // Redirect
        header("Location: ?route=admin_calendar_2&selDate=$date");
        exit;
    }

    // From 30/60 to 0 (update existing entry)
    if ($spin == 0) {
        // Previously 30
        if ($arr[$id]->getDuration() == 30) {
            $sql = "DELETE FROM calendar WHERE date = ? AND time = ? AND student = ?;";
            $db->execute($sql, [$date, $time, "admin"]);
        }
        // Previously 60
        if ($arr[$id]->getDuration() == 60) {
            // Delete first slot
            $sql = "DELETE FROM calendar WHERE date = ? AND time = ? AND student = ? AND duration = ?;";
            $db->execute($sql, [$date, $time, "admin", 60]);
            // Delete second slot
            $time2 = ($time % 100 == 0) ? $time += 30 : $time += 70;
            $sql = "DELETE FROM calendar WHERE date = ? AND time = ? AND student = ? AND duration = ?;";
            $db->execute($sql, [$date, $time2, "admin", 0]);
        }
    }

    // From 60 to 30 (update existing entry)
    if ($spin == 30) {
        // Previously 60
        if ($arr[$id]->getDuration() == 60) {
            // Update first slot
            $sql = "UPDATE calendar SET duration = ? WHERE date = ? AND time = ? AND student = ? AND duration = ?;";
            $db->execute($sql, [30, $date, $time, "admin", 60]);
            // Delete second slot
            $time2 = ($time % 100 == 0) ? $time += 30 : $time += 70;
            $sql = "DELETE FROM calendar WHERE date = ? AND time = ? AND student = ? AND duration = ?;";
            $db->execute($sql, [$date, $time2, "admin", 0]);
        }
    }

    // From 30 to 60 (update existing entry)
    if ($spin == 60) {
        // Update first slot
        $sql = "UPDATE calendar SET duration = ? WHERE date = ? AND time = ? AND student = ? AND duration = ?;";
        $db->execute($sql, [60, $date, $time, "admin", 30]);
        // Insert second slot
        $time2 = ($time % 100 == 0) ? $time += 30 : $time += 70;
        $sql = "INSERT INTO calendar (date, student, time, duration) VALUES (?, ?, ?, ?);";
        $db->execute($sql, [$date, $student, $time2, 0]);
    }

    // Redirect
    header("Location: ?route=admin_calendar_2&selDate=$date");
}



/**
* Make reservation for student at date/time.
*/
function doBooking($db, $date, $hourStr, $student) {
    try {
        $db->beginTransaction();
        // Convert hour "11:30" to integer 1130
        $val = explode(":", $hourStr);
        $time = $val[0] * 100 + $val[1];

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
        // Redirect
        header("Location: ?route=admin_calendar_2&selDate=$date");
    } catch (Exception $ex) {
        $db->rollBack();
        throw new Exception("Booking failed: time no longer available.");
    }
}



/**
* Cancel booking.
*
* @param string $orderedBy admin or student
*/
function cancelBooking($db, $date, $hourStr, $cancelBy) {
    try {
        $db->beginTransaction();
        // Convert hour "11:30" to integer 1130
        $val = explode(":", $hourStr);
        $time = $val[0] * 100 + $val[1];
        // Get booking from database
        $sql = "SELECT * FROM calendar WHERE date = ? AND time = ?;";
        $res = $db->executeFetch($sql, [$date, $time]);
        if (!$res) {
            throw new Exception();
        }

        $cancelBy = ($cancelBy != "admin") ? $res->student : "admin";
        // Update first 30 min slot
        $sql = "UPDATE calendar SET canceldate = NOW(), cancelby = ? WHERE date = ? AND time = ? AND cancelby IS NULL;";
        $db->execute($sql, [$cancelBy, $date, $time]);
        // Update second 30 min slot
        if ($res->duration == 60) {
            $time = ($time % 100 == 0) ? $time += 30 : $time += 70;
            $sql = "UPDATE calendar SET canceldate = NOW(), cancelby = ? WHERE date = ? AND time = ?;";
            $db->execute($sql, [$cancelBy, $date, $time]);
        }
        $db->commit();
        // Redirect
        header("Location: ?route=admin_calendar_2&selDate=$date");
    } catch (Exception $ex) {
        $db->rollBack();
        throw new Exception("Cancel operation failed.");
    }
}



/**
* Student already canceled, clear flag.
*/
function clearFlag($db, $date, $hourStr) {
    try {
        $db->beginTransaction();
        // Convert hour "11:30" to integer 1130
        $val = explode(":", $hourStr);
        $time = $val[0] * 100 + $val[1];
        // Get booking from database
        $sql = "SELECT * FROM calendar WHERE date = ? AND time = ? AND flag = ?;";
        $res = $db->executeFetch($sql, [$date, $time, 1]);
        if (!$res) {
            throw new Exception();
        }

        // 60 or 30 min?
        $sql = "UPDATE calendar SET flag = ? WHERE date = ? AND time = ? AND flag = ?;";
        $db->execute($sql, [0, $date, $time, 1]);
        // Second slot
        if ($res->duration == 60) {
            $time = ($time % 100 == 0) ? $time += 30 : $time += 70;
            $db->execute($sql, [0, $date, $time, 1]);
        }
        $db->commit();
        // Redirect
        header("Location: ?route=admin_calendar_2&selDate=$date");
    } catch (Exception $ex) {
        $db->rollBack();
        throw new Exception("Confirm operation failed.");
    }
}



/**
* Copy hours template
*/
function copyTemplate($db, $date)
{
    // Array (0 to 27) of Hour objects for selected date from DB
    $arr = generateHourArrayFromDB($db, $date);

    try {
        $db->beginTransaction();
        // Calculate date for one day later
        $nextDate = new DateTime($date);
        $nextDate->modify("+1 day");
        $nextDate = $nextDate->format("Y-m-d");
        // Copy
        foreach ($arr as $hour) {
            if ($hour->getStudent() == "admin") {
                if ($hour->getDuration() == 0) {
                    continue;
                }
                // 60?
                if ($hour->getDuration() == 60) {
                    $sql = "SELECT * FROM calendar WHERE date = ? AND time = ?;";
                    $time = $hour->getTime();
                    $res = $db->executeFetch($sql, [$nextDate, $time]);
                    $time2 = ($time % 100 == 0) ? $time + 30 : $time + 70;
                    $res2 = $db->executeFetch($sql, [$nextDate, $time2]);

                    if (!$res && !$res2) {
                        $sql = "INSERT INTO calendar (date, student, time, duration) VALUES (?, ?, ?, ?);";
                        $db->execute($sql, [$nextDate, "admin", $time, 60]);
                        $sql = "INSERT INTO calendar (date, student, time, duration) VALUES (?, ?, ?, ?);";
                        $db->execute($sql, [$nextDate, "admin", $time2, 0]);
                    }
                } else {
                    $sql = "SELECT * FROM calendar WHERE date = ? AND time = ?;";
                    $time = $hour->getTime();
                    $res = $db->executeFetch($sql, [$nextDate, $time]);
                    if (!$res) {
                        $sql = "INSERT INTO calendar (date, student, time, duration) VALUES (?, ?, ?, ?);";
                        $db->execute($sql, [$nextDate, "admin", $time, 30]);
                    }
                }
            }
        }
        $db->commit();
        // Redirect
        header("Location: ?route=admin_calendar_2&selDate=$date");
    } catch (Exception $ex) {
        $db->rollBack();
        throw new Exception("Copy template operation failed.");
    }
}
