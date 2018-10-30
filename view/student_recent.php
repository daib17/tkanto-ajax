<script type="text/javascript" src="js/student_ajax.js"></script>
<div class="container main-container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="?route=student_calendar">Calendar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?route=student_bookings">Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="?route=student_recent">Recent</a>
        </li>
    </ul>

    <div class="container main-container-inner">
        <h5 class="mb-4">Recent activity</h5>
        <script>getStudentRecent();</script>
        <span id="log"></span>
    </div>
</div>
