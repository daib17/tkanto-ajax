<script type="text/javascript" src="js/admin_ajax.js"></script>
<div class="container main-container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="?route=admin_calendar_1">Calendar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?route=admin_students_1">Students</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?route=admin_recent">Recent</a>
        </li>
        <li class="nav-item hidden">
            <a class="nav-link" href="?route=admin_stats">Statistics</a>
        </li>
    </ul>
    <div class="container main-container-inner">
        <?php if ($exception != ""): ?>
            <div class="alert alert-info" role="alert">
                <?= $exception ?>
            </div>
        <?php endif; ?>
        <div class="spinner">
            <div class="float-left w-25 mb-4">
                <script>getAdminTimeSpin();</script>
                <select id='timeSpinner' class='form-control'>
                    <option value=""></option>
                </select>
            </div>
            <div class="float-right w-50 mb-4 <?= $hideSpinner ?>">
                <script>getAdminStudentSpin();</script>
                <select id='studentSpinner' class='form-control'>
                    <option value=""></option>
                </select>
            </div>
            <div class="float-right mb-4">
                <form method="POST">
                    <input type="hidden" name="route" value="admin_calendar_2">
                    <input type="hidden" name="selDate" value="<?= $date ?>">
                    <input type="hidden" name="hourStr" value=<?= $hourStr ?>>
                    <button class="btn btn-md btn-warning font-weight-bold  <?= $clearFlagBtn ?>" type="submit" name="clearBtn" value="admin">Confirm cancelation</button>
                    <button class="btn btn-md btn-danger font-weight-bold  <?= $cancelBtn ?>" type="submit" name="cancelBtn" value="admin">Cancel</button>
                    <button class="btn btn-md btn-danger font-weight-bold <?= $cancelBtn ?>" type="submit" name="cancelBtn" value="student">Cancel by student</button>
                </form>
            </div>
        </div>
        <div class="admin-calendar">
            <form class="calendar-form" method="POST">
                <input type="hidden" name="route" value="admin_calendar_2">
                <input type="hidden" name="selDate" value="<?= $date ?>">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" colspan="1">
                                <input type="submit" class="btn btn-arrow btn-block font-weight-bold" name="changeDate" value="<<">
                            </th>
                            <th id="headerLabel" scope="col" colspan="2" class="title"><?= $dayOfWeek ?> / <?= $date ?></th>
                            <th scope="col" colspan="1">
                                <input type="submit" class="btn btn-arrow btn-block font-weight-bold" name="changeDate" value=">>">
                            </th>
                        </tr>
                    </thead>
                </table>

                <script>getAdminCalendarDay();</script>
                <div id="output">
                    <table class='table table-bordered'>
                        <body>
                            <?php
                            $id = 0;
                            for ($row = 0; $row < 7; $row++) {
                                ?>
                                <tr>
                                    <?php
                                    for ($id = $row * 4; $id < ($row * 4) + 4; $id++) {
                                        // Time label
                                        $hour = (int)($id / 2) + 8;
                                        $half = ($id % 2 == 1) ? ":30" : ":00";
                                        $time = $hour . $half;
                                        ?>
                                        <td><input type='submit' class='button empty' name='hourLabel' value='<?= $time ?>' /></td>
                                    <?php } ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </body>
                    </table>
                </div>
                <!-- <span id="output"></span> -->

                <div>
                    <button class="btn btn-lg btn-info btn-block font-weight-bold mt-5" type="submit" name="copyBtn" value="copy">Copy open hours to next day</button>
                </div>
            </form>
            <form method="POST">
                <input type="hidden" name="route" value="admin_calendar_1">
                <input type="hidden" name="selDate" value="<?= $date ?>">
                <button class="btn btn-lg btn-secondary btn-block font-weight-bold my-3" type="submit">Back</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/admin.js"></script>
