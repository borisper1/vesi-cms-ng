$(document).ready(function() {

    window.vbcknd.services.file_conversion = {};
    window.vbcknd.services.file_conversion.export_from_text = function(text, in_format, out_format){
        $('#export-conversion-modal').modal();
        $.ajax({
            type: 'post',
            url: window.vbcknd.base_url + 'service/file_conversion/export_from_text',
            data: {text: encodeURIComponent(text), text_format: in_format, out_format: out_format},
            success: exportDone,
            error: conversionFailed
        });
    };

    function exportDone(data){

    }

    function conversionFailed(jqXHR){
        var html = '<p>Il server ha inviato la risposta <code>'+jqXHR.status+' '+jqXHR.statusText+'</code>. I dati inviati dal server sono:</p>'+'<div class="well">'+jqXHR.responseText+'</div>';
        $('#conversion-error-box').collapse('hide').html(html);
        $('#export-conversion-modal').modal('hide');
        $('#conversion-failed-modal').modal()
    }

});
