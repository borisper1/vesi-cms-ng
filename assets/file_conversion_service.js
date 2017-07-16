$(document).ready(function() {
    var CallbackFunction, InFormat;
    window.vbcknd.services.file_conversion = {};
    window.vbcknd.services.file_conversion.export_from_html = function (text, out_format, out_name) {
        $('#export-conversion-modal').modal();
        $.ajax({
            type: 'POST',
            url: window.vbcknd.base_url + 'services/file_conversion/export_from_html',
            data: {code: encodeURIComponent(text), output_format: out_format, output_name: out_name},
            success: exportDone,
            error: conversionFailed
        });
    };

    function exportDone(data){
        $('#export-conversion-modal').modal('hide');
        window.location = data;
    }

    window.vbcknd.services.file_conversion.import_to_html = function(in_format, callback_func){
        CallbackFunction = callback_func;
        $('#conversion-file-input').attr('accept', '.'+in_format);
        InFormat = in_format;
        $('#conversion-upload-file-modal').modal();
    };

    $('#conversion-file-upload-form').submit(function(event){
        event.stopPropagation();
        event.preventDefault();
        var file_input = $('#conversion-file-input');
        if(file_input.val() == ""){
            alert('Scegliere un file per l\'importazione');
            return;
        }
        var ext = file_input.val().split('.').pop().toLowerCase();
        if (ext !== InFormat){
            alert('Il file selezionato non è supportato per la conversione con l\'opzione '+InFormat.toUpperCase());
            return;
        }
        $('#conversion-upload-file-modal').modal('hide');
        $('#import-progress-uploading').removeClass('hidden');
        $('#import-progress-converting').addClass('hidden');
        $('#import-conversion-progress-modal').modal();
        $('#import-upload-bar').css('width', '0%').text('0%');
        var form_data = new FormData($('#conversion-file-upload-form')[0]);
        form_data.append('format', InFormat);
        $.ajax({
            type: 'POST',
            url: window.vbcknd.base_url + 'services/file_conversion/import_file_to_html',
            dataType: 'html',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',importUploadProgressHandler, false);
                }
                return myXhr;
            },
            contentType: false,
            processData: false,
            data: form_data,
            success: importDoneHTML,
            error: conversionFailed
        });
    });

    function importUploadProgressHandler(event){
        if(event.lengthComputable){
            if(event.loaded === event.total){
                $('#import-progress-uploading').addClass('hidden');
                $('#import-progress-converting').removeClass('hidden');
            }else{
                var percent = (event.loaded *100 / event.total);
                $('#import-upload-bar').css('width', percent.toFixed(2)+'%').text(Math.round(percent)+'%');
            }
        }else{
            $('#import-progress-uploading').addClass('hidden');
            $('#import-progress-converting').removeClass('hidden');
        }
    }

    function importDoneHTML(data){
        CallbackFunction(data);
        CallbackFunction = null;
        $('#import-conversion-progress-modal').modal('hide');
    }

    function conversionFailed(jqXHR){
        var html = '<p>Il server ha inviato la risposta <code>'+jqXHR.status+' '+jqXHR.statusText+'</code>. I dati inviati dal server sono:</p>'+'<div class="well">'+jqXHR.responseText+'</div>';
        $('#conversion-error-box').collapse('hide').html(html);
        $('#export-conversion-modal').modal('hide');
        $('#import-conversion-progress-modal').modal('hide');
        $('#conversion-failed-modal').modal()
    }

});
