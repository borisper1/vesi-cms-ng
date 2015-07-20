$(document).ready(function(e) {
    // Enables direct link to tabs (see issue #28)
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show');
    }
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        if(history.pushState) {
            history.pushState(null, null, e.target.hash);
        } else {
            window.location.hash = e.target.hash;
        }
    });

    //Generic popover and hover menu initialization js
    $('.popover-standard').popover();
    if(jQuery.fn.dropdownHover){
        $('.dropdown-hover').dropdownHover();
    }
});