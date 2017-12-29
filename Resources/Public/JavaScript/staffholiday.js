$(document).ready(function () {
    $('.onoffswitch-checkbox').on('change', function() {
        var $target = $(this).data('target');

        if ($target === 'notice') {
            $('.summary-notice').fadeToggle('slow');
        } else {
            $('.table tr[data-status="' + $target + '"]').fadeToggle('slow');
        }
    });

    // get the iso time string formatted for usage in an input['type="datetime-local"']
    var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
    var beginDate = new Date(Date.now() - tzoffset);
    var endDate = new Date(Date.now() - tzoffset);

    beginDate.setDate(beginDate.getDay() + 1);
    endDate.setDate(endDate.getDay() + 2);

    var localISOTimeBegin = beginDate.toISOString().slice(0,-1);
    var localISOTimeEnd = endDate.toISOString().slice(0,-1);

    // select the "datetime-local" input to set the default value on
    if ($('input#tx-holiday_holidayBegin').val().length <= 0) {
        $('#tx-holiday_holidayBegin').val(localISOTimeBegin.slice(0,16));
    }

    if ($('#tx-holiday_holidayEnd').val().length <= 0) {
        $('#tx-holiday_holidayEnd').val(localISOTimeEnd.slice(0,16));
    }
});