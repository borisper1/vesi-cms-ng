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
        CKEDITOR.instances.gui_editor.insertHtml('<div class="row"><div class="col-md-6">Colonna 1</div><div class="col-md-6">Colonna 2</div></div>');
    });

    $('#insert-3-columns').click(function(){
        CKEDITOR.instances.gui_editor.insertHtml('<div class="row"><div class="col-md-4">Colonna 1</div><div class="col-md-4">Colonna 2</div><div class="col-md-4">Colonna 3</div></div>');
    });
});