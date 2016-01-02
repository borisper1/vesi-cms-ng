$(document).ready(function() {
    var staged_changes ={};

    $('.vcms-select-user').change(function() {
        if($('.vcms-select-user:checked').length > 0) {
            $('#users-actions').removeClass('hidden');
        }else{
            $('#users-actions').addClass('hidden');
        }
    });

    var group_control = $('#i-group');
    if(group_control){
        group_control.selectpicker('val', $('#current-group').text());
    }

    $('#delete-users').click(function(){
        var users=[];
        $('.vcms-select-user:checked').each(function(){
            users.push($(this).val());
        });
        $.post(window.vbcknd.base_url+'ajax/admin/users/delete','users='+users.join(','),RefreshAJAXDone);
    });

    $('#enable-users').click(function(){
        var users=[];
        $('.vcms-select-user:checked').each(function(){
            users.push($(this).val());
        });
        $.post(window.vbcknd.base_url+'ajax/admin/users/enable','users='+users.join(','),RefreshAJAXDone);
    });

    $('#disable-users').click(function(){
        var users=[];
        $('.vcms-select-user:checked').each(function(){
            users.push($(this).val());
        });
        $.post(window.vbcknd.base_url+'ajax/admin/users/disable','users='+users.join(','),RefreshAJAXDone);
    });

    function RefreshAJAXDone(){
        //TODO: Add error messages if request failed
        window.location.reload(true);
    }

    $('#new-user').click(function(){
        window.location = window.vbcknd.base_url + 'admin/users/edit/new';
    });

    $('#close-edit').click(function(){
        window.location = window.vbcknd.base_url + 'admin/users';
    });

    $('#i-activate').bootstrapSwitch();

    $('#change-pwd').click(function(){
        $('#users_change_password').modal();
    });

    $('#pchange-ok').click(function(){
        var password = $('#i-password');
        var cpassword = $('#i-cpassword');
        $('.has-error').removeClass('has-error');
        var error_alert = $('#pchange-error-alert');
        error_alert.addClass('hidden');
        var has_error = false;
        if(password.val()==""){
            has_error=true;
            password.parent().parent().addClass('has-error');
        }
        if(cpassword.val()==""){
            has_error=true;
            cpassword.parent().parent().addClass('has-error');
        }
        if(password.val()!==cpassword.val()){
            password.parent().parent().addClass('has-error');
            cpassword.parent().parent().addClass('has-error');
            has_error=true;
        }
        if(has_error){
            error_alert.removeClass('hidden');
            return;
        }
        staged_changes.password = password.val();
        $('#users_change_password').modal('hide');
        password.val('');
        cpassword.val('');
        $('#change-pwd').prop('disabled',true);
    });

    $('#delete-user').click(function(){
        $.post(window.vbcknd.base_url+'ajax/admin/users/delete','users='+$('#username').text(),DeleteUserDone);
    });

    function DeleteUserDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            window.location = window.vbcknd.base_url+'admin/users';
        }else{
            $('#delete-error-msg').html("Si è verificato un errore durante l'eliminazione dell'utente. (Il token CSRF potrebbe essere scaduto" +
                " se la protezione CSRF è abilitata) - "+data.replace(/(<([^>]+)>)/ig,""));
            $('#delete-error-alert').removeClass('hidden');
        }
    }

    $('#save-edit').click(function(){
        var username = $('#username').text();
        var fullname = $('#i-fullname');
        var email = $('#i-email');
        var group = $('#i-group').val();
        var active = $('#i-activate').prop('checked') ? 1 : 0;
        var p_missing = false;
        var err_msg="";
        $('.alert').addClass('hidden');
        $('.has-error').removeClass('has-error');
        if(fullname.val()==""){
            p_missing=true;
            fullname.parent().parent().addClass('has-error');
        }
        if(email.val()==""){
            p_missing=true;
            email.parent().parent().addClass('has-error');
        }
        if(p_missing){
            err_msg="Uno o più campi non sono stati compliati.<br>";
            $('#error-alert').removeClass('hidden');
        }
        $('#error-msg').html(err_msg);
        if(err_msg!==""){
            return;
        }
        $('#spinner').removeClass('hidden');
        var data= {username: username, fullname: fullname.val(), email: email.val(), group: group, active: active};
        if(staged_changes.hasOwnProperty('password')){
            data.password = staged_changes.password;
        }
        $.post(window.vbcknd.base_url+'ajax/admin/users/save',data,SaveEditDone);
    });

    $('#save-edit-self').click(function(){
        var email = $('#i-email');
        var group = $('#i-group').val();
        var err_msg="";
        $('.alert').addClass('hidden');
        $('.has-error').removeClass('has-error');
        if(email.val()==""){
            email.parent().parent().addClass('has-error');
            $('#error-msg').html("Uno o più campi non sono stati compliati.<br>");
            $('#error-alert').removeClass('hidden');
            return;
        }
        $('#spinner').removeClass('hidden');
        var data= {email: email.val()};
        if(staged_changes.hasOwnProperty('password')){
            data.password = staged_changes.password;
        }
        $.post(window.vbcknd.base_url+'ajax/admin/users/save_self',data,SaveEditDone);
    });

    function SaveEditDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            $('#success-alert').removeClass('hidden');
            $('#change-pwd').prop('disabled',false);
            delete staged_changes.password;
        }else{
            $('#error-msg').html("Si è verificato un errore durante la modifica utente. (Il token CSRF potrebbe essere scaduto" +
                " se la protezione CSRF è abilitata) - "+data.replace(/(<([^>]+)>)/ig,""));
            $('#error-alert').removeClass('hidden');
        }
    }

    $('#save-new').click(function(){
        var username = $('#i-username');
        var fullname = $('#i-fullname');
        var email = $('#i-email');
        var password = $('#i-password');
        var cpassword = $('#i-cpassword');
        var group = $('#i-group').val();
        var active = $('#i-activate').prop('checked') ? 1 : 0;
        var p_missing = false;
        var uname_invalid =false;
        var err_msg="";
        $('.alert').addClass('hidden');
        $('.has-error').removeClass('has-error');
        if(username.val()==""){
            p_missing=true;
            username.parent().parent().addClass('has-error');
        }
        if( username.val().match(/[^a-z]+/)!==null) {
            uname_invalid=true;
            username.parent().parent().addClass('has-error');
        }
        if(fullname.val()==""){
            p_missing=true;
            fullname.parent().parent().addClass('has-error');
        }
        if(email.val()==""){
            p_missing=true;
            email.parent().parent().addClass('has-error');
        }
        if(password.val()==""){
            p_missing=true;
            password.parent().parent().addClass('has-error');
        }
        if(cpassword.val()==""){
            p_missing=true;
            cpassword.parent().parent().addClass('has-error');
        }
        if(p_missing){
            err_msg="Uno o più campi non sono stati compliati.<br>";
            $('#error-alert').removeClass('hidden');
        }
        if(uname_invalid){
            err_msg+="Si stanno usando caratteri non consentiti per il nome utente. E' possibile usare solo lettere minuscole.<br>";
            $('#error-alert').removeClass('hidden');
        }
        if(password.val()!==cpassword.val()){
            err_msg+="Le password inserite non corrispondono.<br>";
            password.parent().parent().addClass('has-error');
            cpassword.parent().parent().addClass('has-error');
            $('#error-alert').removeClass('hidden');
        }
        $('#error-msg').html(err_msg);
        if(err_msg!==""){
            return;
        }
        $('#spinner').removeClass('hidden');
        var data= {username: username.val(), fullname: fullname.val(), email: email.val(), password: password.val(), group: group, active: active};
        $.post(window.vbcknd.base_url+'ajax/admin/users/save',data,SaveNewDone);
    });

    function SaveNewDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            $('#success-alert').removeClass('hidden');
        }else{
            $('#error-msg').html("Si è verificato un errore durante la creazione utente. (Il token CSRF potrebbe essere scaduto" +
            " se la protezione CSRF è abilitata) - "+data.replace(/(<([^>]+)>)/ig,""));
            $('#error-alert').removeClass('hidden');
        }
    }
});