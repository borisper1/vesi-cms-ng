$(document).ready(function() {
    $('#i-menu-hover, #i-use-fluid-containers, #i-display-home-page-title').bootstrapSwitch();
    $('#i-jquery1-usecdn, #i-jquery2-usecdn, #i-bootstrap-usecdn, #i-fontawesome-usecdn, #i-enable-legacy-support').bootstrapSwitch();

    $('.cdn-reqssl-url').each(function(){
        var object = $(this).closest('.form-group');
        if($(this).val().match(/^https:\/\//)!=null){

            object.addClass('has-feedback has-success');
            object.find('.form-control-feedback>i.fa').addClass('fa-lock');
            object.find('.form-control-feedback').attr('title','Usa crittografia HTTPS').tooltip('fixTitle');
        }else{
            object.addClass('has-feedback has-warning');
            object.find('.form-control-feedback>i.fa').addClass('fa-warning');
            object.find('.form-control-feedback').attr('title','Non usa crittografia HTTPS').tooltip('fixTitle');
        }
    }).on('input',function(){
        var object = $(this).closest('.form-group');
        if($(this).val().match(/^https:\/\//)!=null){
            object.removeClass('has-warning');
            object.addClass('has-success');
            object.find('.form-control-feedback>i.fa').removeClass('fa-warning').addClass('fa-lock');
            object.find('.form-control-feedback').attr('title','Usa crittografia HTTPS').tooltip('fixTitle');
        }else{
            object.removeClass('has-success');
            object.addClass('has-warning');
            object.find('.form-control-feedback>i.fa').removeClass('fa-lock').addClass('fa-warning');
            object.find('.form-control-feedback').attr('title','Non usa crittografia HTTPS').tooltip('fixTitle');
        }
    })
});
