!function(){
    //TODO: remove hack for in-folder execution
    window.vbcknd={};
    window.vbcknd.base_url = location.protocol+'//'+location.host+'/vesi-cms-ng/';
}();



$(document).ready(function() {
    var elevator_href;
    $('.vcms-elevator').click(function(){
        elevator_href=$(this).data('href');
    });

    $('#system_reauth_ok').click(function(){
        var password = $('#system_reauth_password').val();
        if(password != ""){
            $.post(window.vbcknd.base_url+'ajax/admin/users/check_pass')
        }
    });

    $('.selectpicker').selectpicker();
});

$(document).ready(function() {
    $("body").tooltip({
        html: true,
        selector: ".tooltipped"
    });
});