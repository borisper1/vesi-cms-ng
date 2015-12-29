$(document).ready(function() {

    $('#i-menu-hover, #i-use-fluid-containers, #i-display-home-page-title').bootstrapSwitch();
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
        return data;
    }

});
