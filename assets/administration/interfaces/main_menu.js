/**
 * Created by Boris on 15/07/2015.
 */
$(document).ready(function() {

    $('#refresh-menu').click(function(){
        window.location.reload(true);
    });

    function generateSaveJSON() {
        var structure = {};
        structure.type='menu';
        structure.items=[];
        $('#events-cage').find('.parent-voices').each(function(){
            var menu ={};
            menu.title=$(this).find('.f-title').text();
            menu.container=$(this).find('.f-container').text();
            menu.type=$(this).data('type');
            if(menu.type==='dropdown') {
                menu.items=[];
                $(this).closest('.panel-primary').find('.child-voices').each(function(){
                    var voice={};
                    voice.title=$(this).find('.f-title').text();
                    voice.page=$(this).find('.f-page').text();
                    menu.items.push(voice);
                });
            }else{
                menu.page=$(this).find('.f-page').text();
            }
            structure.items.push(menu);
        });
        return JSON.stringify(structure, null, '\t');
    }

    $('#save-menu').click(function () {
        ExecuteSaveMenu(generateSaveJSON())
    });

    $('#edit-code').click(function () {
        window.vbcknd.start_code_editor('json', generateSaveJSON(), ExecuteSaveMenu);
    });

    function ExecuteSaveMenu(json) {
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/main_menu/save','json='+encodeURIComponent(json),SaveEditDone);
    }

    function SaveEditDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            $('#success-alert').removeClass('hidden');
            $('#events-cage').find('.fa-clock-o').remove();
        }else{
            $('#error-msg').html("Si è verificato un errore durante il salvataggio del menu. (Il token CSRF potrebbe essere scaduto" +
                " se la protezione CSRF è abilitata) - "+data.replace(/(<([^>]+)>)/ig,""));
            $('#error-alert').removeClass('hidden');
        }
    }
});