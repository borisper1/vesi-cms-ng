$(document).ready(function() {

    $('#i-menu-class').selectpicker('val', $('#c-menu-class').text());

    window.vbcknd.config.get_data = function (){
        var data = {};
        data.style ={};
        data.style.menu_class = $('#i-menu-class').val();
        data.style.use_fluid_containers = $('#i-use-fluid-containers').prop('checked') ? 1 : 0;
        data.style.display_home_page_title = $('#i-display-home-page-title').prop('checked') ? 1 : 0;
        data.general ={};
        data.general.website_name = $('#i-website-name').val();
        data.general.logo_image_path = $('#i-logo-image-path').val();
        data.general.enable_math_support = $('#i-enable-math-support').prop('checked') ? 1 : 0;
        data.resources = {};
        data.resources.mathjax_usecdn = $('#mathjax-source-cdn').prop('checked') ? 1 : 0;
		data.resources.mathjax_cdnurl = $('#i-mathjax-cdnurl').val();
        return data;
    };

});
