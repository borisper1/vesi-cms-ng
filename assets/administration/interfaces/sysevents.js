$(document).ready(function() {
    $('#mark-read').click(function(){
        $.get(window.vbcknd.base_url + 'ajax/admin/sysevents/mark_all_as_read',function(){ window.location.reload(true);});
    });

    $('#delete-all').click(function(){
        $.get(window.vbcknd.base_url + 'ajax/admin/sysevents/delete_all',function(){ window.location.reload(true);});
    });
});