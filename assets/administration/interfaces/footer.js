
$(document).ready(function() {
    var editor = ace.edit('code_editor');
    editor.setTheme('ace/theme/chrome');
    editor.getSession().setMode('ace/mode/html');
    editor.getSession().setUseWrapMode(true); //maybe allow to be changed in settings/configuration (per user?)

    $('#refresh').click(function(){
        window.location.reload(true);
    });

    $('#i-activate').bootstrapSwitch();

    $('#save-footer').click(function(){
        var active = $('#i-activate').prop('checked') ? 1 : 0;
        var html = encodeURIComponent(editor.getValue());
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/footer/save','enable='+active+'&html='+html,SaveEditDone)
    });

    function SaveEditDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            $('#success-alert').removeClass('hidden');
        }else{
            $('#error-msg').html("Si è verificato un errore durante il salvataggio del pié di pagina. (Il token CSRF potrebbe essere scaduto" +
                " se la protezione CSRF è abilitata) - "+data.replace(/(<([^>]+)>)/ig,""));
            $('#error-alert').removeClass('hidden');
        }
    }

});