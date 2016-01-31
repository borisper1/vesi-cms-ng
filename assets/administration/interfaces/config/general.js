$(document).ready(function() {

    $('#i-menu-hover, #i-use-fluid-containers, #i-display-home-page-title, #i-limit-temp-folder, #i-enable-auto-maint').bootstrapSwitch();
    $('#i-menu-class').selectpicker('val', $('#c-menu-class').text());

    window.vbcknd.config.get_data = function (){
        var data = {};
        data.style ={};
        data.style.menu_class = $('#i-menu-class').val();
        data.style.menu_hover = $('#i-menu-hover').prop('checked') ? 1 : 0;
        data.style.use_fluid_containers = $('#i-use-fluid-containers').prop('checked') ? 1 : 0;
        data.style.display_home_page_title = $('#i-display-home-page-title').prop('checked') ? 1 : 0;
        data.general ={};
        data.general.website_name = $('#i-website-name').val();
        data.general.logo_image_path = $('#i-logo-image-path').val();
        data.general.enable_automatic_maintenance = $('#i-enable-auto-maint').prop('checked') ? 1 : 0;
        data.resources = {};
        data.resources.limit_temp_folder = $('#i-limit-temp-folder').prop('checked') ? 1 : 0;
        data.resources.max_temp_folder_size = $('#i-temp-folder-max-size').val();
        return data;
    };
    $('#i-temp-folder-max-size').change(function () {
        $('#temp-current-max-size').text($(this).val());
    })

});
