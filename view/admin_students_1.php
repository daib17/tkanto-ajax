<div class="container main-container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="?route=admin_calendar_1">Calendar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="?route=admin_students_1">Students</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?route=admin_recent">Recent</a>
        </li>
        <li class="nav-item hidden">
            <a class="nav-link" href="?route=admin_stats">Statistics</a>
        </li>
    </ul>
    <div class="container main-container-inner">
        <form method="POST">
            <div class="float-right input-group w-50 mb-3">
                <input class="form-control" type="text" placeholder="Search" name="search">
                <div class="input-group-append">
                    <input type="hidden" name="route" value="admin_students_1">
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="spinner">
            <?= $select ?>
        </div>

        <table class="table table-bordered table-selectable">
            <thead>
                <tr>
                    <th scope="col" colspan="2">Name</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?= $studentTable ?>
            </tbody>
        </table>
        <?= $pagination ?>
        <div class="<?= $infoMsg ?>">
            <div class="alert alert-info" role="alert">
                Select student to edit details.
            </div>
        </div>
        <form class="top-buffer" method="POST">
            <input type='hidden' name='route' value='admin_students_2'>
            <input type="hidden" name="studentID" value="<?= $studentID ?>">
            <button class="btn btn-lg btn-info btn-block font-weight-bold <?= $editButton ?>" type="submit" name="button" value="edit">Edit</button>
        </form>
    </div>
</div>
<script type="text/javascript" src="js/admin.js"></script>
