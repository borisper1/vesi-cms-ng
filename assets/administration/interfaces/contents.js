/**
 * Created by gmabo on 02/10/2015.
 */
$(document).ready(function() {
    //Code for the generic editor interface
    var is_new_unsaved = $('#is-new').text()==='true';
    var CurrentId;

    $('#refresh').click(function(){
        if(is_new_unsaved) {
            var id= $('#f-id').text();
            var type= $('#f-type').text();
            window.location.assign(window.vbcknd.base_url + 'admin/contents/new_content/'+type+'::'+id);
        } else {
            var id= $('#f-id').text();
            window.location.assign(window.vbcknd.base_url + 'admin/contents/edit/'+id);
        }
    });

    $('#close-edit').click(function(){
        //Ideally replace with return to referrer
        window.location.assign(window.vbcknd.base_url + 'admin/contents');
    });

    window.vbcknd.content = {};
    window.vbcknd.content.save = function(content, settings, displayname){
        var data ={};
        data.id = $('#f-id').text();
        data.type = $('#f-type').text();
        data.data = content;
        if(settings != null) {
            data.settings = settings;
        }
        if(displayname != null) {
            data.displayname = displayname;
        }
        $('.alert').addClass('hidden');
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/contents/save',data, SaveEditDone);
    };

    function SaveEditDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            if(is_new_unsaved){
                var id= $('#f-id').text();
                history.replaceState( {} , '', window.vbcknd.base_url + 'admin/contents/edit/'+id );
            }
            is_new_unsaved=false;
            $('#success-alert').removeClass('hidden')
        }else{
            $('#error-msg').html("Si è verificato un errore durante il salvataggio del contenuto. I dati inseriti potrebbero essere non validi" +
                " (errore: "+data.replace(/(<([^>]+)>)/ig,"")+")");
            $('#error-alert').removeClass('hidden');
        }
    }

    $('.close').click(function(){
        $(this).closest('.alert-dismissible').addClass('hidden');
    });

    $('#show-all').click(function(){
        var block = $('.content-row');
        block.removeClass('hidden');
    });

    $('#show-orphans').click(function(){
        var block = $('.label-success');
        block.closest('.content-row').addClass('hidden');
    });

    $('.delete-content').click(function(){
        CurrentId = $(this).closest('.content-row');
        $('#delete-modal').modal();
    });

    $('#delete-modal-confirm').click(function(){
        $('.content-alert').addClass('hidden');
        $('#content-deletion-spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/contents/delete_multiple','id_string='+CurrentId.find('.f-id').text(), DeleteContents);
    });

    function DeleteContents(data){
        $('.content-alert').addClass('hidden');
        if(data==='success'){
            CurrentId.remove();
            $('#content-deletion-success').removeClass('hidden');
        }else{
            $('#content-deletion-error').removeClass('hidden');
        }
    }

    $('#new-content').click(function(){
        $('#new-modal').modal();
    });

    $('#new-modal-confirm').click(function(){
        var type = $('#i-content-type').val();
        window.location.assign(window.vbcknd.base_url + 'admin/contents/new_content/'+type);
    });

});