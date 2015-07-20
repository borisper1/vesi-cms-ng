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
        $('#parent-delete-modal').modal();
    }).on('click','.new-child',function(){
        CurrentItem = $(this).parent();
        CurrentMode = 'new';
        $('#child-modal-label').text('Nuova voce di menu');
        $('#child-modal-confirm').text('Crea voce');
        $('#i-child-name').val('');
        $('#i-child-page').val('');
        $('#child-modal').modal();
    }).on('click','.edit-child',function(){
        CurrentItem = $(this).parent();
        CurrentMode = 'edit';
        $('#child-modal-label').text('Modifica voce di menu');
        $('#child-modal-confirm').text('Modifica voce');
        $('#i-child-name').val(CurrentItem.find('.f-title').text());
        $('#i-child-page').val(CurrentItem.find('.f-page').text());
        $('#child-modal').modal();
    }).on('click','.edit-parent',function(){
        CurrentItem = $(this).parent();
        if(CurrentItem.data('type')==='dropdown'){
            CurrentMode = 'edit';
            $('#dropdown-modal-label').text('Modifica menu a tendina (voce principale)');
            $('#dropdown-modal-confirm').text('Modifica menu');
            $('#i-parent-dropdown-name').val(CurrentItem.find('.f-title').text());
            $('#i-parent-dropdown-container').val(CurrentItem.find('.f-container').text());
            $('#dropdown-modal').modal();
        }else{
            CurrentMode = 'edit';
            $('#link-modal-label').text('Modifica link semplice (voce principale)');
            $('#link-modal-confirm').text('Modifica link');
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
        }else{
            CurrentItem = CurrentItem.closest('.panel-primary').find('.sortable-subv');
            //Generate item DOM tree.
            var $item = $('#child-template').children().clone();
            $item.find('.f-title').text($('#i-child-name').val());
            $item.find('.f-page').text($('#i-child-page').val());
            CurrentItem.append('<li class="ui-sortable-handle">'+$item[0].outerHTML+'</li>');
        }
    });

    $('#new-parent-dropdown').click(function(){
        CurrentMode = 'new';
        $('#dropdown-modal-label').text('Nuovo menu a tendina (voce principale)');
        $('#dropdown-modal-confirm').text('Crea menu');
        $('#i-parent-dropdown-name').val('');
        $('#i-parent-dropdown-container').val('');
        $('#dropdown-modal').modal();
    });

    $('#new-parent-link').click(function(){
        CurrentMode = 'new';
        $('#link-modal-label').text('Nuovo link semplice (voce principale)');
        $('#link-modal-confirm').text('Crea link');
        $('#i-parent-link-name').val('');
        $('#i-parent-link-container').val('');
        $('#i-parent-link-page').val('');
        $('#link-modal').modal();
    });

    $('#dropdown-modal-confirm').click(function(){
        if(CurrentMode==='edit'){
            CurrentItem.find('.f-title').text($('#i-parent-dropdown-name').val());
            CurrentItem.find('.f-container').text($('#i-parent-dropdown-container').val());
        }else{
            CurrentItem = $('#events-cage');
            var $item = $('#parent-dropdown-template').children().clone();
            $item.find('.f-title').text($('#i-parent-dropdown-name').val());
            $item.find('.f-container').text($('#i-parent-dropdown-container').val());
            CurrentItem.append('<li class="ui-sortable-handle">'+$item[0].outerHTML+'</li>');
            $(".sortable-subv").sortable().disableSelection();
        }
    });

    $('#link-modal-confirm').click(function(){
        if(CurrentMode==='edit'){
            CurrentItem.find('.f-title').text($('#i-parent-link-name').val());
            CurrentItem.find('.f-container').text($('#i-parent-link-container').val());
            CurrentItem.find('.f-page').text($('#i-parent-link-page').val());
        }else{
            CurrentItem = $('#events-cage');
            var $item = $('#parent-link-template').children().clone();
            $item.find('.f-title').text($('#i-parent-link-name').val());
            $item.find('.f-container').text($('#i-parent-link-container').val());
            $item.find('.f-page').text($('#i-parent-link-page').val());
            CurrentItem.append('<li class="ui-sortable-handle">'+$item[0].outerHTML+'</li>');
        }
    });
});