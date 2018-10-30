<div class="container main-container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="?route=admin_calendar_1">Calendar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?route=admin_students_1">Students</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="?route=admin_recent">Recent</a>
        </li>
        <li class="nav-item hidden">
            <a class="nav-link" href="?route=admin_stats">Statistics</a>
        </li>
    </ul>
    <div class="container main-container-inner">
        <table class="table table-bordered table-selectable">
            <thead>
                <tr>
                    <th scope="col">Student</th>
                    <th scope="col">Action</th>
                    <th scope="col">Booking</th>
                    <th scope="col">Log</th>
                </tr>
            </thead>
            <tbody>
                <?= $logTable ?>
            </tbody>
        </table>
    </div>
</div>
