$(document).ready(function() {

    window.vbcknd.config.get_data = function (){
        var data = {};
        data.resources = {};
        data.resources.jquery1_usecdn = $('#i-jquery1-usecdn').prop('checked') ? 1 : 0;
        data.resources.jquery2_usecdn = $('#i-jquery2-usecdn').prop('checked') ? 1 : 0;
        data.resources.bootstrap_js_usecdn = $('#i-bootstrap-usecdn').prop('checked') ? 1 : 0;
        data.resources.fontawesome_usecdn = $('#i-fontawesome-usecdn').prop('checked') ? 1 : 0;
        data.resources.jquery1_cdnurl = $('#i-jquery1-cdnurl').val();
        data.resources.jquery2_cdnurl = $('#i-jquery2-cdnurl').val();
        data.resources.bootstrap_js_cdnurl = $('#i-bootstrap-cdnurl').val();
        data.resources.fontawesome_cdnurl = $('#i-fontawesome-cdnurl').val();
        data.general ={};
        data.general.enable_legacy_support = $('#i-enable-legacy-support').prop('checked') ? 1 : 0;
        return data;
    };

});
