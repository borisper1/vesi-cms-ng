$(document).ready(function() {
    $("#edit-code").remove();

    $('#save-content').click(function(){
        var data = encodeURIComponent($('#pdf-path').val());
        window.vbcknd.content.save(data, null, null);
    });

    $(".update-preview").click(function(){
        //check first if it is an URL.
        var url = $("#pdf-path").val();
        var address = window.location.href;
        var urlPattern = new RegExp("(https?|ftp):\\/\\/[\\w-]+(\\.[\\w-]+)+([\\w.,@?^=%&amp;:/~+#-]*[\\w@?^=%&amp;/~+#-])?");
        var exist = false;
        if(urlPattern.exec(url)!==null){
            address = url;
            var insertion = $(".panel-body");
            insertion.empty();
            insertion.append("<div class='alert alert-warning' role='alert'>"+
                "<i class='fa fa-warning'></i> <strong>Attenzione!</strong> Il file è archiviato su un altro server. Non è possibile verificare l'esistenza del file. Verrà comunque tentata la visualizzazione dell'anteprima.</div>")
            insertion.append("<object data='"+address+"' type='application/pdf' width='100%' height='500px'><div class='alert alert-warning' role='alert'>"+
                "<i class='fa fa-warning'></i> <strong>Attenzione!</strong> Sembra che il tuo browser non supporti l'integrazione PDF (puoi comunque scaricare il file <a class='alert-link' href='"+address+"' target='_blank'>qui</a>)"+
                "</div></object>")
        }else{
            address = window.vbcknd.base_url + url;
            $.ajax({
                type: 'HEAD',
                url: address,
                success: function() {LoadPDFPreview(address,true);},
                error: function() {LoadPDFPreview(address,false);}
            });
        }
    });

    function LoadPDFPreview(address,exists){
        var insertion = $(".panel-body");
        insertion.empty();
        if(exists){
            insertion.append("<object data='"+address+"' type='application/pdf' width='100%' height='500px'><div class='alert alert-warning' role='alert'>"+
                "<i class='fa fa-warning'></i> <strong>Attenzione!</strong> Sembra che il tuo browser non supporti l'integrazione PDF (puoi comunque scaricare il file <a class='alert-link' href='"+address+"' target='_blank'>qui</a>)"+
                "</div></object>")
        }else{
            insertion.append("<div class='alert alert-danger' role='alert'>"+
                "<i class='fa fa-exclamation-circle'></i> <strong>Errore!</strong> Il file specificato non esiste. Verificare il percorso o l'URL e verificare che i permessi siano corretti.</div>")
        }
    }
});
