$(document).ready(function() {

    $('.vcms-select-group').change(function () {
        if ($('.vcms-select-group:checked').length > 0) {
            $('#group-actions').removeClass('hidden');
        } else {
            $('#group-actions').addClass('hidden');
        }
    });
});