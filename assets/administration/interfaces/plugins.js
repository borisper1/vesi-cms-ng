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
            url: window.vbcknd.base_url + 'ajax/admin/plugins/install_zip_plugin',
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
        var no_next_array = ['choosefile', 'syserror'];
        if(no_next_array.indexOf(state)!==-1){
            $('#install-plugin-modal-next').addClass('hidden');
        }else{
            $('#install-plugin-modal-next').removeClass('hidden');
        }
        var no_actions_array = ['uploading', 'preparing'];
        if(no_next_array.indexOf(state)!==-1){
            $('#plugin-install-modal-footer').addClass('hidden');
        }else{
            $('#plugin-install-modal-footer').removeClass('hidden');
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
        $('#rtinstall-version').text(data.version);
        $('#rtinstall-author').text(data.author);
        $('#rtinstall-description').text(data.description);
        $('#rtinstall-md5').text(data.md5);
        $('#rtinstall-sha1').text(data.sha1);
        CurrentItem = data.folder_id;
        ChangePluginInstallState('rtinstall');
    }

    function PluginZIPInstallFailed(jqXHR){
        var html = '<p>Il server ha inviato la risposta <code>'+jqXHR.status+' '+jqXHR.statusText+'</code>. I dati inviati dal server sono:</p>'+'<div class="well">'+jqXHR.responseText+'</div>';
        $('#install-error-box').collapse('hide').html(html);
        ChangePluginInstallState('syserror');
    }
});