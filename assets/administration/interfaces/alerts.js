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

    $('.close').click(function(){
        $(this).closest('.alert-dismissible').addClass('hidden');
    });

    $('#close-edit').click(function(){
        window.location.href = window.vbcknd.base_url+'admin/alerts';
    });

    function getData(content) {
        var data ={};
        data.id = $('#f-id').text();
        data.type = $('#input-type').val();
        data.dismissible = $('#input-dismissible').prop('checked') ? 1 : 0;
        data.display_on = encodeURIComponent($('#input-pages').val());
        data.content = encodeURIComponent(content);
        return data;
    }

    $('#save-alerts').click(function () {
        $('.alert').addClass('hidden');
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url + 'ajax/admin/alerts/save', getData(CKEDITOR.instances.gui_editor.getData()), SaveEditDone);
    });

    $('#edit-code').click(function () {
        window.vbcknd.start_code_editor('html', CKEDITOR.instances.gui_editor.getData(), ExecuteSaveAlert);
    });

    function ExecuteSaveAlert(html) {
        $('.alert').addClass('hidden');
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url + 'ajax/admin/alerts/save', getData(html), SaveEditDone);
    }

    $('.delete-alert').click(function(){
        CurrentId = $(this).closest('.content-row');
        $('#delete-modal').modal();
    });

    $('#delete-modal-confirm').click(function(){
        $('.alert').addClass('hidden');
        $('#alert-deletion-spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/alerts/delete','id='+CurrentId.find('.f-id').text(), DeleteAlert);
    });

    $('#new-content').click(function(){
        window.location.href = window.vbcknd.base_url+'admin/alerts/edit/new';
    });

    function DeleteAlert(data){
        $('.alert').addClass('hidden');
        if(data==='success'){
            CurrentId.remove();
            $('#alert-deletion-success').removeClass('hidden');
        }else{
            $('#alert-deletion-error').removeClass('hidden');
        }
    }

    function SaveEditDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            if(is_new_unsaved){
                var id= $('#f-id').text();
                history.replaceState( {} , '', window.vbcknd.base_url + 'admin/alerts/edit/'+id );
                is_new_unsaved=false;
            }
            $('#success-alert').removeClass('hidden')
        }else{
            $('#error-msg').html("Si è verificato un errore durante il salvataggio dell'avviso. I dati inseriti potrebbero essere non validi" +
                " (errore: "+data.replace(/(<([^>]+)>)/ig,"")+")");
            $('#error-alert').removeClass('hidden');
        }
    }

});