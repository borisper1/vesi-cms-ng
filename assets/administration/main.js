//Define vbcknd namespace data
window.vbcknd.services = {};
window.vbcknd.config = {};
window.vbcknd.auto_name_format = function (title) {
    return title.replace(/[^A-Za-z0-9 ]+/, '').replace(/\s+/g, '-').toLowerCase().substr(0, 40);
};
window.vbcknd.auto_file_size_format = function (size) {
    var i = -1;
    var byteUnits = [' kiB', ' MiB', ' GiB', ' TiB'];
    do {
        size = size / 1024;
        i++;
    } while (size > 1024);
    return Math.max(size, 0.01).toFixed(2) + byteUnits[i];
};
window.vbcknd.validation = {};
window.vbcknd.validation.clear_all_errors = function () {
    $('.has-error').removeClass('has-error');
};

window.vbcknd.validation.check_system_syntax = function (object) {
    if (!object.val().match(/^[a-z0-9-]+$/) || object.val() === '') {
        object.closest('.form-group').addClass('has-error');
        return 1;
    } else {
        return 0;
    }
};

window.vbcknd.validation.check_is_empty = function (object) {
    if (object.val() === '') {
        object.closest('.form-group').addClass('has-error');
        return 1;
    } else {
        return 0;
    }
};

$(document).ready(function () {
    var code_editor_callback;

    $('.selectpicker').selectpicker();
    window.vbcknd.code_editor = ace.edit('code-editor');

    window.vbcknd.start_code_editor = function (mode, data, saveCallback) {
        window.vbcknd.code_editor.setTheme('ace/theme/chrome');
        window.vbcknd.code_editor.getSession().setMode('ace/mode/' + mode);
        window.vbcknd.code_editor.setValue(data, -1);
        window.vbcknd.code_editor.getSession().setUseWrapMode(true);
        code_editor_callback = saveCallback;
        $('#code-editor-modal').modal();
    };

    $('#code-editor-save').click(function () {
        code_editor_callback(window.vbcknd.code_editor.getValue());
        $('#code-editor-modal').modal('hide');
    });

    $('.launch-contextual-help').click(function () {
        var path = $(this).data('help_path');
        $.ajax({
            type: 'POST',
            url: window.vbcknd.base_url + 'services/contextual_help/load_help',
            data: {path: path},
            success: loadHelp,
            error: loadHelpError
        });
    });

    function loadHelp(data) {
        $('#contextual-help-modal-body').html(data);
        $('#contextual-help-modal').modal();
    }

    function loadHelpError(jqXHR) {
        var html = '<p>Il server ha inviato la risposta <code>' + jqXHR.status + ' ' + jqXHR.statusText + '</code>. I dati inviati dal server sono:</p>' + '<div class="well">' + jqXHR.responseText + '</div>';
        $('#help-error-box').collapse('hide').html(html);
        $('#help-error-modal').modal()
    }
});

$(document).ready(function() {
    $("body").tooltip({
        html: true,
        selector: ".tooltipped"
    });
});

//POLYFILLS FOR NON ECMASCRIPT6 Browsers --------------------------------------------------------------------------------
if (!String.prototype.startsWith) {
    String.prototype.startsWith = function(searchString, position) {
        position = position || 0;
        return this.indexOf(searchString, position) === position;
    };
}