$(document).ready(function() {
    //NON_EDITOR FUNCTIONS
    var CurrentItem;

    $('.vcms-select-group').change(function () {
        if ($('.vcms-select-group:checked').length > 0) {
            $('#group-actions').removeClass('hidden');
        } else {
            $('#group-actions').addClass('hidden');
        }
    });

    $('#delete-groups').click(function(){
        var groups=[];
        var members="";
        $('.vcms-select-group:checked').each(function(){
            groups.push($(this).val());
            var temp = $(this).closest('tr').find('.group-members').html().trim();
            if(temp!=''){
                members+=temp;
            }
        });
        CurrentItem=groups;
        $('#users-remaining-list').html(members);
        if(members!=""){
            $('#users-remaining').removeClass('hidden');
        }else{
            $('#users-remaining').addClass('hidden');
        }
        $('#delete-modal').modal();
    });

    $('#delete-modal-confirm').click(function(){
        $.post(window.vbcknd.base_url+'ajax/admin/groups/delete','groups='+CurrentItem.join(','),RefreshAJAXDone);
    });

    $('#enable-groups').click(function(){
        var groups=[];
        $('.vcms-select-group:checked').each(function(){
            groups.push($(this).val());
        });
        $.post(window.vbcknd.base_url+'ajax/admin/groups/enable','groups='+groups.join(','),RefreshAJAXDone);
    });

    $('#disable-groups').click(function(){
        var groups=[];
        $('.vcms-select-group:checked').each(function(){
            groups.push($(this).val());
        });
        $.post(window.vbcknd.base_url+'ajax/admin/groups/disable','groups='+groups.join(','),RefreshAJAXDone);
    });

    function RefreshAJAXDone(){
        //TODO: Add error messages if request failed
        window.location.reload(true);
    }

    $('#new-group').click(function(){
        window.location = window.vbcknd.base_url + 'admin/groups/edit/new';
    });


    //initialize the editor using hidden onload field values -----------------------------------------------------------
    var is_new_unsaved = $('#is-new').text()==='true';
    var allowed_interfaces = $('#onload_allowed_interfaces').text().split(",");
    allowed_interfaces.forEach(function(entry){
        $(".select-permission-item[value='"+entry+"']").prop("checked",true);
    });

    if($('#onload_cfilter_status').text()==='false') {
        $('#filter-whitelist, #filter-blacklist, #cfilter-gui-add-container, #cfilter-gui-add-page, #cfilter-code-expression').prop('disabled', true);
        $('#cfilter-edit-gui, #cfilter-edit-code').prop('disabled', true).closest('.btn').addClass('disabled');
    }

    if($('#onload_cfilter_mode').text()==='blacklist') {
        $('#filter-blacklist').prop('checked', true);
    }else{
        $('#filter-whitelist').prop('checked', true);
    }
    CSV_to_GUI($('#cfilter-code-expression').val());

    //END Initialization -----------------------------------------------------------------------------------------------

    $('#refresh').click(function(){
        window.location.reload(true);
    });

    $('#close-edit').click(function(){
        window.location.href = window.vbcknd.base_url + 'admin/groups';
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
        if($('#cfilter-code-expression').prop('disabled')===false) {
            $('#cfilter-editor-gui').removeClass('hidden');
            $('#cfilter-editor-code').addClass('hidden');
            CSV_to_GUI($('#cfilter-code-expression').val());

        }
    });

    $('#cfilter-edit-code').change(function(){
        if($('#cfilter-code-expression').prop('disabled')===false){
            $('#cfilter-editor-gui').addClass('hidden');
            $('#cfilter-editor-code').removeClass('hidden');
            $('#cfilter-code-expression').text(GUI_to_CSV());
        }
    });

    $('#gui-editor-area').on('click', '.delete-filter-element', function(){
        if($('#cfilter-code-expression').prop('disabled')===false){
            $(this).closest('.filter-element').remove();
        }
    });

    function GUI_to_CSV(){
        var array_prototype = [];
        $('#gui-editor-area').find('.filter-element').each(function(){
            if($(this).hasClass('filter-container')){
                array_prototype.push($(this).find('.container-name').text());
            }else if($(this).hasClass('filter-page')){
                array_prototype.push($(this).find('.page-container').text()+'::'+$(this).find('.page-name').text());
            }
        });
        return array_prototype.join(',');
    }

    function CSV_to_GUI(csv){
        var allowed_contents = csv.replace(/\r?\n|\r/g,"").split(",");
        $("#gui-editor-area").empty();
        if(csv!==''){
            allowed_contents.forEach(function(entry){
                if(entry.indexOf('::')===-1){
                    var $item = $('#container-filter-template').children().clone();
                    $item.find('.container-name').text(entry);
                    $("#gui-editor-area").append($item[0].outerHTML+'&nbsp;');
                }else{
                    var strings = entry.split('::');
                    var $item = $('#page-filter-template').children().clone();
                    $item.find('.page-container').text(strings[0]);
                    $item.find('.page-name').text(strings[1]);
                    $("#gui-editor-area").append($item[0].outerHTML+'&nbsp;');
                }
            });
        }
    }

    $('#cfilter-gui-add-container').click(function(){
        $('#new-content-filter-modal').modal();
        $('#i-container-filter-container').val('');
    });

    $('#new-container-filter-modal-confirm').click(function(){
        var $item = $('#container-filter-template').children().clone();
        $item.find('.container-name').text($('#i-container-filter-container').val());
        $("#gui-editor-area").append($item[0].outerHTML+'&nbsp;');
    });

    $('#cfilter-gui-add-page').click(function(){
        $('#new-page-filter-modal').modal();
        $('#i-page-filter-container').val('');
        $('#i-page-filter-page').val('');
        $('#cscope-pages').empty();
    });

    $('#new-page-filter-modal-confirm').click(function(){
        var $item = $('#page-filter-template').children().clone();
        $item.find('.page-container').text($('#i-page-filter-container').val());
        $item.find('.page-name').text($('#i-page-filter-page').val());
        $("#gui-editor-area").append($item[0].outerHTML+'&nbsp;');
    });

    $('#i-page-filter-container').focusout(function(){
        $.post(window.vbcknd.base_url+'ajax/admin/groups/get_pages','container='+$(this).val(),LoadCurrentScopePages);
    });

    function LoadCurrentScopePages(data){
        var cscope_pages = $('#cscope-pages');
        cscope_pages.empty();
        if(!data.startsWith('failed - '))
        {
            var pages = data.split(',');
            $.each(pages,function(){
                cscope_pages.append('<option value="'+this+'">');
            });
        }else{
            console.log(data + ' - loading page autocomplete datalist')
        }
    }

    $('#save-edit').click(function(){
        if(is_new_unsaved){
            ClearAllValidationErrors();
            $('#new-group-modal').modal();
        }else{
            DoSave();
        }
    });

    $('#new-group-modal-confirm').click(function(){
        var name = $('#i-group-name');
        var description = $('#i-group-description');
        ClearAllValidationErrors();
        if((SystemSyntaxCheck(name) + IsEmptyCheck(description))>0){
            return;
        }
        $('#new-group-modal').modal('hide');
        $('#group-name').text(name.val());
        $('#group-description').text(description.val());
        DoSave();
    });

    function DoSave(){
        var json={};
        json.allowed_interfaces=[];
        $('.select-permission-item:checked').each(function(){
            json.allowed_interfaces.push($(this).val());
        });
        json.use_content_filter = document.getElementById('enable-content-filter').checked;
        if(document.getElementById('filter-blacklist').checked){
            json.content_filter_mode='blacklist';
        }else {
            json.content_filter_mode='whitelist';
        }
        if($('#cfilter-edit-gui').prop('checked')){
            json.content_filter_directives = GUI_to_CSV().split(",");
        }else{
            json.content_filter_directives = $("#cfilter-expression").val().replace(/\r?\n|\r/g,"").split(",");
        }
        var data ={};
        data.name = $('#group-name').text();
        data.descritpion = encodeURIComponent($('group-description').text());
        data.code = encodeURIComponent(JSON.stringify(json, null, '\t'));
        $('.alert').addClass('hidden');
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/groups/save',data, SaveEditDone);
    }

    function SaveEditDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            if(is_new_unsaved){
                var name= $('#group-name').text();
                history.replaceState( {} , '', window.vbcknd.base_url + 'admin/groups/edit/'+name );
                is_new_unsaved=false;
            }
            $('#success-alert').removeClass('hidden')
        }else{
            $('#error-msg').html("Si è verificato un errore durante il salvataggio del gruppo. I dati inseriti potrebbero essere non validi" +
                " (errore: "+data.replace(/(<([^>]+)>)/ig,"")+")");
            $('#error-alert').removeClass('hidden');
        }
    }

    $('.close').click(function(){
        $(this).closest('.alert-dismissible').addClass('hidden');
    });

    //TODO: Integrate the following functions in window.vbcknd (Modal Validation API)
    function ClearAllValidationErrors(){
        $('.has-error').removeClass('has-error');
    }

    function SystemSyntaxCheck(object){
        if(!object.val().match(/^[a-z0-9-]+$/) || object.val()===''){
            object.closest('.form-group').addClass('has-error');
            return 1;
        }else{
            return 0;
        }
    }

    function IsEmptyCheck(object){
        if(object.val()===''){
            object.closest('.form-group').addClass('has-error');
            return 1;
        }else{
            return 0;
        }
    }
});