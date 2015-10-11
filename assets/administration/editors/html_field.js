/**
 * Created by gmabo on 05/10/2015.
 */
$(document).ready(function() {
    var editor = ace.edit('code_editor');
    editor.setTheme('ace/theme/chrome');
    editor.getSession().setMode('ace/mode/html');
    editor.getSession().setUseWrapMode(true); //maybe allow to be changed in settings/configuration (per user?)

    $("#edit-code").prop("disabled", true);

    $('#save-content').click(function(){
        var data = encodeURIComponent(editor.getValue());
        var settings = '';
        if($('#jsenable').prop('checked')){
            var object = {};
            object.addjs = $('#addjs').val();
            settings = JSON.stringify(object);
        }
        window.vbcknd.content.save(data, settings, null);
    });

    $('#jsenable').change(function(){
        $('#auxiliary-js-field').toggleClass('hidden');
    })
});