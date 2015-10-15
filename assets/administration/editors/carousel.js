$(document).ready(function() {
    $("#edit-code").remove();

    $('#save-content').click(function(){
        var data = encodeURIComponent($('#img-path').val());
        window.vbcknd.content.save(data, null, null);
    });

    $(".update-preview").click(function(){
        var json = {};
        json.id=$('#f-id').text();
        json.path=$('#img-path').val();
        var data ={};
        data.type = $('#f-type').text();
        data.data = encodeURIComponent(JSON.stringify(json));

        var insertion = $(".panel-body");
        insertion.empty();
        insertion.append("<div class='alert alert-info' role='alert'><i class='fa fa-refresh fa-spin'></i> Caricamento anteprima</div>");
        $.post(window.vbcknd.base_url+'ajax/admin/contents/load_editor_preview',data, AJAXPreviewLoad);
    });

    function AJAXPreviewLoad(data){
        var insertion = $(".panel-body");
        if(data=="failed"){
            insertion.empty();
            insertion.append("<div class='alert alert-danger' role='alert'><i class='fa fa-exclamation-circle'></i> <b>Errore durante il caricamento dell'anteprima</b>: Il percorso specificato potrebbe non esistere. Verificare il percorso e assicurarsi che i permessi siano corretti.</div>");
        }else{
            insertion.empty();

            insertion.append(data);
        }
    }

});
