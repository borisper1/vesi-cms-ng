$(document).ready(function () {
    if ($('#is-new').length > 0) {
        var is_new_unsaved = $('#is-new').text() === 'true';
        // We are in editing mode, try to start CKEditor
        CKEDITOR.config.baseHref = window.vbcknd.base_url;
        CKEDITOR.config.contentsCss = [
            window.vbcknd.base_url + 'assets/third_party/bootstrap/css/bootstrap-custom.min.css',
            window.vbcknd.base_url + 'assets/third_party/fontawesome/css/font-awesome.min.css',
            window.vbcknd.base_url + 'assets/third_party/ckeditor/contents.css'];
        //Allow empty span tags for Font Awesome icons!
        CKEDITOR.dtd.$removeEmpty['span'] = false;
        CKEDITOR.replace('gui_editor', {height: '250px'});
        $('#input-type').selectpicker('val', $('#type-hidden').text());
    }

    $('#go-back-index').click(function () {
        window.location.href = window.vbcknd.base_url + 'admin/circolari_engine'
    });


});