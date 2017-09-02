$(document).ready(function (e) {
    var CurrentItem = {};
    CurrentItem.target = '/';
    $('#choose-target-fs-view').on('click', '.file-manager-picker-link', function () {
        var element = $(this).closest('.file-picker-element');
        if (element.hasClass('file-picker-folder')) {
            UpdatePathSelector(element.data('path'));
        } else if (element.hasClass('file-picker-file') || element.hasClass('file-picker-file-previewable')) {
            window.opener.CKEDITOR.tools.callFunction(parseInt($('#function-number').text()), window.vbcknd.base_url + element.data('path'));
            window.close();
        }
    });

    function UpdatePathSelector(path) {
        $.ajax({
            type: "POST",
            url: window.vbcknd.base_url + 'services/file_browser/get_path_picker_table',
            data: {'path': path, 'mode': 'all_files'},
            success: LoadPathInModal,
            error: LoadPathInModalError
        });
        CurrentItem.target = path;
        $('#file-picker-path-indicator').text(path);
        $('#file-picker-level-up').prop('disabled', path === '/');
        $('#file-picker-upload-file').prop('disabled', path === '/');
    }

    $('#file-picker-level-up').click(function () {
        var path_array = CurrentItem.target.split('/');
        path_array.pop();
        var new_path = path_array.join('/') === '' ? '/' : path_array.join('/');
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
});