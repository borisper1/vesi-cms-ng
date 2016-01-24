$(document).ready(function () {
    var CurrentItem;

    $('.view-plugin-components').click(function () {
        CurrentItem = $(this).closest('tr');
        $.post(window.vbcknd.base_url + 'ajax/admin/plugins/load_registered_components', 'name=' + CurrentItem.find('.f-name').text(), LoadViewComponents);
        $('#view-components-modal').modal().find('.modal-body').empty();
    });

    function LoadViewComponents(data) {
        $('#view-components-modal').find('.modal-body').html(data);
    }
});