(function () {
    'use strict';

    /**
    * Admin - Student - Status filter
    */
    var showFilter = document.getElementById("showFilter");
    if (showFilter != null) {
        showFilter.addEventListener("change", function () {
            var value = showFilter.options[showFilter.selectedIndex].value;
            // Redirect with parameter
            var url = window.location.href;
            url = url.replace("search=", "");   // Remove search param
            var index = url.indexOf("&filter");
            if (index > 0) {
                window.location.href = url.substr(0, index) + "&filter=" + value;
            } else {
                window.location.href = url + ("&filter=") + value;
            }
        });
    }
})();
