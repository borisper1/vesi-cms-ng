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

    $('#save-content').click(function(){
        var data = encodeURIComponent(CKEDITOR.instances.gui_editor.getData());
        var settings ={};
        settings.class=$("#input-class").val();
        settings.placement=$("#input-position").val();
        settings.title=$("#input-title").val();
        settings.linebreak=$("#input-linebreak").prop('checked');
        settings.dismissable=$("#input-dismissable").prop('checked');
        var displayname = encodeURIComponent($("#input-name").val());
        window.vbcknd.content.save(data, encodeURIComponent(JSON.stringify(settings)), displayname);
    });
});