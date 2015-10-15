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
    CKEDITOR.replace('gui_editor',{height: '500px'});

    $('#insert-2-columns').click(function(){
        CKEDITOR.instances.gui_editor.insertHtml('<div class="row"><div class="col-md-6"><p>Colonna 1</p></div><div class="col-md-6"><p>Colonna 2</p></div></div>');
    });

    $('#insert-3-columns').click(function(){
        CKEDITOR.instances.gui_editor.insertHtml('<div class="row"><div class="col-md-4"><p>Colonna 1</p></div><div class="col-md-4"><p>Colonna 2</p></div><div class="col-md-4"><p>Colonna 3</p></div></div>');
    });

    $('#save-content').click(function(){
        var data = encodeURIComponent(CKEDITOR.instances.gui_editor.getData());
        window.vbcknd.content.save(data, null, null);
    });
});