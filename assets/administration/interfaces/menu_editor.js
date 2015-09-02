/**
 * Created by Boris on 15/07/2015.
 */
$(document).ready(function() {
    var CurrentItem, CurrentMode;

    $(".sortable-main").sortable().disableSelection();
    $(".sortable-subv").sortable().disableSelection();

    $('#events-cage').on('click','.remove-child',function(){
        $(this).closest('li').remove();
    }).on('click','.remove-parent',function(){
        CurrentItem = $(this);
        if(CurrentItem.data('type')==='dropdown'){
            $('#parent-delete-modal').modal();
        }else {
            CurrentItem.closest('li').remove();
        }
    }).on('click','.new-child',function(){
        CurrentItem = $(this).parent();
        var container = CurrentItem.find('.f-container').text();
        $.post(window.vbcknd.base_url+'ajax/admin/main_menu/get_pages','container='+container,LoadCurrentScopePages);
        CurrentMode = 'new';
        $('#child-modal-label').html('<i class="fa fa-plus"></i> Nuova voce di menu');
        $('#child-modal-confirm').html('<i class="fa fa-bolt"></i> Crea voce');
        $('#i-child-name').val('');
        $('#i-child-page').val('');
        $('#child-modal').modal();
    }).on('click','.edit-child',function(){
        CurrentItem = $(this).parent();
        var container = CurrentItem.closest('.panel-primary').find('.f-container').text();
        $.post(window.vbcknd.base_url+'ajax/admin/main_menu/get_pages','container='+container,LoadCurrentScopePages);
        CurrentMode = 'edit';
        $('#child-modal-label').html('<i class="fa fa-pencil"></i> Modifica voce di menu');
        $('#child-modal-confirm').html('<i class="fa fa-bolt"></i>  Modifica voce');
        $('#i-child-name').val(CurrentItem.find('.f-title').text());
        $('#i-child-page').val(CurrentItem.find('.f-page').text());
        $('#child-modal').modal();
    }).on('click','.edit-parent',function(){
        CurrentItem = $(this).parent();
        if(CurrentItem.data('type')==='dropdown'){
            CurrentMode = 'edit';
            $('#dropdown-modal-label').html('<i class="fa fa-pencil"></i> Modifica menu a tendina (voce principale)');
            $('#dropdown-modal-confirm').html('<i class="fa fa-bolt"></i>  Modifica menu');
            $('#i-parent-dropdown-name').val(CurrentItem.find('.f-title').text());
            $('#i-parent-dropdown-container').val(CurrentItem.find('.f-container').text());
            $('#dropdown-modal').modal();
        }else{
            CurrentMode = 'edit';
            $('#link-modal-label').html('<i class="fa fa-pencil"></i> Modifica link semplice (voce principale)');
            $('#link-modal-confirm').html('<i class="fa fa-bolt"></i>  Modifica link');
            $('#i-parent-link-name').val(CurrentItem.find('.f-title').text());
            $('#i-parent-link-container').val(CurrentItem.find('.f-container').text());
            $('#i-parent-link-page').val(CurrentItem.find('.f-page').text());
            $('#link-modal').modal();
        }
    });

    $('#pardel-modal-confirm').click(function(){
        CurrentItem.closest('li').remove();
    });

    $('#child-modal-confirm').click(function(){
        if(CurrentMode==='edit'){
            CurrentItem.find('.f-title').text($('#i-child-name').val());
            CurrentItem.find('.f-page').text($('#i-child-page').val());
            CurrentItem.find('.fa-clock-o').remove();
            CurrentItem.find('span.label-default').after(' <i class="fa fa-clock-o"></i>');
        }else{
            CurrentItem = CurrentItem.closest('.panel-primary').find('.sortable-subv');
            //Generate item DOM tree.
            var $item = $('#child-template').children().clone();
            $item.find('.f-title').text($('#i-child-name').val());
            $item.find('.f-page').text($('#i-child-page').val());
            $item.find('span.label-default').after(' <i class="fa fa-clock-o"></i>');
            CurrentItem.append('<li class="ui-sortable-handle">'+$item[0].outerHTML+'</li>');
        }
    });

    $('#new-parent-dropdown').click(function(){
        CurrentMode = 'new';
        $('#dropdown-modal-label').html('<i class="fa fa-plus"></i> Nuovo menu a tendina (voce principale)');
        $('#dropdown-modal-confirm').html('<i class="fa fa-bolt"></i> Crea menu');
        $('#i-parent-dropdown-name').val('');
        $('#i-parent-dropdown-container').val('');
        $('#dropdown-modal').modal();
    });

    $('#new-parent-link').click(function(){
        CurrentMode = 'new';
        $('#link-modal-label').html('<i class="fa fa-plus"></i> Nuovo link semplice (voce principale)');
        $('#link-modal-confirm').html('<i class="fa fa-bolt"></i> Crea link');
        $('#i-parent-link-name').val('');
        $('#i-parent-link-container').val('');
        $('#i-parent-link-page').val('');
        $('#link-modal').modal();
    });

    $('#dropdown-modal-confirm').click(function(){
        if(CurrentMode==='edit'){
            CurrentItem.find('.f-title').text($('#i-parent-dropdown-name').val());
            CurrentItem.find('.f-container').text($('#i-parent-dropdown-container').val());
            CurrentItem.find('.fa-clock-o').remove();
            CurrentItem.find('span.label-default').after(' <i class="fa fa-clock-o"></i>')
        }else{
            CurrentItem = $('#events-cage');
            var $item = $('#parent-dropdown-template').children().clone();
            $item.find('.f-title').text($('#i-parent-dropdown-name').val());
            $item.find('.f-container').text($('#i-parent-dropdown-container').val());
            $item.find('span.label-default').after(' <i class="fa fa-clock-o"></i>');
            CurrentItem.append('<li class="ui-sortable-handle">'+$item[0].outerHTML+'</li>');
            $(".sortable-subv").sortable().disableSelection();
        }
    });

    $('#link-modal-confirm').click(function(){
        if(CurrentMode==='edit'){
            CurrentItem.find('.f-title').text($('#i-parent-link-name').val());
            CurrentItem.find('.f-container').text($('#i-parent-link-container').val());
            CurrentItem.find('.f-page').text($('#i-parent-link-page').val());
            CurrentItem.find('.fa-clock-o').remove();
            CurrentItem.find('span.label-default').after(' <i class="fa fa-clock-o"></i>');
        }else{
            CurrentItem = $('#events-cage');
            var $item = $('#parent-link-template').children().clone();
            $item.find('.f-title').text($('#i-parent-link-name').val());
            $item.find('.f-container').text($('#i-parent-link-container').val());
            $item.find('.f-page').text($('#i-parent-link-page').val());
            $item.find('span.label-default').after(' <i class="fa fa-clock-o"></i>');
            CurrentItem.append('<li class="ui-sortable-handle">'+$item[0].outerHTML+'</li>');
        }
    });

    $('#i-parent-link-container').focusout(function(){
        $.post(window.vbcknd.base_url+'ajax/admin/main_menu/get_pages','container='+$(this).val(),LoadCurrentScopePages);
    });

    function LoadCurrentScopePages(data)
    {
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
});