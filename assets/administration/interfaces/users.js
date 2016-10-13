$(document).ready(function() {
    var CurrentItem;

    $('.auto-bswitch').bootstrapSwitch();

    $('#i-admin-local-group').on('switchChange.bootstrapSwitch', function () {
        if ($(this).prop('checked')) {
            $('#admin-group-box').removeClass('hidden');
        } else {
            $('#admin-group-box').addClass('hidden');
        }
    });

    $('#i-frontend-local-group').on('switchChange.bootstrapSwitch', function () {
        if ($(this).prop('checked')) {
            $('#frontend-group-box').removeClass('hidden');
        } else {
            $('#frontend-group-box').addClass('hidden');
        }
    });

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

    $('#save-edit').click(function () {
        var username_oject = $('#username');
        var type = username_oject.data('type');
        var data = {};
        data.username = username_oject.val();
        data.admin_group = $('#i-admin-group').val();
        data.frontend_group = $('#i-frontend-group').val();
        data.active = $('#i-activate').prop('checked');
        if (type == 'local') {
            data.admin_local_group = $('#i-admin-local-group').prop('checked');
            data.fronted_local_group = $('#i-frontend-local-group').prop('checked');
        }
        else {
            data.full_name = $('#i-fullname').val();
            data.email = $('#i-email').val();
        }
        var json_str = JSON.stringify(data);

    });
});