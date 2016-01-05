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
        } else if (element.hasClass('file-manager-folder')) {
            PreparePack([element.data('path')]);
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
    }).on('click', '.file-manager-delete-element', function() {
        CurrentItem = [];
        CurrentItem.push($(this).closest('.file-manager-element').data('path'));
        $('#delete-modal-list').html('<code>'+CurrentItem[0]+'</code>');
        $('#delete-modal').modal();
    });

    $('#fmgr-download').click(function(){
        var SelectedItems = $('.file-manager-select-element:checked');
        if(SelectedItems.length===1){
            var element = SelectedItems.closest('.file-manager-element');
            if (element.hasClass('file-manager-file') || element.hasClass('file-manager-file-previewable')) {
                window.open(window.vbcknd.base_url + element.data('path'));
            } else if (element.hasClass('file-manager-folder')) {
                PreparePack([element.data('path')]);
            }
        }else{
            var paths = [];
            SelectedItems.each(function(){
                paths.push($(this).closest('.file-manager-element').data('path'));
            });
            PreparePack(paths);
        }
    });

    $('#fmgr-delete').click(function(){
        CurrentItem = [];
        var ListObject =$('#delete-modal-list');
        ListObject.empty();
        $('.file-manager-select-element:checked').each(function(){
            var path  = $(this).closest('.file-manager-element').data('path');
            CurrentItem.push(path);
            ListObject.append('<code>'+path+'</code><br>');
        });
        $('#delete-modal').modal();
    });

    $('#delete-modal-confirm').click(function(){
        $('#operation-spinner').removeClass('hidden');
        var paths = encodeURIComponent(CurrentItem.join(';'));
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/delete',
            data: {'paths': paths},
            success: AJAXFileOperationOK,
            error: AJAXFileOperationFailed
        });
    });

    $('#fmgr-rename').click(function(){
        CurrentItem = $('.file-manager-select-element:checked').closest('.file-manager-element');
        $('#i-rename-element').val(CurrentItem.data('path').substr(CurrentItem.data('path').lastIndexOf('/') + 1));
        $('#rename-element-modal').modal();
    });

    $('#rename-element-modal-confirm').click(function(){
        $('#operation-spinner').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/rename',
            data: {'path': encodeURIComponent(CurrentItem.data('path')), 'new_name':  encodeURIComponent($('#i-rename-element').val())},
            success: AJAXFileOperationOK,
            error: AJAXFileOperationFailed
        });
    });

    $('#file-manager-path-indicator').on('click', '.file-manager-path-indicator-link', function(){
        SetPath($(this).data('path'));
    });

    $('.close').click(function(){
        $(this).closest('.alert-dismissible').addClass('hidden');
    });

    function SetPath(path){
        $('#loading-spinner').removeClass('hidden');
        $('#file-manager-path-indicator').addClass('hidden');
        ProcessedRequests = 0;
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/get_path_body',
            data: 'path='+encodeURIComponent(path),
            success: AJAXLoadPath,
            error: AJAXLoadPathFailed
        });
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/get_path_indicator',
            data: 'path='+encodeURIComponent(path),
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

    function AJAXFileOperationOK() {
        $('#operation-spinner').addClass('hidden');
        SetPath(CurrentPath);
    }

    function AJAXFileOperationFailed() {
        $('#operation-spinner').addClass('hidden');
        $('#operation-error').removeClass('hidden');
        SetPath(CurrentPath);
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

    function PreparePack(files)
    {
        $('#operation-spinner').removeClass('hidden');
        var paths = encodeURIComponent(files.join(';'));
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/pack',
            data: {'paths': paths, 'base_path': CurrentPath},
            success: AJAXFilePackOK,
            error: AJAXFileOperationFailed
        });
    }

    function AJAXFilePackOK(data)
    {
        $('#operation-spinner').addClass('hidden');
        window.location.href = data;
    }

    $('#preview-modal').on('hidden.bs.modal',function(){
        $("#preview-modal-content").empty();
    });

});