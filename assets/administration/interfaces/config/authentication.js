$(document).ready(function () {

    window.vbcknd.config.get_data = function () {
        var data = {};
        data.authentication = {};
        data.authentication.enable_ldap = $('#i-enable-ldap-auth').prop('checked') ? 1 : 0;
        data.authentication.ldap_hostname = $('#i-ldap-server-host').val();
        data.authentication.ldap_port = $('#i-ldap-server-port').val();
        data.authentication.ldap_ssl = $('#i-enable-ldap-ssl').prop('checked') ? 1 : 0;
        data.authentication.ldap_base_dn = $('#i-ldap-base-dn').val();
        data.authentication.ldap_user = $('#i-ldap-username').val();
        data.authentication.ldap_sync_email = $('#i-ldap-sync-email').prop('checked') ? 1 : 0;
        var password = $('#i-ldap-password').val();
        if (password != '') {
            data.authentication.ldap_password = password;
        }
        return data;
    };

});
