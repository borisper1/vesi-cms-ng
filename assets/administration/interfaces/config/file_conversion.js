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

    window.vbcknd.config.get_data = function (){
        var data = {};
        data.file_conversion ={};
        data.file_conversion.remote_server_token = $('#i-remote-server-token').val();
        data.file_conversion.remote_server_url = $('#i-remote-server-url').val();
        data.file_conversion.execute_on_remote = $('#i-execute-on-remote').prop('checked') ? 1 : 0;
        data.file_conversion.enable_file_conversion = $('#i-enable-file-conversion').prop('checked') ? 1 : 0;
        return data;
    }

});