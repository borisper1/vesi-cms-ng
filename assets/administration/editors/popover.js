$(document).ready(function() {
    $('#input-position').val($('#position-hidden').text());
    //Load the CKEditor instance for the page
    //REQUIRED for all editor instances
    CKEDITOR.config.baseHref = window.vbcknd.base_url;
    CKEDITOR.config.contentsCss = [
        window.vbcknd.base_url+'assets/third_party/bootstrap/css/bootstrap-custom.min.css',
        window.vbcknd.base_url+'assets/third_party/fontawesome/css/font-awesome.min.css',
        window.vbcknd.base_url+'assets/third_party/ckeditor/contents.css'];
    //Allow empty span tags for Font Awesome icons!
    CKEDITOR.dtd.$removeEmpty['span'] = false;
    CKEDITOR.replace('gui_editor',{
        height: '250px',
        allowedContent: 'strong em p br ol li ul h4 h5 h6 code kbd u s sub sup pre; a[!href,target];',
        forcePasteAsPlainText: true,
        enterMode: CKEDITOR.ENTER_P
    });

    function getSettings() {
        var settings ={};
        settings.class=$("#input-class").val();
        settings.placement=$("#input-position").val();
        settings.title=$("#input-title").val();
        settings.linebreak=$("#input-linebreak").prop('checked');
        settings.dismissable=$("#input-dismissable").prop('checked');
        return encodeURIComponent(JSON.stringify(settings));
    }

    $('#save-content').click(function () {
        var data = encodeURIComponent(CKEDITOR.instances.gui_editor.getData());
        var displayname = encodeURIComponent($("#input-name").val());
        window.vbcknd.content.save(data, getSettings(), displayname);
    });

    $('#edit-code').click(function () {
        window.vbcknd.start_code_editor('html', CKEDITOR.instances.gui_editor.getData(), ExecuteSaveComponent);
    });

    function ExecuteSaveComponent(html) {
        var displayname = encodeURIComponent($("#input-title").val());
        window.vbcknd.content.save(encodeURIComponent(html), getSettings(), displayname);
    }
});