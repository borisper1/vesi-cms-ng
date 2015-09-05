$(document).ready(function() {
    var CurrentItem, CurrentMode;

    var is_new_unsaved = $('#is-new').text()==='true';
    if(is_new_unsaved){
        $('#edit-attributes-modal').modal();
    }

    $(".sortable-main").sortable().disableSelection();
    $(".sortable-views").sortable().disableSelection();
    $(".sortable-items").sortable().disableSelection();

    $('#refresh').click(function(){
        if(is_new_unsaved) {
            window.location.href = window.vbcknd.base_url + 'admin/pages/edit/new';
        } else {
            var id= $('#f-id').text();
            window.location.href = window.vbcknd.base_url + 'admin/pages/edit/'+id;
        }
    });

    $('#close-edit').click(function(){
        window.location.href = window.vbcknd.base_url + 'admin/pages';
    });

    $('#edit-attributes').click(function(){
        $('#i-page-title').val($('#f-title').text());
        $('#i-page-layout').selectpicker('val', $('#f-page-layout').text());
        $('#i-page-name').val($('#f-page-name').text());
        $('#i-page-container').val($('#f-container').text());
        $('#name-change-warning, #layout-change-warning, #sidebar-deletion-warning').addClass('hidden');
        ClearAllValidationErrors();
        $('#edit-attributes-modal').modal();
    });

    $('#edit-attributes-confirm').click(function(){
        var has_error = false;
        var name =$('#i-page-name');
        var container = $('#i-page-container');
        var title = $('#i-page-title');
        ClearAllValidationErrors();
        if(!(SystemSyntaxCheck(name) && SystemSyntaxCheck(container) && IsEmptyCheck(title) )){
            return;
        }
        $('#edit-attributes-modal').modal('hide');
        $('#f-title').text(title.val());
        $('#f-page-name').text(name.val());
        $('#f-container').text(container.val());
        var old_layout_obj =$('#f-page-layout');
        var new_layout = $('#i-page-layout').val();
        var old_layout = old_layout_obj.text();
        if(new_layout!==old_layout){
            var translation_array = {sidebar_left : 'sinistra', sidebar_right :'destra'};
            //Check if page reload is needed
            if(new_layout.indexOf("sidebar")===old_layout.indexOf("sidebar")){
                old_layout_obj.text(new_layout);
                $('#sidebar-side').text(translation_array[new_layout.replace('-','_')]);
            }else{
                old_layout_obj.text(new_layout);
                //TODO: invoke save command (with auto-refresh on success)
            }
        }
    });

    $('#generate-page-name').click(function(){
        var title = $('#i-page-title').val();
        $('#i-page-name').val(window.vbcknd.auto_name_format(title));
    });

    $('#i-page-name').on('input',function(){
        if(!is_new_unsaved){
            $('#name-change-warning').toggleClass('hidden', $(this).val()===$('#f-page-name').text());
        }
    });

    $('#i-page-layout').change(function(){
        var current_layout = $('#f-page-layout').text();
        $('#layout-change-warning').toggleClass('hidden', current_layout.indexOf("sidebar")===$(this).val().indexOf("sidebar"));
        $('#sidebar-deletion-warning').toggleClass('hidden', !(current_layout.indexOf("sidebar")===0 && $(this).val().indexOf("sidebar")===-1));
    });

    function ClearAllValidationErrors(){
        $('.has-error').removeClass('has-error');
    }

    function SystemSyntaxCheck(object){
        if(!object.val().match(/^[a-z0-9-]+$/) || object.val()===''){
            object.closest('.form-group').addClass('has-error');
            return false;
        }else{
            return true;
        }
    }

    function IsEmptyCheck(object){
        if(object.val()===''){
            object.closest('.form-group').addClass('has-error');
            return false;
        }else{
            return true;
        }
    }

    //BEGIN INTERACTIVE EDITOR CODE (centered on #events-cage) ---------------------------------------------------------
    $('#events-cage').on('click','.new-tabs-block',function(){
        CurrentItem=$(this);
        $.post(window.vbcknd.base_url+'ajax/admin/pages/get_block_template','type=tabs-block',AddNewBlock);
    }).on('click','.new-collapse-block',function(){
        CurrentItem=$(this);
        $.post(window.vbcknd.base_url+'ajax/admin/pages/get_block_template','type=collapse-block',AddNewBlock);
    }).on('click','.new-view',function(){
        CurrentItem=$(this);
        CurrentMode='new';
        $('#view-modal-title').html('<i class="fa fa-plus"></i> Nuova scheda/pannello');
        $('#view-modal-confirm').html('<i class="fa fa-bolt"></i> Crea scheda/pannello');
        $('#view-modal').modal();
    }).on('click','.remove-content',function(){
        CurrentItem=$(this).closest('.content-symbol');
        var id = CurrentItem.find('.f-id').text();
        $("#unlink-modal-wait").removeClass('hidden');
        $("#unlink-modal-show, #unlink-modal-toolbar").addClass('hidden');
        $('#unlink-modal').modal();
        $.post(window.vbcknd.base_url+'ajax/admin/contents/check_orphans','id_string='+id, DrawUnlinkSingleContent);
    }).on('click','.remove-view, .remove-block',function(){
        CurrentItem=$(this).closest('.structure-view, .structure-block');
        //Quickly compute all linked contents
        var array=[];
        CurrentItem.find('.content-symbol').find('.f-id').each(function(){
            array.push($(this).text())
        });
        //Request orphans for these elements
        $("#structure-deletion-modal").modal();
        $("#structure-deletion-modal-wait").removeClass('hidden');
        $("#structure-deletion-modal-show, #structure-deletion-modal-toolbar, #structure-deletion-modal-orphans").addClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/contents/check_orphans','id_string='+array.join(), DrawStructureRemoval);
    }).on('click','.edit-view',function(){
        CurrentItem=$(this).closest('.structure-view');
        CurrentMode='edit';
        $('#i-view-id').val(CurrentItem.find(".f-view-id:first").text());
        $('#i-view-title').val(CurrentItem.find(".f-view-title:first").text());
        $('#view-modal-title').html('<i class="fa fa-pencil"></i> Modifica scheda/pannello');
        $('#view-modal-confirm').html('<i class="fa fa-bolt"></i> Modifica scheda/pannello');
        $('#view-modal').modal();
    });


    function DrawStructureRemoval(data){
        $("#structure-deletion-modal-wait").addClass('hidden');
        $("#structure-deletion-modal-show, #structure-deletion-modal-toolbar").removeClass('hidden');
        if(data!=='false'){
            $("#structure-deletion-modal-orphans").removeClass('hidden');
            $('#structure-deletion-modal-orphan-content').empty();
            var array = data.split(',');
            $.each(array, function(i, id){
                var object = $(".f-id:contains('"+id+"')").closest(".content-symbol");
                var type = object.find(".f-type").text();
                var preview = object.find(".f-preview").text();
                var html = '<tr><td><input type="checkbox" class="orphans-selector" value="'+id+'"> '+id+'</td><td><span class="label label-info">'+type+'</span></td><td>'+preview+'</td></tr>';
                $('#structure-deletion-modal-orphan-content').append(html);
            })
        }
    }

    $("#structure-deletion-modal-confirm").click(function(){
        CurrentItem.remove();
        var object = $(".orphans-selector:checked");
        if(object.length>0){
            var id_array=[];
            object.each(function(){
                id_array.push($(this).val());
            });
            $('.content-alert').addClass('hidden');
            $.post(window.vbcknd.base_url+'ajax/admin/contents/delete_multiple','id_string='+id_array.join(','), DeleteContents);
            $('#content-deletion-spinner').removeClass('hidden');
        }
    });

    function DrawUnlinkSingleContent(data){
        if(data==='false'){
            $('#unlink-modal').modal('hidden');
            CurrentItem.remove();
        }else{
            $("#unlink-modal-wait").addClass('hidden');
            $("#unlink-modal-show, #unlink-modal-toolbar").removeClass('hidden');
        }
    }

    $('#unlink-modal-confirm').click(function(){
        var id = CurrentItem.find('.f-id').text();
        CurrentItem.remove();
        if($('#unlink-modal-delete-select').prop('checked')){
            $('.content-alert').addClass('hidden');
            $.post(window.vbcknd.base_url+'ajax/admin/contents/delete_multiple','id_string='+id, DeleteContents);
            $('#content-deletion-spinner').removeClass('hidden');
        }
    });

    function DeleteContents(data){
        $('.content-alert').addClass('hidden');
        if(data==='success'){
            $('#content-deletion-success').removeClass('hidden');
        }else{
            $('#content-deletion-error').removeClass('hidden');
        }
    }

    function AddNewBlock(data){
        if(data!=='failed'){
            CurrentItem.closest('.editor-parent-element').find('ul.sortable').first().append(data);
        }
    }

    $('#view-modal-confirm').click(function(){
        var id = $('#i-view-id');
        var title = $('#i-view-title');
        ClearAllValidationErrors();
        if(!(SystemSyntaxCheck(id) && IsEmptyCheck(title) )){
            return;
        }
        $('#view-modal').modal('hide');
        if(CurrentMode==='new'){
            $.post(window.vbcknd.base_url+'ajax/admin/pages/get_view_template', 'title='+encodeURIComponent(title.val())+'&id='+id.val(), AddNewView);
        }else{
            CurrentItem.find(".f-view-id:first").text(id.val());
            CurrentItem.find(".f-view-title:first").text(title.val());
        }
    });

    $('#generate-view-id').click(function(){
        var title = $('#i-view-title').val();
        $('#i-view-id').val(window.vbcknd.auto_name_format(title));
    });

    function AddNewView(data){
        if(data!=='failed') {
            CurrentItem.closest('.structure-block').find('ul.sortable').first().append(data);
        }
    }

});