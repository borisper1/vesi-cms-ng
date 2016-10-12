$(document).ready(function() {
    var CurrentItem;

    $('.auto-bswitch').bootstrapSwitch();

    $('.vcms-select-user').change(function () {
        if ($('.vcms-select-user:checked').length > 0) {
            $('#users-actions').removeClass('hidden');
        } else {
            $('#users-actions').addClass('hidden');
        }
    });

    var admin_group_control = $('#i-admin-group');
    if (admin_group_control) {
        admin_group_control.selectpicker('val', $('#current-admin-group').text());
    }

    var frontend_group_control = $('#i-frontend-group');
    if (frontend_group_control) {
        frontend_group_control.selectpicker('val', $('#current-frontend-group').text());
    }

    $('#ajax-cage').on('click', '.panel-actuator', function () {
        var object = $(this).closest('.container-block').find('table:first');
        if (object.hasClass('hidden')) {
            $(this).find('.fa-chevron-right').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        } else {
            $(this).find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        }
        object.toggleClass('hidden');
    });

});