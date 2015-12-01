$(document).ready(function() {
    var allowed_modules = $("#onload_allowed_interfaces").text().split(",");
    var SelectedItem;
    allowed_modules.forEach(function(entry){
        $(".select-permission-items[value='"+entry+"']").prop("checked",true);
    });

    if($('#onload_cfilter_status').text()==='false')
    {
        $('#filter-whitelist, #filter-blacklist, #cfilter-gui-add-container, #cfilter-gui-add-page, #cfilter-code-expression').prop('disabled', true);
        $('#cfilter-edit-gui, #cfilter-edit-code').prop('disabled', true).closest('.btn').addClass('disabled');
    }

    $('.vcms-select-group').change(function () {
        if ($('.vcms-select-group:checked').length > 0) {
            $('#group-actions').removeClass('hidden');
        } else {
            $('#group-actions').addClass('hidden');
        }
    });

    $('#enable-content-filter').change(function(){
        if($(this).prop('checked')){
            $('#filter-whitelist, #filter-blacklist, #cfilter-gui-add-container, #cfilter-gui-add-page, #cfilter-code-expression').prop('disabled', false);
            $('#cfilter-edit-gui, #cfilter-edit-code').prop('disabled', false).closest('.btn').removeClass('disabled');
        }else{
            $('#filter-whitelist, #filter-blacklist, #cfilter-gui-add-container, #cfilter-gui-add-page, #cfilter-code-expression').prop('disabled', true);
            $('#cfilter-edit-gui, #cfilter-edit-code').prop('disabled', true).closest('.btn').addClass('disabled');
        }
    });

    $('#cfilter-edit-gui').change(function() {
        $('#cfilter-editor-gui').removeClass('hidden');
        $('#cfilter-editor-code').addClass('hidden');
    });

    $('#cfilter-edit-code').change(function() {
        $('#cfilter-editor-code').removeClass('hidden');
        $('#cfilter-editor-gui').addClass('hidden');
    });
});