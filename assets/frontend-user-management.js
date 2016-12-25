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