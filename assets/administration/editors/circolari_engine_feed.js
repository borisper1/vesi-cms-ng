/**
 * Created by gmabo on 02/02/2016.
 */
$(document).ready(function() {
   $('#add-category').click(function(){
       $('#i-category').val('');
       $('#i-remapping').val('');
       $('#link-category-modal').modal();
   });

    $('#link-category-modal-confirm').click(function(){
        var $item = $('#category-template').children().clone();
        $item.find('.category').text($('#i-category').val());
        $item.find('.remapping-url').text($('#i-remapping').val());
        $("#gui-editor-area").append($item[0].outerHTML+'&nbsp;');
    });

    $('#gui-editor-area').on('click', '.category-element', function(){
        $(this).closest('.category-element').remove();
    });

    function generateJSON() {
        var json={};
        $('#gui-editor-area').find('.category-element').each(function(){
            var prop =$(this).find('.category').text();
            json[prop] = $(this).find('.remapping-url').text();
        });
        return encodeURIComponent(JSON.stringify(json, null, '\t'));
    }

    function getSettings() {
        var settings ={};
        settings.class=$("#input-class").val();
        settings.limit=$("#input-limit").val();
        return encodeURIComponent(JSON.stringify(settings));
    }

    $('#save-content').click(function () {
        var displayname = encodeURIComponent($("#input-title").val());
        window.vbcknd.content.save(generateJSON(), getSettings(), displayname);
    });

    $('#edit-code').click(function () {
        window.vbcknd.start_code_editor('json', decodeURIComponent(generateJSON()), ExecuteSaveComponent);
    });

    function ExecuteSaveComponent(html) {
        var displayname = encodeURIComponent($("#input-title").val());
        window.vbcknd.content.save(encodeURIComponent(html), getSettings(), displayname);
    }
});

