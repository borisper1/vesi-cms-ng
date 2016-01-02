$(document).ready(function() {
    var CurrentPath = $('#boot-path').text();
    var ProcessedRequests = 0;
    var CurrentItem;

    $('#path-files').change(function(){
        SetPath('files');
    });
    $('#path-image').change(function(){
        SetPath('img');
    });

    $('.file-manager-list').on('click', '.file-manager-element-link', function() {
        var element = $(this).closest('.file-manager-element');
        if (element.hasClass('file-manager-folder')) {
            SetPath(element.data('path'));
        } else if (element.hasClass('file-manager-file')) {
            window.open(window.vbcknd.base_url + element.data('path'));
        } else if (element.hasClass('file-manager-file-previewable')) {
            ShowPreviewModal(element.data('path'),element.data('previewmode'))
        }
    }).on('click', '.file-manager-download-element', function() {
        var element = $(this).closest('.file-manager-element');
        if (element.hasClass('file-manager-file') || element.hasClass('file-manager-file-previewable')) {
            window.open(window.vbcknd.base_url + element.data('path'));
        } else if (element.hasClass('file-manager-file')) {
            //TODO: Pack and download file
        }
    }).on('click', '.file-manager-rename-element', function() {
        CurrentItem = $(this).closest('.file-manager-element');
        $('#i-rename-element').val(CurrentItem.data('path').substr(CurrentItem.data('path').lastIndexOf('/') + 1));
        $('#rename-element-modal').modal();
    }).on('change', '.file-manager-select-element', function(){
        var length = $('.file-manager-select-element:checked').length;
        if (length > 0) {
            $('#file-system-actions').removeClass('hidden');
        } else {
            $('#file-system-actions').addClass('hidden');
        }
        $('#fmgr-rename').prop('disabled', length !== 1);
    });

    $('#fmgr-rename').click(function(){
        CurrentItem = $('.file-manager-select-element:checked').closest('.file-manager-element');
        $('#i-rename-element').val(CurrentItem.data('path').substr(CurrentItem.data('path').lastIndexOf('/') + 1));
        $('#rename-element-modal').modal();
    });

    $('')

    $('#file-manager-path-indicator').on('click', '.file-manager-path-indicator-link', function(){
        SetPath($(this).data('path'));
    });

    function SetPath(path){
        $('#loading-spinner').removeClass('hidden');
        $('#file-manager-path-indicator').addClass('hidden');
        ProcessedRequests = 0;
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/get_path_body',
            data: 'path='+path,
            success: AJAXLoadPath,
            error: AJAXLoadPathFailed
        });
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/get_path_indicator',
            data: 'path='+path,
            success: AJAXLoadPathIndicator,
            error: AJAXLoadPathFailed
        });
        CurrentPath = path;
    }

    function AJAXLoadPath(data)
    {
        var html = $(data).find('tbody').html();
        $('.file-manager-list').find('tbody').html(html);
        $('#file-system-actions').addClass('hidden');
        ProcessedRequests+=1;
        if(ProcessedRequests===2){
            $('#loading-spinner').addClass('hidden');
            $('#file-manager-path-indicator').removeClass('hidden');
        }
    }

    function AJAXLoadPathIndicator(data)
    {
        var html = $(data).html();
        $('#file-manager-path-indicator').html(html);
        ProcessedRequests+=1;
        if(ProcessedRequests===2){
            $('#loading-spinner').addClass('hidden');
            $('#file-manager-path-indicator').removeClass('hidden');
        }
    }

    function AJAXLoadPathFailed()
    {
        $('#loading-spinner').addClass('hidden');
        $('#error-warning').removeClass('hidden');
        $('.file-manager-list').find('tbody').empty();
    }
    
    function ShowPreviewModal(path, mode)
    {
        var url=window.vbcknd.base_url+path;
        var content;
        if(mode=='pdf'){
            content='<object data="'+url+'" type="application/pdf" width="100%" height="'+($(window).height()-150).toString()+'px"><div class="alert alert-warning" role="alert"><i class="fa fa-warning"></i> <strong>Attenzione!</strong> Sembra che il tuo browser non supporta l\'integrazione PDF (puoi comunque scaricare il file <a class="alert-link" href="'+url+'" target="_blank">qui</a>)</div></object>';
        }else if(mode=='image'){
            content='<img src="'+url+'" alt="Anteprima immagine" width="100%">';
        }else if(mode=='video'){
            content='<video width="100%" src="'+url+'" controls autoplay><div class="alert alert-warning" role="alert"><i class="fa fa-warning"></i> <strong>Attenzione!</strong> Sembra che il tuo browser non supporta l\'integrazione video (puoi comunque scaricare il file <a class="alert-link" href="'+url+'" target="_blank">qui</a>)</div></video>';
        }else if(mode=='audio'){
            content='<audio width="100%" src="'+url+'" controls autoplay><div class="alert alert-warning" role="alert"><i class="fa fa-warning"></i> <strong>Attenzione!</strong> Sembra che il tuo browser non supporta l\'integrazione audio (puoi comunque scaricare il file <a class="alert-link" href="'+url+'" target="_blank">qui</a>)</div></audio>';
        }
        $('#file-preview-download').attr('href', url);
        $('#preview-modal-content').html(content);
        $('#preview-modal').modal();
    }

});