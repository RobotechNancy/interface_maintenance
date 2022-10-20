$(window).ready(function()
{
    $(".delete").click(function() {
        $(".my-alert").fadeOut(250);
    });

    setTimeout(function(){ $(".my-alert").fadeOut(250); }, 3500);
});
