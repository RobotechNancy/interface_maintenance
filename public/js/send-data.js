function sendData(request_url, request_id){
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#form_"+request_id).submit(function(e){
            e.preventDefault();
            $("#btn_"+request_id).addClass("is-loading");
            $(".btn_form").attr("disabled",true);
            $.ajax({
                type:'POST',
                url:request_url,
                data:{id:request_id},
                success:function(data) {
                    $("#logs_console").load(" #logs_console");
                    console.log(data);
                    $("#btn_"+request_id).removeClass("is-loading");
                    $(".btn_form").attr("disabled",false);
                }
            });
        });
    });
}

function showCompleteLog(log_id){
    $(document).ready(function () {
            $("#log_icon_"+log_id).toggleClass("fa-caret-down");
            $("#log_icon_"+log_id).toggleClass("fa-caret-right");
            $("#log_reponse_"+log_id).fadeToggle();
    });
}
