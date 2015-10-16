$(document).ready(function() {
    //Load the CKEditor instance for the page
    //REQUIRED for all editor instances
    CKEDITOR.config.baseHref = window.vbcknd.base_url;
    CKEDITOR.config.contentsCss = [
        window.vbcknd.base_url+'assets/third_party/bootstrap/css/bootstrap-custom.min.css',
        window.vbcknd.base_url+'assets/third_party/fontawesome/css/font-awesome.min.css',
        window.vbcknd.base_url+'assets/third_party/ckeditor/contents.css'];
    //Allow empty span tags for Font Awesome icons!
    CKEDITOR.dtd.$removeEmpty['span'] = false;
    CKEDITOR.replace('gui_editor',{height: '250px'});

    $('#save-content').click(function(){
        var data = encodeURIComponent(CKEDITOR.instances.gui_editor.getData());
        var settings ={};
        settings.trigger_class=$("#input-class").val();
        settings.close=$("#input-close").prop('checked');
        settings.large=$("#input-large").prop('checked');
        var displayname = encodeURIComponent($("#input-title").val());
        window.vbcknd.content.save(data, encodeURIComponent(JSON.stringify(settings)), displayname);
    });
});