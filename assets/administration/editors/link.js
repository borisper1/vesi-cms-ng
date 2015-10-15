$(document).ready(function() {
    $('#input-target').val($('#target-hidden').text());
    $("#edit-code").remove();

    $('#save-content').click(function(){
        var data = encodeURIComponent($('#link-path').val());
        var title = encodeURIComponent($('#input-title').val());
        var settings={};
        settings.class=$("#input-class").val();
        var target = $("#input-target").val();
        if(target!=""){
            settings.target=target;
        }
        var json = JSON.stringify(settings, null, '\t');
        window.vbcknd.content.save(data, json, title);
    });
});