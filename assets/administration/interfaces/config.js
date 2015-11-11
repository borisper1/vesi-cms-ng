$(document).ready(function() {
    var full_url = window.location.pathname;
    var url_segment = full_url.substr(full_url.lastIndexOf('/') + 1);
    var get_data;

    switch (url_segment){
        case 'config':
            $('#i-menu-hover, #i-use-fluid-containers, #i-display-home-page-title').bootstrapSwitch();

            get_data = function (){
                var data = {};
                data.style ={};
                data.style.menu_class = $('#i-menu-class').val();
                data.style.menu_class = $('#i-menu-hover').prop('checked') ? '1' : '0';
                data.style.use_fluid_containers = $('#i-use-fluid-containers').prop('checked') ? '1' : '0';
                data.style.display_home_page_title = $('#i-display-home-page-title').prop('checked') ? '1' : '0';
                data.general ={};
                data.general.website_name = $('#i-website-name').val();
                return data;
            };

            break;
        case 'sources':
            $('#i-jquery1-usecdn, #i-jquery2-usecdn, #i-bootstrap-usecdn, #i-fontawesome-usecdn, #i-enable-legacy-support').bootstrapSwitch();

            get_data = function (){
                var data = {};
                data.resources = {};
                data.resources.jquery1_usecdn = $('#i-jquery1-usecdn').prop('checked') ? '1' : '0';
                data.resources.jquery2_usecdn = $('#i-jquery2-usecdn').prop('checked') ? '1' : '0';
                data.resources.bootstrap_js_usecdn = $('#i-bootstrap-usecdn').prop('checked') ? '1' : '0';
                data.resources.fontawesome_usecdn = $('#i-fontawesome-usecdn').prop('checked') ? '1' : '0';
                data.resources.jquery1_cdnurl = $('#i-jquery1-cdnurl').val();
                data.resources.jquery2_cdnurl = $('#i-jquery2-cdnurl').val();
                data.resources.bootstrap_js_cdnurl = $('#i-bootstrap-cdnurl').val();
                data.resources.fontawesome_cdnurl = $('#i-fontawesome-cdnurl').val();
                data.general ={};
                data.general.enable_legacy_support = $('#i-enable-legacy-support').prop('checked') ? '1' : '0';
                return data;
            };

            break;
    }

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
        $.post(window.vbcknd.base_url+'ajax/admin/config/save', 'code='+JSON.stringify(get_data()));
    });

    $('#refresh').click(function(){
        window.location.reload(true);
    })


});
