/**
 * Created by gmabo on 24/01/2016.
 */
$(document).ready(function () {
    var IsMobile = false;
    if ($(window).width() < 992) {
        IsMobile = true;
        $("#main-content").css("display", "none");
    }
    var preload = window.location.hash;

    if (preload != null && preload != "") {
        if (preload.charAt(0) === '#')
            preload = preload.slice(1);
        LoadCircolare(preload)
    }

    $(".circolari-link").click(function () {
        LoadCircolare($(this).data('id'));

    });

    function LoadCircolare(id) {
        $("#main-content").html("<div class='alert alert-info' role='alert'><i class='fa fa-refresh fa-spin'></i> Caricamento in corso</div>");
        if (IsMobile == false) {
            $(".circolari-link").removeClass("circolari-active");
            $(".circolari-link[data-id='" + id + "']").addClass("circolari-active");
        } else {
            var toolbar = "<button type='button' id='circolari-back' class='btn btn-default'><b><i class='fa fa-arrow-left'></i></b></button> ";
            $(".page-header").children("h1").prepend(toolbar);
            $("#main-list").css("display", "none");
            $("#main-content").css("display", "block");
        }
        $.post(window.vbcknd.base_url + 'plugins/circolari_engine/load_text', "id=" + id, AJAXLoadElement)
    }

    $('body').on("click", "#circolari-back", function () {
        $("#main-list").css("display", "block");
        $("#main-content").css("display", "none");
        $(this).remove();
    });

    function AJAXLoadElement(data) {
        $("#main-content").html(data);
    }

});
