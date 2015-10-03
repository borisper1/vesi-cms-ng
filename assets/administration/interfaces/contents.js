/**
 * Created by gmabo on 02/10/2015.
 */
$(document).ready(function() {
    //Code for the generic editor interface
    var is_new_unsaved = $('#is-new').text()==='true';

    $('#refresh').click(function(){
        if(is_new_unsaved) {
            window.location.assign(window.vbcknd.base_url + 'admin/contents/edit/new');
        } else {
            var id= $('#f-id').text();
            window.location.assign(window.vbcknd.base_url + 'admin/contents/edit/'+id);
        }
    });

    $('#close-edit').click(function(){
        //Ideally replace with return to referrer
        window.location.assign(window.vbcknd.base_url + 'admin/contents');
    });

});