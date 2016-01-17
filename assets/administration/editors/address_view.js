$(document).ready(function() {
    //Load the CKEditor instance for the page
    //REQUIRED for all editor instances
    CKEDITOR.config.baseHref = window.vbcknd.base_url;
    CKEDITOR.config.contentsCss = [
        window.vbcknd.base_url+'assets/third_party/bootstrap/css/bootstrap-custom.min.css',
        window.vbcknd.base_url+'assets/third_party/fontawesome/css/font-awesome.min.css',
        window.vbcknd.base_url+'assets/third_party/ckeditor/contents.css'];
    //Allow empty span tags for Font Awesome icons!
    CKEDITOR.replace('gui_editor',{
        height: '150px',
        allowedContent: 'strong em br',
        forcePasteAsPlainText: true,
        enterMode: CKEDITOR.ENTER_BR,
        toolbarGroups: [
            {"name":"basicstyles","groups":["basicstyles"]},
            {"name":"document","groups":["mode"]}
        ]
    });
    $('.sortable').sortable().disableSelection();

    function generateJSON() {
        var json={};
        json.address_road=CKEDITOR.instances.gui_editor.getData();
        json.email=[];
        $("#email-container").children("li").each(function(){
            var element={};
            element.type=$(this).find(".f-type").text();
            element.address=$(this).find(".f-address").text();
            element.label=$(this).find(".f-label").text();
            json.email.push(element);
        });
        json.phone=[];
        $("#phone-container").children("li").each(function(){
            var element={};
            element.type=$(this).find(".f-type").text();
            element.phone=$(this).find(".f-number").text();
            element.label=$(this).find(".f-label").text();
            json.phone.push(element);
        });
        return encodeURIComponent(JSON.stringify(json, null, '\t'));
    }

    $('#save-content').click(function () {
        window.vbcknd.content.save(generateJSON(), null, null);
    });

    $('#edit-code').click(function () {
        window.vbcknd.start_code_editor('json', decodeURIComponent(generateJSON()), ExecuteSaveComponent);
    });

    function ExecuteSaveComponent(json) {
        window.vbcknd.content.save(encodeURIComponent(json), null, null);
    }

    $('#new-email').click(function(){
        $('#email-new-modal').modal();
    });

    $('#email-new-modal-confirm').click(function(){
        var $item = $('#email-template').children().clone();
        $item.find('.f-type').text($('#email-type').val());
        $item.find('.f-address').text($('#email-address').val());
        $item.find('.f-label').text($('#email-label').val());
        $item.find('span.label-default').after(' <i class="fa fa-clock-o"></i>');
        $("#email-container").append('<li class="ui-sortable-handle">'+$item[0].outerHTML+'</li>');
    });

    $('#new-phone').click(function(){
        $('#phone-new-modal').modal();
    });

    $('#phone-new-modal-confirm').click(function(){
        var $item = $('#phone-template').children().clone();
        var type = $('#phone-type').val();
        $item.find('.f-type').text(type);
        $item.find('.f-icon').addClass(type=='standard' ? 'fa-phone' : 'fa-fax');
        $item.find('.f-number').text($('#phone-number').val());
        $item.find('.f-label').text($('#phone-label').val());
        $item.find('span.label-default').after(' <i class="fa fa-clock-o"></i>');
        $("#phone-container").append('<li class="ui-sortable-handle">'+$item[0].outerHTML+'</li>');
    });

    $('#events-cage').on('click','.remove-item',function(){
        $(this).closest('li').remove();
    });
});