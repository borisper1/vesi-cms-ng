$(document).ready(function() {

    $('.file-manager-select-element').change(function () {
        if ($('.file-manager-select-element:checked').length > 0) {
            $('#file-system-actions').removeClass('hidden');
        } else {
            $('#file-system-actions').addClass('hidden');
        }
    });
});