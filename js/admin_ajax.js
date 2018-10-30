"use strict";

/****************************************************************
* ADMIN - Calendar
*****************************************************************/

function getAdminCalendarMonth() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#output').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/admin_callback/getAdminCalendarMonth.php", true);
    xmlhttp.send();
}


function getAdminCalendarDay() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#output').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/admin_callback/getAdminCalendarDay.php", true);
    xmlhttp.send();
}


function getAdminTimeSpin() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#timeSpinner').replaceWith(this.response);
            $('#timeSpinner').on("change", function () {
                var time = timeSpinner.options[timeSpinner.selectedIndex].value;
                for (var i = 0; i < 28 ; i++) {
                    var elem = document.getElementById("h" + i);
                    if (elem.classList.contains("selected")) {
                        var hour = elem.value;
                        break;
                    }
                }

                // Redirect with parameter
                var label = document.getElementById("headerLabel").innerHTML;
                var date = label.substr(label.indexOf('2'));
                var url = window.location.href;
                var index = url.indexOf("admin_calendar");
                if (index > 0) {
                    window.location.href = url.substr(0, index) + "admin_calendar_2&selDate=" + date + "&hourLabel=" + hour + "&spinTime=" + time;
                } else {
                    window.location.href = url + "admin_calendar_2&selDate=" + date + "&hourLabel=" + hour + "&spinTime=" + time;
                }
            });
        }
    };
    xmlhttp.open("GET", "src/admin_callback/getAdminTimeSpin.php", true);
    xmlhttp.send();
}


function getAdminStudentSpin() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#studentSpinner').replaceWith(this.response);
            $('#studentSpinner').on("change", function () {
                var student = studentSpinner.options[studentSpinner.selectedIndex].value;
                for (var i = 0; i < 28 ; i++) {
                    var elem = document.getElementById("h" + i);
                    if (elem.classList.contains("selected")) {
                        var hour = elem.value;
                        break;
                    }
                }

                // Redirect with parameter
                var label = document.getElementById("headerLabel").innerHTML;
                var date = label.substr(label.indexOf('2'));
                var url = window.location.href;
                var index = url.indexOf("admin_calendar_1");
                if (index > 0) {
                    window.location.href = url.substr(0, index) + "admin_calendar_2&selDate=" + date + "&hourLabel=" + hour + "&spinStudent=" + student;
                } else {
                    window.location.href = url + "admin_calendar_2&selDate=" + date + "&hourLabel=" + hour + "&spinStudent=" + student;
                }
            });
        }
    };
    xmlhttp.open("GET", "src/admin_callback/getAdminStudentSpin.php", true);
    xmlhttp.send();
}


/****************************************************************
* ADMIN - Students
*****************************************************************/

function getAdminStudentList() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#studentList').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/admin_callback/getAdminStudentList.php", true);
    xmlhttp.send();
}


function getAdminStudentPagination() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#pagination').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/admin_callback/getAdminStudentPagination.php", true);
    xmlhttp.send();
}

/****************************************************************
* ADMIN - Recent
*****************************************************************/

function getAdminRecent() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var year = (new Date()).getFullYear();
            $('#log').replaceWith(this.response);
            $('#footer-label').replaceWith("&#169; " + year);
        }
    };
    xmlhttp.open("GET", "src/admin_callback/getAdminRecent.php", true);
    xmlhttp.send();
}
