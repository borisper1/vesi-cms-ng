/**
 * Created by Boris on 15/07/2015.
 */
$(document).ready(function() {
    var is_new_unsaved = $('#is-new').text()==='true';
    if(is_new_unsaved){
        $('#edit-attributes-modal').modal();
    }

    var CurrentId;

    $('#new-menu').click(function(){
        window.location.href = window.vbcknd.base_url + 'admin/sec_menu/edit/new';
    });

    $('.delete-menu').click(function(){
        CurrentId = $(this).data('id');
        $('#delete-modal').modal();
    });

    $('#delete-modal-confirm').click(function(){
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/sec_menu/delete','id='+CurrentId, DeleteDone);
    });

    function DeleteDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            window.location.reload(true);
        }else{
            $('#error-msg').html("Si è verificato un errore durante l'eliminazione del menu. (Il token CSRF potrebbe essere scaduto" +
                " se la protezione CSRF è abilitata) - "+data.replace(/(<([^>]+)>)/ig,""));
            $('#error-alert').removeClass('hidden');
        }
    }

    $('#refresh-menu').click(function(){
        if(is_new_unsaved) {
            window.location.href = window.vbcknd.base_url + 'admin/sec_menu/edit/new';
        } else {
            var id= $('#f-menu-id').text();
            window.location.href = window.vbcknd.base_url + 'admin/sec_menu/edit/'+id;
        }
    });

    $('#close-edit').click(function(){
        window.location.href = window.vbcknd.base_url + 'admin/sec_menu';
    });

    $('#edit-attributes').click(function(){
        $('#i-menu-title').val($('#f-main-title').text());
        $('#edit-attributes-modal').modal();
    });

    $('#edit-attributes-confirm').click(function(){
        $('#f-main-title').text($('#i-menu-title').val());
        if($('#menu-display-title').prop('checked')){
            $('#f-show-title').addClass('hidden');
        }else{
            $('#f-show-title').removeClass('hidden');
        }
    });

    $('#save-menu').click(function(){
        var title = $('#f-main-title').text();
        var id= $('#f-menu-id').text();
        var structure = {};
        var display_title = $('#f-show-title').hasClass('hidden') ? 1 : 0;
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
        var json = JSON.stringify(structure, null, '\t');
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/sec_menu/save','id='+id+'&json='+encodeURIComponent(json)+'&title='+encodeURIComponent(title)+'&display_title='+display_title,SaveEditDone);
    });

    function SaveEditDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            is_new_unsaved=false;
            $('#success-alert').removeClass('hidden');
            $('#events-cage').find('.fa-clock-o').remove();
        }else{
            $('#error-msg').html("Si è verificato un errore durante il salvataggio del menu. (Il token CSRF potrebbe essere scaduto" +
                " se la protezione CSRF è abilitata) - "+data.replace(/(<([^>]+)>)/ig,""));
            $('#error-alert').removeClass('hidden');
        }
    }
});