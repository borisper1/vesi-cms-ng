/**
 * Created by gmabo on 02/10/2015.
 */
$(document).ready(function() {
    //Code for the generic editor interface
    var is_new_unsaved = $('#is-new').text()==='true';

    $('#refresh').click(function(){
        if(is_new_unsaved) {
            window.location.assign(window.vbcknd.base_url + 'admin/contents/edit/new');
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
            is_new_unsaved=false;
            $('#success-alert').removeClass('hidden')
        }else{
            $('#error-msg').html("Si è verificato un errore durante il salvataggio del contenuto. I dati inseriti potrebbero essere non validi" +
                " (errore: "+data.replace(/(<([^>]+)>)/ig,"")+")");
            $('#error-alert').removeClass('hidden');
        }
    }

    $('.close').click(function(){
        $(this).closest('.alert-dismissable').addClass('hidden');
    });

    $('#show-all').click(function(){
        var block = $('.content-row');
        block.removeClass('hidden');
    });

    $('#show-orphans').click(function(){
        var block = $('.label-success');
        block.closest('.content-row').addClass('hidden');
    });

});