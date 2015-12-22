/**
 * Created by gmabo on 10/12/2015.
 */
$(document).ready(function() {

    $('#i-execute-on-remote, #i-enable-file-conversion').bootstrapSwitch();

    $('#check-temp-folder-permissions').click(function()
    {
        $('#temp-folder-permissions-ok, #temp-folder-permissions-failed').addClass('hidden');
        $('#temp-folder-permissions-loading').removeClass('hidden');
        $.post(window.vbcknd.base_url+'ajax/admin/config/is_writable', 'path='+encodeURIComponent($('#i-temp-folder').val()), CheckPermissionsDone);
    });

    function CheckPermissionsDone(data){
        $('#temp-folder-permissions-ok, #temp-folder-permissions-failed, #temp-folder-permissions-loading').addClass('hidden');
        if(data==='yes'){
            $('#temp-folder-permissions-ok').removeClass('hidden');
        }else if (data==='no'){
            $('#temp-folder-permissions-failed').removeClass('hidden');
        }
    }

});