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
        <div class="admin-calendar">
            <table class="table table-only-header table-bordered">
                <thead>
                    <form class="calendar-form" method="POST">
                        <input type="hidden" name="route" value="admin_calendar_1">
                        <input type="hidden" name="date" value=<?= $date ?>>
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
            <script>getAdminCalendarMonth();</script>
            <span id="output"></span>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/admin.js"></script>
