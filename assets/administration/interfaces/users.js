$(document).ready(function() {
    var CurrentItem;

    $('.auto-bswitch').bootstrapSwitch();

    $('.close').click(function () {
        $(this).closest('.alert-dismissible').addClass('hidden');
    });

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
        data.username = username_oject.text();
        data.admin_group = $('#i-admin-group').val();
        data.frontend_group = $('#i-frontend-group').val();
        data.active = $('#i-activate').prop('checked');
        if (type == 'ldap') {
            data.admin_local_group = $('#i-admin-local-group').prop('checked');
            data.frontend_local_group = $('#i-frontend-local-group').prop('checked');
        }
        else {
            data.full_name = $('#i-fullname').val();
            data.email = $('#i-email').val();
        }
        var json_str = JSON.stringify(data);
        $('.save-user-alert').addClass('hidden');
        $('#spinner').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url + 'ajax/admin/users/save_edit',
            data: {type: type, data_string: json_str},
            success: AJAXSaveOperationOK,
            error: AJAXSaveOperationFailed
        });
    });

    function AJAXSaveOperationOK(data) {
        $('.save-user-alert').addClass('hidden');
        if (data == 'success') {
            $('#success-alert').removeClass('hidden');
        }
        else {
            $('#error-alert').removeClass('hidden');
            $('#error-mgs').text(data);
        }
    }

    function AJAXSaveOperationFailed() {
        $('.save-user-alert').addClass('hidden');
        $('#error-alert').removeClass('hidden');
        $('#error-mgs').text('500 request failed');
    }

    $('#unlock-account').click(function () {
        $.post(window.vbcknd.base_url + 'ajax/admin/users/unlock_user', {username: $('#username').text()}, AJAXSimpleResultHandler);
    });

    $('#close-edit').click(function () {
        window.location = window.vbcknd.base_url + 'admin/users';
    });

    $('#reset-pwd').click(function () {
        $('#pwd-reset-spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url + 'ajax/admin/users/request_password_reset', {user: $('#username').text()}, AJAXSimpleResultHandler);
    });

    function AJAXSimpleResultHandler(data) {
        if (data == 'success') {
            window.location.reload(true);
        } else {
            alert("Si è verificato un errore durante l'esecuzione dell'operazione richiesta");
        }
    }

    //List mode functions (TODO: maybe implement if-tree based loading as in groups.js)

    $('#new-local-user').click(function () {
        $('#new-local-user-modal').modal();
        window.vbcknd.validation.clear_all_errors();
        $('#local-error-alert').addClass('hidden');
    });

    $('#new-LDAP-user').click(function () {
        $('#new-ldap-user-modal').modal();
    });

    $('#new-local-user-modal-confirm').click(function () {
        var username = $('#i-local-username');
        var fullname = $('#i-local-fullname');
        var email = $('#i-local-email');
        window.vbcknd.validation.clear_all_errors();
        $('#local-error-alert').addClass('hidden');
        if (window.vbcknd.validation.check_is_empty(username) + window.vbcknd.validation.check_is_empty(fullname)
            + window.vbcknd.validation.check_is_empty(email) > 0) {
            $('#local-error-alert').removeClass('hidden');
            return;
        }
        var mode = 'nopwd';
        if ($('#i-local-pwd-mode-email').prop('checked')) {
            mode = 'emailpwd';
        }
        var data = {
            'username': username.val(),
            'full_name': fullname.val(),
            'email': email.val(),
            'mode': mode
        };
        CurrentItem = username.val();
        $('#new-user-spinner').removeClass('hidden');
        $('#new-user-success-alert').addClass('hidden');
        $('#new-user-failure-alert').addClass('hidden');
        $('#new-local-user-modal').modal('hide');
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url + 'ajax/admin/users/new_local',
            data: data,
            success: AJAXNewOK,
            error: AJAXNewFailed
        });
    });

    function AJAXNewOK() {
        $('#new-user-spinner').addClass('hidden');
        $('#new-user-success-alert').removeClass('hidden');
    }

    function AJAXNewFailed() {
        $('#new-user-spinner').addClass('hidden');
        $('#new-user-failure-alert').removeClass('hidden');
    }

    $('#enable-users').click(function () {
        var users = [];
        $('.vcms-select-user:checked').each(function () {
            users.push($(this).val());
        });
        $.post(window.vbcknd.base_url + 'ajax/admin/users/enable', 'users=' + encodeURIComponent(users.join()), AJAXSimpleResultHandler);
    });

    $('#disable-users').click(function () {
        var users = [];
        $('.vcms-select-user:checked').each(function () {
            users.push($(this).val());
        });
        $.post(window.vbcknd.base_url + 'ajax/admin/users/disable', 'users=' + encodeURIComponent(users.join()), AJAXSimpleResultHandler);
    });

    $('#delete-users').click(function () {
        var users = [];
        $('.vcms-select-user:checked').each(function () {
            users.push($(this).val());
        });
        CurrentItem = users;
        $('#delete-modal').modal();
    });

    $('#delete-modal-confirm').click(function () {
        $.post(window.vbcknd.base_url + 'ajax/admin/users/delete', 'users=' + encodeURIComponent(CurrentItem.join()), AJAXSimpleResultHandler);

    });

});