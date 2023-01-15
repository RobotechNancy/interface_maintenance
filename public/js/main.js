$(document).ready(function () {

    refreshTooltips();
    handleKeyBoardEvent()

    $(".btn_sidebar").click(function () {
        $("#sidebar").toggleClass("d-none");
        $("#sidebar").toggleClass("d-md-block");

        if ($("#sidebar").hasClass("d-md-block"))
            $(".btn_sidebar").html("<i class='fa-solid fa-xmark'></i>");
        else $(".btn_sidebar").html("<i class='fa-solid fa-bars'></i>");
    });

    $("#btn_reload_console").click(function () {
        $("#logs_console").load(" #logs_console");
        $("#maj_console_datetime").text(getCurrentDatetime());
    });

    $("#valeurSliderDistance").text($("#rangeDistance").val());
    $("#valeurSliderVitesse").text($("#rangeVitesse").val());

    $("#maj_console_datetime").text(getCurrentDatetime());

    $("#btn_autotests").click(function() {
        cycleAutotests();
    });

    //setInterval(checkLogTable, 1000);
    setInterval(checkRelaisStatus, 1000);
});
