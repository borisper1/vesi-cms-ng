$(document).ready(function () {
    var CurrentItem, CurrentState;

    $('.view-plugin-components').click(function () {
        CurrentItem = $(this).closest('tr');
        $.post(window.vbcknd.base_url + 'ajax/admin/plugins/load_registered_components', 'name=' + CurrentItem.find('.f-name').text(), LoadViewComponents);
        $('#view-components-modal').modal().find('.modal-body').empty();
    });

    function LoadViewComponents(data) {
        $('#view-components-modal').find('.modal-body').html(data);
    }

    $('#show-install-plugin').click(function(){
        ChangePluginInstallState('welcome');
        $('#install-plugin-modal').modal();
    });

    $('#install-plugin-modal-next').click(function(){
        if(CurrentState==='welcome'){
            ChangePluginInstallState('choosefile');
        } else if (CurrentState === 'rtinstall') {
            StartInstall();
            ChangePluginInstallState('installing');
        }
    });

    $('#install-plugin-modal-cancel').click(function () {
        if (CurrentState === 'success') {
            window.location.reload();
        }
    });

    $('#install-plugin-upload-form').submit(function(event){
        event.stopPropagation();
        event.preventDefault();
        var file_input = $('#plugin-file-input');
        if(file_input.val() == ""){
            alert('Scegliere un file per l\'installazione');
            return;
        }
        var ext = file_input.val().split('.').pop().toLowerCase();
        if (ext !== 'zip'){
            alert('Il file selezionato non è un file zip valido per l\'installazione');
            return;
        }
        ChangePluginInstallState('uploading');
        $('#install-plugin-upload-bar').css('width', '0%').text('0%');
        var form_data = new FormData($('#install-plugin-upload-form')[0]);
        $.ajax({
            type: 'POST',
            url: window.vbcknd.base_url + 'ajax/admin/plugins/unpack_zip_plugin',
            dataType: 'json',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',PluginZIPUploadProgressHandler, false);
                }
                return myXhr;
            },
            contentType: false,
            processData: false,
            data: form_data,
            success: PluginZIPUploadDone,
            error: PluginZIPInstallFailed
        });
    });

    function ChangePluginInstallState(state){
        $('.install-plugin-screens').addClass('hidden');
        CurrentState=state;
        $('#install-plugin-'+CurrentState).removeClass('hidden');
        var no_next_array = ['choosefile', 'syserror', 'success'];
        if(no_next_array.indexOf(state)!==-1){
            $('#install-plugin-modal-next').addClass('hidden');
        }else{
            $('#install-plugin-modal-next').removeClass('hidden');
        }
        var no_actions_array = ['uploading', 'preparing', 'installing'];
        if (no_actions_array.indexOf(state) !== -1) {
            $('#plugin-install-modal-footer').addClass('hidden');
        }else{
            $('#plugin-install-modal-footer').removeClass('hidden');
        }
        var close_array = ['syserror', 'success'];
        if (close_array.indexOf(state) !== -1) {
            $('#install-plugin-modal-cancel').html('<i class="fa fa-remove"></i> Chiudi');
        } else {
            $('#install-plugin-modal-cancel').html('<i class="fa fa-remove"></i> Annulla');
        }
    }

    function PluginZIPUploadProgressHandler(event){
        if(event.lengthComputable){
            if(event.loaded === event.total){
                ChangePluginInstallState('preparing');
            }else{
                var percent = (event.loaded *100 / event.total);
                $('#install-plugin-upload-bar').css('width', percent.toFixed(2)+'%').text(Math.round(percent)+'%');
            }
        }else{
            ChangePluginInstallState('preparing');
        }
    }

    function PluginZIPUploadDone(data){
        $('.rtinstall-name').text(data.name);
        $('#rtinstall-title').text(data.title);
        $('.rtinstall-version').text(data.version);
        $('#rtinstall-author').text(data.author);
        $('#rtinstall-description').text(data.description);
        $('#rtinstall-md5').text(data.md5);
        $('#rtinstall-sha1').text(data.sha1);
        if (data.update) {
            $('#rtinstall-update').removeClass('hidden');
            $('#rtinstall-oldversion').text(data.installed_version);
        } else {
            $('#rtinstall-update').addClass('hidden');
        }
        CurrentItem = data.folder_id;
        ChangePluginInstallState('rtinstall');
    }

    function PluginZIPInstallFailed(jqXHR){
        var html = '<p>Il server ha inviato la risposta <code>'+jqXHR.status+' '+jqXHR.statusText+'</code>. I dati inviati dal server sono:</p>'+'<div class="well">'+jqXHR.responseText+'</div>';
        $('#install-error-box').collapse('hide').html(html);
        ChangePluginInstallState('syserror');
    }

    function StartInstall() {
        $.ajax({
            type: 'POST',
            url: window.vbcknd.base_url + 'ajax/admin/plugins/install_uploaded_plugin',
            data: {folder_id: CurrentItem},
            success: PluginZIPInstallSuccess,
            error: PluginZIPInstallFailed
        });
    }

    function PluginZIPInstallSuccess(data) {
        if (data === 'success') {
            ChangePluginInstallState('success');
        } else {
            var html = '<p>Il server ha inviato la risposta <code>200 OK</code>. I dati inviati dal server sono (expected [string]"success"):</p>' + '<div class="well">' + data + '</div>';
            $('#install-error-box').collapse('hide').html(html);
            ChangePluginInstallState('syserror');
        }
    }

    $('.disable-plugin').click(function () {
        var name = $(this).closest('tr').find('.f-name').text();
        $.post(window.vbcknd.base_url + 'ajax/admin/plugins/set_plugin_state', {
            name: name,
            state: 'disable'
        }, function () {
            window.location.reload(true);
        });
    });

    $('.enable-plugin').click(function () {
        var name = $(this).closest('tr').find('.f-name').text();
        $.post(window.vbcknd.base_url + 'ajax/admin/plugins/set_plugin_state', {
            name: name,
            state: 'enable'
        }, function () {
            window.location.reload(true);
        });
    });

    $('.repair-plugin').click(function () {
        $('#repair-name').text($(this).closest('tr').find('.f-name').text());
        $('.repair-plugin-screens').addClass('hidden');
        $('#repair-plugin-welcome').removeClass('hidden');
        $('#repair-plugin-modal-next').removeClass('hidden');
        $('#repair-plugin-modal').modal();
    });

    $('#repair-plugin-modal-next').click(function () {
        $('#repair-plugin-modal-footer').addClass('hidden');
        $('.repair-plugin-screens').addClass('hidden');
        $('#repair-plugin-executing').removeClass('hidden');
        $.ajax({
            type: 'POST',
            url: window.vbcknd.base_url + 'ajax/admin/plugins/repair_installed_plugin',
            data: {name: $('#repair-name').text()},
            success: PluginRepairSuccess,
            error: PluginRepairFailed
        });
    });

    function PluginRepairFailed(jqXHR) {
        var html = '<p>Il server ha inviato la risposta <code>' + jqXHR.status + ' ' + jqXHR.statusText + '</code>. I dati inviati dal server sono:</p>' + '<div class="well">' + jqXHR.responseText + '</div>';
        $('#repair-error-box').collapse('hide').html(html);
        $('#repair-plugin-modal-next').addClass('hidden');
        $('#repair-plugin-modal-footer').removeClass('hidden');
        $('.repair-plugin-screens').addClass('hidden');
        $('#repair-plugin-syserror').removeClass('hidden');
    }

    function PluginRepairSuccess(data) {
        if (data === 'success') {
            ChangePluginInstallState('success');
            $('#repair-plugin-modal-next').addClass('hidden');
            $('#repair-plugin-modal-footer').removeClass('hidden');
            $('.repair-plugin-screens').addClass('hidden');
            $('#repair-plugin-success').removeClass('hidden')
        } else {
            var html = '<p>Il server ha inviato la risposta <code>200 OK</code>. I dati inviati dal server sono (expected [string]"success"):</p>' + '<div class="well">' + data + '</div>';
            $('#repair-error-box').collapse('hide').html(html);
            $('#repair-plugin-modal-next').addClass('hidden');
            $('#repair-plugin-modal-footer').removeClass('hidden');
            $('.repair-plugin-screens').addClass('hidden');
            $('#repair-plugin-syserror').removeClass('hidden')
        }
    }

    $('#i-remove-data').bootstrapSwitch();

    $('.remove-plugin').click(function () {
        $('#remove-name').text($(this).closest('tr').find('.f-name').text());
        $('#i-remove-data').prop('checked', false);
        $('.remove-plugin-screens').addClass('hidden');
        $('#remove-plugin-welcome').removeClass('hidden');
        $('#remove-plugin-modal-next').removeClass('hidden');
        $('#remove-plugin-modal').modal();
    });

    $('#remove-plugin-modal-next').click(function () {
        $('#remove-plugin-modal-footer').addClass('hidden');
        $('.remove-plugin-screens').addClass('hidden');
        $('#remove-plugin-executing').removeClass('hidden');
        $.ajax({
            type: 'POST',
            url: window.vbcknd.base_url + 'ajax/admin/plugins/remove_plugin',
            data: {name: $('#remove-name').text(), remove_data: $('#i-remove-data').prop('checked') },
            success: PluginRemoveSuccess,
            error: PluginRemoveFailed
        });
    });
    function PluginRemoveFailed(jqXHR) {
        var html = '<p>Il server ha inviato la risposta <code>' + jqXHR.status + ' ' + jqXHR.statusText + '</code>. I dati inviati dal server sono:</p>' + '<div class="well">' + jqXHR.responseText + '</div>';
        $('#remove-error-box').collapse('hide').html(html);
        $('#remove-plugin-modal-next').addClass('hidden');
        $('#remove-plugin-modal-footer').removeClass('hidden');
        $('.remove-plugin-screens').addClass('hidden');
        $('#remove-plugin-syserror').removeClass('hidden');
    }

    function PluginRemoveSuccess(data) {
        if (data === 'success') {
            ChangePluginInstallState('success');
            $('#remove-plugin-modal-next').addClass('hidden');
            $('#remove-plugin-modal-footer').removeClass('hidden');
            $('.remove-plugin-screens').addClass('hidden');
            $('#remove-plugin-success').removeClass('hidden')
        } else {
            var html = '<p>Il server ha inviato la risposta <code>200 OK</code>. I dati inviati dal server sono (expected [string]"success"):</p>' + '<div class="well">' + data + '</div>';
            $('#remove-error-box').collapse('hide').html(html);
            $('#remove-plugin-modal-next').addClass('hidden');
            $('#remove-plugin-modal-footer').removeClass('hidden');
            $('.remove-plugin-screens').addClass('hidden');
            $('#remove-plugin-syserror').removeClass('hidden')
        }
    }

});