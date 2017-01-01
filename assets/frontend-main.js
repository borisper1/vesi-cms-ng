window.vbcknd.validation = {};
window.vbcknd.validation.clear_all_errors = function () {
    $('.has-error').removeClass('has-error');
};

window.vbcknd.validation.check_pwds = function (object1, object2) {
    if (object1.val().length < 8 || object1.val() !== object2.val()) {
        object1.closest('.form-group').addClass('has-error');
        object2.closest('.form-group').addClass('has-error');
        return 1;
    } else {
        return 0;
    }
};

window.vbcknd.validation.check_is_empty = function (object) {
    if (object.val() === '') {
        object.closest('.form-group').addClass('has-error');
        return 1;
    } else {
        return 0;
    }
};

$(document).ready(function(e) {
    // Enables direct link to tabs (see issue #28)
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        if(history.pushState) {
            history.pushState(null, null, e.target.hash);
        } else {
            window.location.hash = e.target.hash;
        }
    });

    //Generic popover and hover menu initialization js
    $('.popover-trigger').popover();
    if(jQuery.fn.dropdownHover){
        $('.dropdown-hover').dropdownHover();
    }
    //solve bug #6, show correct footer size on mobile devices
    var f_height = $('div.footer').height();
    if (f_height > 60) {
        $('#page-wrapper>.container.with-footer, #page-wrapper>.container-fluid.with-footer').css('padding-bottom', f_height.toString() + 'px');
    }

    $('#authenticator-logout').click(function(){
        $('#authenticator-logout-form').submit();
    });

    $('#authenticator-container').on('click', '#authenticator-login', function() {
        var data = {
            username: $('#i-authenticator-username').val(),
            password: $('#i-authenticator-password').val()
        };
        $('#authenticator-alert').addClass('hidden');
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
            window.location.reload(true);
        }else{
            $('#authenticator-alert').removeClass('hidden').text(json.error_message);
        }
    }

    //Show alternate login page for mobile users when popover might be hidden if page is not long enough
    //May cause visual artifacts, maybe suppress popover from displaying
    $('#authenticator-login-button').click(function(){
        if($(window).width() < 768)
        {
            window.location.href = window.vbcknd.base_url + 'system/login'
        }
    });
});