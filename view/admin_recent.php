<script type="text/javascript" src="js/admin_ajax.js"></script>
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
        <script>getAdminRecent();</script>
        <span id="log"></span>
    </div>
</div>
