$(document).ready(function() {
    if ($('#is-new').length > 0) {
        var is_new_unsaved = $('#is-new').text()==='true';
        // We are in editing mode, try to start CKEditor
        CKEDITOR.config.baseHref = window.vbcknd.base_url;
        CKEDITOR.config.contentsCss = [
            window.vbcknd.base_url+'assets/third_party/bootstrap/css/bootstrap-custom.min.css',
            window.vbcknd.base_url+'assets/third_party/fontawesome/css/font-awesome.min.css',
            window.vbcknd.base_url+'assets/third_party/ckeditor/contents.css'];
        //Allow empty span tags for Font Awesome icons!
        CKEDITOR.dtd.$removeEmpty['span'] = false;
        CKEDITOR.replace('gui_editor',{height: '250px'});
        $('#input-type').selectpicker('val', $('#type-hidden').text());
    }
    var CurrentId;

    $('#refresh').click(function(){
        window.location.reload(true);
    });

    $('#close-edit').click(function(){
        window.location.href = window.vbcknd.base_url+'admin/alerts';
    });

    $('#save-alerts').click(function(){
        var data ={};
        data.id = $('#f-id').text();
        data.type = $('#input-type').val();
        data.disimissible = $('#input-dismissible').prop('checked') ? 1 : 0;
        data.display_on = encodeURIComponent($('#input-pages').val());
        data.content = encodeURIComponent(CKEDITOR.instances.gui_editor.getData());
        $.post(window.vbcknd.base_url+'ajax/admin/alerts/save',data, SaveEditDone);
    });


    function SaveEditDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            is_new_unsaved=false;
            if(is_new_unsaved){
                var id= $('#f-id').text();
                history.replaceState( {} , '', window.vbcknd.base_url + 'admin/alerts/edit/'+id );
            }
            $('#success-alert').removeClass('hidden')
        }else{
            $('#error-msg').html("Si è verificato un errore durante il salvataggio dell'avviso. I dati inseriti potrebbero essere non validi" +
                " (errore: "+data.replace(/(<([^>]+)>)/ig,"")+")");
            $('#error-alert').removeClass('hidden');
        }
    }

});