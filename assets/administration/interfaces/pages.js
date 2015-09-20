$(document).ready(function() {
    var CurrentItem, CurrentMode;

    var is_new_unsaved = $('#is-new').text()==='true';
    if(is_new_unsaved){
        $('#edit-attributes-modal').modal();
    }

    //FUNCTIONS FOR THE LIST VIEW MODE ---------------------------------------------------------------------------------

    $('#ajax-cage').on('click','.panel-actuator', function(){
        var object = $(this).closest('.container-block').find('table:first');
        if(object.hasClass('hidden')){
            $(this).find('.fa-chevron-right').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        }else{
            $(this).find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        }
        object.toggleClass('hidden');
    }).on('click', '.remove-page', function(){
        CurrentItem = $(this).closest('tr');
        $('#page-deletion-modal-wait').removeClass('hidden');
        $('#page-deletion-modal-show, #page-deletion-modal-orphans, #page-delete-modal-toolbar').addClass('hidden');
        $('#page-delete-modal').modal();
        $.post(window.vbcknd.base_url+'ajax/admin/pages/check_orphans','id='+CurrentItem.data('id'), DrawPageRemoval);
    }).on('click', '.edit-tags', function(){
        CurrentItem = $(this).closest('tr');
        var tags =[];
        CurrentItem.find('.page-tag').each(function(){
            tags.push($(this).text());
        });
        $('#i-tags-value').val(tags.join(','));
        $('#tags-edit-modal').modal();
    }).on('click', '.set-home', function(){
        CurrentItem = $(this).closest('tr');
        $.post(window.vbcknd.base_url+'ajax/admin/pages/set_home','id='+CurrentItem.data('id'), UpdatePageHome);
    });

    function UpdatePageHome(data){
        if(data=='success'){
            alert('Pagina inziale impostata correttamente. La pagina verrà aggiornata quando si preme su OK');
            window.location.reload(true);
        }else{
            alert('Impossibile impostare la pagina inziale - errore sconosciuto');
        }
    }

    $('#tags-edit-modal-confirm').click(function(){
        $.post(window.vbcknd.base_url+'ajax/admin/pages/set_tags','id='+CurrentItem.data('id')+'&tags='+$('#i-tags-value').val(), UpdatePageTags);
    });

    function UpdatePageTags(data){
        if(data==="success"){
            var tags = $('#i-tags-value').val().split(',');
            var object = CurrentItem.find('.tag-container');
            object.empty();
            $.each(tags, function(){
                object.append('<span class="label label-info page-tag">'+this+'</span> ');
            });
        }else{
            alert("Impossibile modificare i tag della pagina. Il server ha negato la richiesta");
        }
    }

    function DrawPageRemoval(data){
        $("#page-deletion-modal-wait").addClass('hidden');
        $("#page-deletion-modal-show, #page-delete-modal-toolbar").removeClass('hidden');
        if(data!=='false'){
            $("#page-deletion-modal-orphans").removeClass('hidden');
            $('#page-deletion-modal-orphan-content').empty().html(data);
        }
    }

    $('#page-delete-modal-confirm').click(function(){
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
        $.post(window.vbcknd.base_url+'ajax/admin/pages/delete','id='+CurrentItem.data('id'), DeletePage);
    });

    function DeletePage(data){
        if(data=="success"){
            CurrentItem.remove();
        }else{
            $('#error-msg').html("Si è verificato un errore durante l'eliminazione della pagina. (Il token CSRF potrebbe essere scaduto" +
                " se la protezione CSRF è abilitata) - "+data.replace(/(<([^>]+)>)/ig,""));
            $('#deletion-error-alert').removeClass('hidden');
        }
    }

    $('#show-all').click(function(){
        var block = $('.container-block');
        block.find('table:first').removeClass('hidden');
        block.find('.fa-chevron-right').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    });

    $('#hide-all').click(function(){
        var block = $('.container-block');
        block.find('table:first').addClass('hidden');
        block.find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });

    $(".sortable").sortable().disableSelection();

    $('.close').click(function(){
        $(this).closest('.alert-dismissable').addClass('hidden');
    });

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

    //FUNCTIONS FOR GENERIC PAGE EDITING -------------------------------------------------------------------------------

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
        var name =$('#i-page-name');
        var container = $('#i-page-container');
        var title = $('#i-page-title');
        ClearAllValidationErrors();
        if((SystemSyntaxCheck(name) + SystemSyntaxCheck(container) + IsEmptyCheck(title))>0){
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

    //TODO: Integrate the following fnctions in window.vbcknd (Modal Validation API)
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

    //PAGE SAVING CODE -------------------------------------------------------------------------------------------------

    $('#save-page').click(function(){
        var id = $('#f-id').text();
        var name = $('#f-page-name').text();
        var container = $('#f-container').text();
        var title = $('#f-title').text();
        var json_object ={};
        json_object.type = 'page';
        json_object.layout = $('#f-page-layout').text();
        json_object.elements = RunTree($('#sortable-main-content > li > div'));
        if(json_object.layout.indexOf('sidebar')===0) {
            json_object.sidebar_elements = RunTree($('#sortable-sidebar > li > div'));
        }
        var json = JSON.stringify(json_object, null, '\t');
        $('.alert').addClass('hidden');
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/pages/save','id='+id+'&name='+name+'&container='+container+'&json='+encodeURIComponent(json)+'&title='+encodeURIComponent(title),SaveEditDone);
    });

    function SaveEditDone(data){
        $('.alert').addClass('hidden');
        if(data=="success"){
            is_new_unsaved=false;
            $('#success-alert').removeClass('hidden');
            $('#events-cage').find('.fa-clock-o').remove();
        }else{
            $('#error-msg').html("Si è verificato un errore durante il salvataggio della pagina. (Il token CSRF potrebbe essere scaduto" +
                " se la protezione CSRF è abilitata) - "+data.replace(/(<([^>]+)>)/ig,""));
            $('#error-alert').removeClass('hidden');
        }
    }

    function RunTree(object){
        var elements = [];
        object.each(function(){
            var instance = $(this);
            if(instance.hasClass('content-symbol')){
                var content = {};
                content.type = 'content';
                content.id = instance.find('.f-id').text();
                elements.push(content);
            }else if(instance.hasClass('structure-block')){
                var block = {};
                block.type = instance.data('type');
                if(instance.hasClass('structure-sview-block')){
                    block.class = instance.find('.f-view-class:first').text();
                }
                block.views = [];
                instance.find('.sortable-views:first > li > div, .structure-single-view:first').each(function(){
                    var view = {};
                    view.title = $(this).find('.f-view-title:first').text();
                    view.id = $(this).find('.f-view-id:first').text();
                    view.elements = RunTree($(this).find('.sortable-items:first > li > div'));
                    block.views.push(view);
                });
                elements.push(block);
            }
        });

        return elements;
    }

    //BEGIN INTERACTIVE EDITOR CODE (centered on #events-cage) ---------------------------------------------------------
    $('#events-cage').on('click','.new-tabs-block',function(){
        CurrentItem=$(this);
        $.post(window.vbcknd.base_url+'ajax/admin/pages/get_block_template','type=tabs-block',AddNewBlock);
    }).on('click','.new-collapse-block',function(){
        CurrentItem=$(this);
        $.post(window.vbcknd.base_url+'ajax/admin/pages/get_block_template','type=collapse-block',AddNewBlock);
    }).on('click','.new-generic-box',function(){
        CurrentItem=$(this);
        CurrentMode='new-generic-box';
        ClearAllValidationErrors();
        $('#i-view-id').val('');
        $('#i-view-title').val('');
        $('#view-modal-class-selector-ui').removeClass('hidden');
        $('#view-modal-title').html('<i class="fa fa-plus"></i> Nuovo pannello singolo');
        $('#view-modal-confirm').html('<i class="fa fa-bolt"></i> Crea pannello singolo');
        $('#view-modal').modal();
    }).on('click','.new-view',function(){
        CurrentItem=$(this);
        CurrentMode='new';
        ClearAllValidationErrors();
        $('#i-view-id').val('');
        $('#i-view-title').val('');
        $('#view-modal-class-selector-ui').addClass('hidden');
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
        if(CurrentItem.hasClass('structure-single-view')){
            CurrentMode='edit-generic-box';
            $('#view-modal-class-selector-ui').removeClass('hidden');
            $('#i-sview-class').val(CurrentItem.find(".f-view-class:first").text());
        }else{
            CurrentMode='edit';
            $('#view-modal-class-selector-ui').addClass('hidden');
        }
        ClearAllValidationErrors();
        $('#i-view-id').val(CurrentItem.find(".f-view-id:first").text());
        $('#i-view-title').val(CurrentItem.find(".f-view-title:first").text());
        $('#view-modal-title').html('<i class="fa fa-pencil"></i> Modifica scheda/pannello');
        $('#view-modal-confirm').html('<i class="fa fa-bolt"></i> Modifica scheda/pannello');
        $('#view-modal').modal();
    }).on('click','.link-standard-content',function(){
        CurrentItem=$(this).closest('.editor-parent-element');
        $('#link-content-modal').modal();
    }).on('click','.link-plugin',function(){
        alert("Il supporto ai plug-in non è ancora stato ultimato - Plug-ins are not currently supported")
    });

    $('#link-content-modal-confirm').click(function(){
        var id = $('#i-link-content-id').val();
        if(id!=''){
            $('.content-alert').addClass('hidden');
            $('#content-linking-spinner').removeClass('hidden');
            $.post(window.vbcknd.base_url+'ajax/admin/pages/get_content_symbol','id='+id, LinkExistingContent);
        }else{
            alert('Non è stato inserito un id valido');
        }
    });

    function LinkExistingContent(data){
        if(data!=''){
            $('.content-alert').addClass('hidden');
            CurrentItem.find('.sortable').first().append(data);
        }else{
            $('.content-alert').addClass('hidden');
            $('#content-linking-error').removeClass('hidden');
        }
    }

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
            $('#unlink-modal').modal('hide');
            CurrentItem.remove();
        }else{
            $("#unlink-modal-wait").addClass('hide');
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
        if((SystemSyntaxCheck(id) + IsEmptyCheck(title))>0){
            return;
        }
        $('#view-modal').modal('hide');
        if(CurrentMode==='new'){
            $.post(window.vbcknd.base_url+'ajax/admin/pages/get_view_template', 'title='+encodeURIComponent(title.val())+'&id='+id.val(), AddNewView);
        }else if(CurrentMode==='new-generic-box'){
            var sclass = $('#i-sview-class');
            $.post(window.vbcknd.base_url+'ajax/admin/pages/get_single_view_template','type=generic-box&title='+encodeURIComponent(title.val())+'&id='+id.val()+'&class='+sclass.val(),AddNewBlock);
        }else if(CurrentMode==='edit-generic-box'){
            CurrentItem.find(".f-view-class:first").text($('#i-sview-class').val());
            CurrentItem.find(".f-view-id:first").text(id.val());
            CurrentItem.find(".f-view-title:first").text(title.val());
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