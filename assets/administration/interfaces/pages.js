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
        //TODO: Add name processing from migrate-ng
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
    });

    function AddNewBlock(data){
        if(data!=='failed'){
            CurrentItem.closest('.editor-parent-element').find('ul.sortable').first().append(data);
        }
    }

    $('#view-modal-confirm').click(function(){9
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

        }
    });

    function AddNewView(data){
        if(data!=='failed') {
            CurrentItem.closest('.structure-block').find('ul.sortable').first().append(data);
        }
    }

});