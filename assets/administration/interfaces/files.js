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
    }).on('click', '.file-manager-copy-element', function() {
        CurrentItem = {};
        CurrentItem.paths = [];
        CurrentItem.paths.push($(this).closest('.file-manager-element').data('path'));
        CurrentItem.action = 'copy';
        CurrentItem.target = '/';
        LoadPathSelector();
    }).on('click', '.file-manager-move-element', function() {
        CurrentItem = {};
        CurrentItem.paths = [];
        CurrentItem.paths.push($(this).closest('.file-manager-element').data('path'));
        CurrentItem.action = 'move';
        CurrentItem.target = '/';
        LoadPathSelector();
    });

    $('#filemgr-upload-file').click(function(){
        $('#upload-engine-file-cage').find('.upload-engine-file-indicator').empty();
        $('#upload-engine-target-field').val(CurrentPath);
        if(CurrentPath.startsWith('img')){
            $('#upload-engine-image-warning').removeClass('hidden');
        }else{
            $('#upload-engine-image-warning').addClass('hidden');
        }
        $('#upload-file-modal').modal();
    });

    $('#fmgr-copy').click(function(){
        CurrentItem = {};
        CurrentItem.paths = [];
        $('.file-manager-select-element:checked').each(function(){
            CurrentItem.paths.push($(this).closest('.file-manager-element').data('path'));
        });
        CurrentItem.action = 'copy';
        CurrentItem.target = '/';
        LoadPathSelector();
    });

    $('#fmgr-move').click(function(){
        CurrentItem = {};
        CurrentItem.paths = [];
        $('.file-manager-select-element:checked').each(function(){
            CurrentItem.paths.push($(this).closest('.file-manager-element').data('path'));
        });
        CurrentItem.action = 'move';
        CurrentItem.target = '/';
        LoadPathSelector();
    });

    $('#filemgr-new-folder').click(function(){
        $('#i-folder-name').val('');
        $('#new-folder-modal').modal();
    });

    $('#new-folder-modal-confirm').click(function(){
        var name = encodeURIComponent($('#i-folder-name').val());
        $('#operation-spinner').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/new_folder',
            data: {'path': encodeURIComponent(CurrentPath), 'name': name},
            success: AJAXFileOperationOK,
            error: AJAXFileOperationFailed
        });
    });

    //BEGIN PATH SELECTOR CODE -----------------------------------------------------------------------------------------

    function LoadPathSelector(){
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/get_path_picker_table',
            data: {'path': CurrentItem.target},
            success: LoadPathInModal,
            error: LoadPathInModalError
        });
        $('#file-picker-path-indicator').text('/');
        $('#choose-target-fs-view').find('table').remove();
        $('#choose-target-modal').modal();
    }

    $('#choose-target-fs-view').on('click', '.file-manager-picker-link', function(){
        var element = $(this).closest('.file-picker-element');
        if (element.hasClass('file-picker-folder')) {
            UpdatePathSelector(element.data('path'));
        }
    });
    
    function UpdatePathSelector(path){
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/get_path_picker_table',
            data: {'path': path, 'mode': 'only_folders'},
            success: LoadPathInModal,
            error: LoadPathInModalError
        });
        CurrentItem.target = path;
        $('#file-picker-path-indicator').text(path);
        $('#file-picker-level-up').prop('disabled', path==='/');
    }

    $('#file-picker-level-up').click(function(){
        var path_array = CurrentItem.target.split('/');
        path_array.pop();
        var new_path = path_array.join('/')==='' ? '/' : path_array.join('/');
        UpdatePathSelector(new_path);
    });

    function LoadPathInModal(data) {
        var object = $('#choose-target-fs-view');
        object.find('table').remove();
        object.append(data);
    }

    function LoadPathInModalError() {
        var object = $('#choose-target-fs-view');
        object.find('table').remove();
        object.append('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Si è verificato un errore durante il caricamento dell\'elenco</div>');
    }

    $('#choose-target-modal-confirm').click(function(){
        $('#operation-spinner').removeClass('hidden');
        var paths = encodeURIComponent(CurrentItem.paths.join(';'));
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url+'ajax/admin/files/' + CurrentItem.action,
            data: {'paths': paths, 'target': encodeURIComponent(CurrentItem.target)},
            success: AJAXFileOperationOK,
            error: AJAXFileOperationFailed
        });
    });

    //END PATH SELECTOR CODE -------------------------------------------------------------------------------------------

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

    //BEGIN UPLOAD HANDLING SECTION ------------------------------------------------------------------------------------

    $('#upload-engine-select-files').click(function(){
        $('#upload-engine-files-input').click();
    });

    $('#upload-engine-drop-zone').on('drop dragover', function (e) {
        e.preventDefault();
    });

    var UploadEngineContainer = $('#upload-engine-file-cage');

    $('#upload-engine-form').fileupload({
        dropZone: $('#upload-engine-drop-zone'),
        dataType:'json',
        limitConcurrentUploads: 3,
        maxChunkSize: 5000000,
        //paramName: 'files[]',
        add: function (e, data) {
            var  $item = $('#file-uploading-template').children().clone();
            $item.find('.upload-engine-file-label').html(data.files[0].name+ ' (<i>' + formatFileSize(data.files[0].size) + '</i>)');
            data.context = $item.appendTo(UploadEngineContainer);
            data.context.find('.btn-sm').click(function(){
                if(data.context.data('status')==='uploading'){
                    jqXHR.abort();
                }
                data.context.remove();
            });
            var jqXHR = data.submit();
        },
        progress: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);
            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('.progress-bar').width(progress+'%');
            data.context.find('.upload-engine-file-progress-label').text(progress+'%');
            if(progress == 100){
                data.context.data('status', 'finished');
            }
        },
        done:function(e, data){
            console.debug(data.result);
            data.context.find('.btn-sm').html('<i class="fa fa-remove"></i> Chiudi');
            if(typeof data.result.files[0].error !== 'undefined'){
                data.context.data('status', 'failed');
                data.context.find('.progress-bar').addClass('progress-bar-danger');
                data.context.find('.upload-engine-file-failed').removeClass('hidden');
            }else{
                data.context.data('status', 'success');
                data.context.find('.progress-bar').addClass('progress-bar-success');
            }
            SetPath(CurrentPath);
        },
        fail:function(e, data){
            data.context.data('status', 'failed');
            data.context.find('.progress-bar').addClass('progress-bar-danger');
            data.context.find('.upload-engine-file-failed').removeClass('hidden');
            data.context.find('.btn-sm').html('<i class="fa fa-remove"></i> Chiudi');
            SetPath(CurrentPath);
        }
    });

    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }
        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }
        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }
        return (bytes / 1000).toFixed(2) + ' KB';
    }
});