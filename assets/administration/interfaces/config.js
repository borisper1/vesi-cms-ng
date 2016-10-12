$(document).ready(function() {

    $('.checkbox-sw').bootstrapSwitch();

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
    });

    $('#save-config').click(function(){
        $('.alert-config').addClass('hidden');
        $('#spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/config/save', 'code='+encodeURIComponent(JSON.stringify(window.vbcknd.config.get_data())), ConfigSaveDone);
    });

    $('#refresh').click(function(){
        window.location.reload(true);
    });

    function ConfigSaveDone(data){
        $('.alert-config').addClass('hidden');
        if(data=="success"){
            $('#success-alert').removeClass('hidden')
        }else{
            $('#error-alert').removeClass('hidden');
        }
    }

    $('.close').click(function(){
        $(this).closest('.alert-dismissible').addClass('hidden');
    });


});
