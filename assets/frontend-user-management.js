$(document).ready(function() {

    $('#execute-password-change').click(function(){
        var pwd = $('#i-password');
        var c_pwd = $('#i-cpassword');
        window.vbcknd.validation.clear_all_errors();
        $('#pchange-error-alert').addClass('hidden');
        if (window.vbcknd.validation.check_pwds(pwd, c_pwd)){
            $('#pchange-error-alert').removeClass('hidden');
            return;
        }
        var data = {
            'password': pwd.val(),
            'token': $('#pchange-token').text(),
            'request-id': $('#pchange-id').text()
        };
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url + 'ajax/frontend/change_password',
            data: data,
            success: AJAXPwdChangeOK,
            error: AJAXPwdChangeFailed
        });
    });

    $('#i-password').on('keyup',function(){
        var progress_bar = $('#pwd-meter-progress');
        if($(this).val().length < 8)
        {
            progress_bar.css('width', '0');
            $('.pwd-meter-main-text').addClass('hidden');
            $('#pwd-meter-short').removeClass('hidden');
            return;

        }
        var obj = zxcvbn($(this).val());
        if(obj.score <= 1)
        {
            progress_bar.css('width', '25%');
            progress_bar.removeClass('progress-bar-warning progress-bar-success');
            progress_bar.addClass('progress-bar-danger');
            $('.pwd-meter-main-text').addClass('hidden');
            $('#pwd-meter-1').removeClass('hidden');
        }
        else if(obj.score == 2)
        {
            progress_bar.css('width', '50%');
            progress_bar.removeClass('progress-bar-danger progress-bar-success');
            progress_bar.addClass('progress-bar-warning');
            $('.pwd-meter-main-text').addClass('hidden');
            $('#pwd-meter-2').removeClass('hidden');
        }
        else if(obj.score == 3)
        {
            progress_bar.css('width', '75%');
            progress_bar.removeClass('progress-bar-danger progress-bar-warning');
            progress_bar.addClass('progress-bar-success');
            $('.pwd-meter-main-text').addClass('hidden');
            $('#pwd-meter-3').removeClass('hidden');
        }
        else if(obj.score == 4)
        {
            progress_bar.css('width', '100%');
            progress_bar.removeClass('progress-bar-danger progress-bar-warning');
            progress_bar.addClass('progress-bar-success');
            $('.pwd-meter-main-text').addClass('hidden');
            $('#pwd-meter-4').removeClass('hidden');
        }
    });

    function AJAXPwdChangeOK()
    {
        $('#panel-pwd-change').addClass('hidden');
        $('#panel-pwd-change-ok').removeClass('hidden');
    }

    function AJAXPwdChangeFailed()
    {
        $('#panel-pwd-change').addClass('hidden');
        $('#panel-pwd-change-failed').removeClass('hidden');
    }

    $('#system-execute-login').click(function() {
        var data = {
            username: $('#i-system-login-username').val(),
            password: $('#i-system-login-password').val()
        };
        $('#system-login-alert').addClass('hidden');
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url + 'ajax/frontend/ajax_login',
            data: data,
            success: AJAXLoginOK
        });
    });

    function AJAXLoginOK(data){
        var json = JSON.parse(data);
        if(json.result){
            window.location.href = window.vbcknd.base_url;
        }else{
            $('#system-login-alert').removeClass('hidden').text(json.error_message);
        }
    }

    $('#request-password-reset').click(function(){
        var username = $('#i-username');
        var email = $('#i-email');
        window.vbcknd.validation.clear_all_errors();
        if(window.vbcknd.validation.check_is_empty(username) + window.vbcknd.validation.check_is_empty(email))
        {
            $('#pwdresetrequest-error-alert').removeClass('hidden');
            return;
        }
        $('#pwdresetrequest-error-alert').addClass('hidden');
        $('#pwdresetrequest-spinner-alert').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url + 'ajax/frontend/request_pwd_reset',
            data: {username: username.val(), email: email.val()},
            success: AJAXRequestResetOK
        });
    });

    function AJAXRequestResetOK(data)
    {
        var json = JSON.parse(data);
        if(json.result){
            $('#panel-request-pwd-reset').addClass('hidden');
            $('#panel-request-pwd-reset-ok').removeClass('hidden');
        }else{
            if(json.error_message=='invalid_data'){
                $('#pwdresetrequest-error-alert').removeClass('hidden');
                $('#pwdresetrequest-spinner-alert').addClass('hidden');
            }else if(json.error_message=='refused'){
                $('#panel-request-pwd-reset').addClass('hidden');
                $('#panel-request-pwd-reset-failed').removeClass('hidden');
            }
        }
    }

    $('#edit-profile-email').click(function(){
        $('#users-profile-edit-email').modal();
    });

    $('#profile-edit-email-ok').click(function(){
        var email = $('#i-profile-email');
        window.vbcknd.validation.clear_all_errors();
        if(window.vbcknd.validation.check_is_empty(email))
        {
            return;
        }
        $('#users-profile-edit-email').modal('hide');
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url + 'ajax/frontend/update_user',
            data: {email: email.val()},
            success: AJAXSimpleResultHandler
        });
    });

    $('#edit-profile-fullname').click(function(){
        $('#users-profile-edit-fullname').modal();
    });

    $('#profile-edit-fullname-ok').click(function(){
        var fullname = $('#i-profile-fullname');
        window.vbcknd.validation.clear_all_errors();
        if(window.vbcknd.validation.check_is_empty(fullname))
        {
            return;
        }
        $('#users-profile-edit-fullname').modal('hide');
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url + 'ajax/frontend/update_user',
            data: {fullname: fullname.val()},
            success: AJAXSimpleResultHandler
        });
    });


    function AJAXSimpleResultHandler(data){
        if(data=='success'){
            window.location.reload(true);
        }
    }

    $('#reset-pwd').click(function(){
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url + 'ajax/frontend/request_pwd_reset',
            data: {username: $('#flag-username').text(), email: $('#profile-local-email').text()},
            success: AJAXRequestResetUserEditorOK,
            error: AJAXRequestResetUserEditorFailed
        });
       $('#reset-password-progress-modal').modal();
    });

    function AJAXRequestResetUserEditorOK(data)
    {
        var json = JSON.parse(data);
        if(json.result){
            $('#reset-password-progress-modal').modal('hide');
            $('#reset-password-ok-modal').modal()
        }else{
            $('#reset-password-progress-modal').modal('hide');
            alert('La richiesta per il reset della password è stata rifiutata');
        }
    }

    function AJAXRequestResetUserEditorFailed()
    {
        $('#reset-password-progress-modal').modal('hide');
        alert('Si è verificato un errore durante l\' invio della richiesta');
    }


});