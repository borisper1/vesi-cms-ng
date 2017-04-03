$(document).ready(function () {
    window.vbcknd.config.get_data = function () {
        var data = {};
        data.email = {};
        data.email.smtp_hostname = $('#i-smtp-server-host').val();
        data.email.smtp_port = $('#i-smtp-server-port').val();
        data.email.smtp_ssl = $('#i-enable-smtp-ssl').prop('checked') ? 1 : 0;
        data.email.smtp_address = $('#i-smtp-address').val();
        data.email.smtp_user = $('#i-smtp-username').val();
        var password = $('#i-smtp-password').val();
        if (password != '') {
            data.email.smtp_password = password;
        }
        return data;
    };
});
