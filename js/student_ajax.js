"use strict";

/****************************************************************
* STUDENT - Calendar
*****************************************************************/

function getStudentCalendarMonth() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#calendar-month').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/student_callback/getStudentCalendarMonth.php", true);
    xmlhttp.send();
}


function getStudentCalendarDay() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#calendar-day').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/student_callback/getStudentCalendarDay.php", true);
    xmlhttp.send();
}

/****************************************************************
* STUDENT - Bookings
*****************************************************************/

function getStudentBookings() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#bookings').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/student_callback/getStudentBookings.php", true);
    xmlhttp.send();
}



function getStudentBookingsPagination() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#pagination').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/student_callback/getStudentBookingsPagination.php", true);
    xmlhttp.send();
}


/****************************************************************
* STUDENT - Recent
*****************************************************************/

function getStudentRecent() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#log').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/student_callback/getStudentRecent.php", true);
    xmlhttp.send();
}
