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
    CKEDITOR.replace('gui_editor', {
        height: '500px',
        on: {
            instanceReady: function () {
                this.dataProcessor.htmlFilter.addRules({
                    elements: {
                        img: function (el) {
                            el.addClass('img-responsive');
                        }
                    }
                });
            }
        }
    });

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

    $('#edit-code').click(function () {
        window.vbcknd.start_code_editor('html', CKEDITOR.instances.gui_editor.getData(), ExecuteSaveComponent);
    });

    function ExecuteSaveComponent(html) {
        window.vbcknd.content.save(encodeURIComponent(html), null, null);
    }

    $('.export-document').click(function(){
        window.vbcknd.services.file_conversion.export_from_text(CKEDITOR.instances.gui_editor.getData(), 'html', $(this).data('format'), $('#f-id').text());
    });

    $('.import-document').click(function(){
        window.vbcknd.services.file_conversion.import_to_html($(this).data('format'), FileImportCallback);
    });

    function FileImportCallback(html){
        CKEDITOR.instances.gui_editor.insertHtml(html);
    }
});