$(document).ready(function () {

    window.vbcknd.config.get_data = function () {
        var data = {};
        data.authentication = {};
        data.authentication.enable_ldap = $('#i-enable-ldap-auth').prop('checked') ? 1 : 0;
        if ($("#i-ldap-type-ad").prop('checked')) {
            data.authentication.ldap_mode = 0;
        }
        if ($("#i-ldap-type-std").prop('checked')) {
            data.authentication.ldap_mode = 1;
        }
        data.authentication.ldap_hostname = $('#i-ldap-server-host').val();
        data.authentication.ldap_port = $('#i-ldap-server-port').val();
        data.authentication.ldap_ssl = $('#i-enable-ldap-ssl').prop('checked') ? 1 : 0;
        data.authentication.ldap_base_dn = $('#i-ldap-base-dn').val();
        data.authentication.ldap_user = $('#i-ldap-username').val();
        var password = $('#i-ldap-password').val();
        if (password != '') {
            data.authentication.ldap_password = password;
        }
        return data;
    };

});
