<script type="text/javascript" src="js/student_ajax.js"></script>
<div class="container main-container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="?route=student_calendar">Calendar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?route=student_bookings">Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?route=student_recent">Recent</a>
        </li>
    </ul>

    <div class="container main-container-inner">
        <div class="student-calendar <?= $hidePanelA ?>">
            <h5 class="mb-4">
                Select a date to see available times
            </h5>
            <table class="table table-only-header table-bordered">
                <form class="calendar-form" method="POST">
                    <input type="hidden" name="route" value="student_calendar">
                    <input type="hidden" name="date" value=<?= $date ?>>
                    <thead>
                        <tr>
                            <th scope="col" colspan="1">
                                <input type="submit" class="btn btn-arrow btn-block font-weight-bold" name="changeMonth" value="<<">
                            </th>
                            <th scope="col" colspan="5" class="title"><?= $monthName ?> <?= $year ?></th>
                            <th scope="col" colspan="1">
                                <input type="submit" class="btn btn-arrow btn-block font-weight-bold" name="changeMonth" value=">>">
                            </th>
                        </tr>
                    </form>
                </thead>
            </table>
            <script>getStudentCalendarMonth();</script>
            <span id="calendar-month"></span>
        </div>
        <div class="student-day <?= $hidePanelB ?>">
            <h5 class="mb-4">Select a time to book or cancel</h5>
            <?php if ($exception != ""): ?>
                <div class="alert alert-info" role="alert">
                    <?= $exception ?>
                </div>
            <?php endif; ?>
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th scope="col" colspan="2"><?= $daySel ?> <?= $monthSel ?> <?= $yearSel ?></th>
                    </tr>
                </thead>
            </table>
            <script>getStudentCalendarDay();</script>
            <span id="calendar-day"></span>
        </div>

        <form class="<?= $hidePanelB ?>" method="POST">
            <input type="hidden" name="route" value="student_calendar">
            <input type="hidden" name="hidePanel" value="A">
            <input type="hidden" name="selDate" value="<?= $selDate ?>">
            <input type="hidden" name="selHour" value="<?= $selHour ?>">
            <button class="btn btn-lg <?= $buttonType ?> btn-block font-weight-bold mt-4" type="submit" name="button" value="<?= $buttonLabel ?>"><?= $buttonLabel ?></button>
        </form>
        <form class="<?= $hidePanelB ?>" method="POST">
            <input type="hidden" name="route" value="student_calendar">
            <input type="hidden" name="selDate" value="<?= $selDate ?>">
            <input type="hidden" name="hidePanel" value="B">
            <button class="btn btn-lg btn-secondary btn-block font-weight-bold mt-4" type="submit" name="button" value="back">Back</button>
        </form>
    </div>
</div>
