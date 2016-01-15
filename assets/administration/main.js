!function(){
    //TODO: remove hack for in-folder execution
    window.vbcknd={};
    window.vbcknd.base_url = location.protocol+'//'+location.host+'/vesi-cms-ng/';
    window.vbcknd.services ={};
    window.vbcknd.config ={};
    window.vbcknd.auto_name_format = function(title){
        return title.replace(/[^A-Za-z0-9 ]+/,'').replace(/\s+/g,'-').toLowerCase().substr(0,40);
    }
}();

$(document).ready(function() {
    var elevator_href;
    $('.vcms-elevator').click(function(){
        elevator_href=$(this).data('href');
        $('#system_reauth_modal').modal();
    });

    $('#system_reauth_ok').click(function(){
        var data = {};
        data.password = $('#system_reauth_password').val();
        if(data.password != ""){
            $.post(window.vbcknd.base_url+'ajax/admin/users/check_pass', data, ReauthRedirect)
        }else{
            $('#system_reauth_password').val('');
            $('#system_reauth_modal').modal('hide');
            alert('Password non vailda, riprovare')
        }
    });

    $('#system_reauth_failed').click(function(){
        $('#system_reauth_password').val('');
        $('#system_reauth_modal').modal('hide');
    });

    function ReauthRedirect(data){
        if(data === 'success')
        {
            window.location.href = window.vbcknd.base_url + elevator_href;
        }
    }

    $('.selectpicker').selectpicker();
});

$(document).ready(function() {
    $("body").tooltip({
        html: true,
        selector: ".tooltipped"
    });
});

//POLYFILLS FOR NON ECMASCRPT6 Browsers --------------------------------------------------------------------------------
if (!String.prototype.startsWith) {
    String.prototype.startsWith = function(searchString, position) {
        position = position || 0;
        return this.indexOf(searchString, position) === position;
    };
}