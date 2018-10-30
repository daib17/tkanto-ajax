<script type="text/javascript" src="js/student_ajax.js"></script>
<div class="container main-container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="?route=student_calendar">Calendar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="?route=student_bookings">Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?route=student_recent">Recent</a>
        </li>
    </ul>

    <div class="container main-container-inner">
        <h5 class="mb-4">Select a date to cancel</h5>
        <script>getStudentBookings();</script>
        <span id="bookings"></span>

        <script>getStudentBookingsPagination();</script>
        <span id="pagination"></span>

        <form class="top-buffer" method="POST">
            <input type='hidden' name='route' value='student_bookings'>
            <input type="hidden" name="selDate" value="<?= $selDate ?>">
            <input type="hidden" name="selTime" value="<?= $selTime ?>">
            <button class="btn btn-lg btn-danger btn-block font-weight-bold <?= $cancelButton ?>" type="submit" name="button" value="cancel">Cancel</button>
        </form>
        <form method="POST">
            <input type='hidden' name='route' value='student_calendar'>
            <button class="btn btn-lg btn-secondary btn-block font-weight-bold mt-4" type="submit">Back to calendar</button>
        </form>
    </div>
</div>
