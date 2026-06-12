let date_format = "dd/MM/yyyy";
let date_time_format = "dd/MM/yyyy HH:mm";
let moment_date_format = "DD/MM/YYYY";
let moment_date_time_format = "DD/MM/YYYY HH:mm";

(function ($) {

    "use strict";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

})(jQuery);