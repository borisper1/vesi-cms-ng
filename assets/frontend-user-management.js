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
            success: AJAXOperationOK,
            error: AJAXOperationFailed
        });
    });

    function AJAXOperationOK()
    {
        $('#panel-pwd-change').addClass('hidden');
        $('#panel-pwd-change-ok').removeClass('hidden');
    }

    function AJAXOperationFailed()
    {
        $('#panel-pwd-change').addClass('hidden');
        $('#panel-pwd-change-failed').removeClass('hidden');
    }
});