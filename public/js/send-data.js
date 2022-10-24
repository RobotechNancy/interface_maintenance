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
            if(request_id == 3)
            $(".pageloader").addClass("is-active");
            $(".btn_form").attr("disabled",true);
            $.ajax({
                type:'POST',
                url:request_url,
                data:{id:request_id},
                success:function(data) {
                    if(request_id == 4)
                        $(".logs").html("<span class='tag is-success mb-3'>Les logs ont été exportés vers le fichier :&nbsp;<a href='logs.txt' target='_blank'>" + data["file"] + "</a>.</span><br>" + $(".logs").html());
                    else
                        $("#logs_console").load(" #logs_console");
                    $("#btn_"+request_id).removeClass("is-loading");
                    if(request_id == 3)
                    $(".pageloader").removeClass("is-active");
                    $(".btn_form").attr("disabled",false);

                },
                error:function(data) {
                        $(".logs").html("<span class='tag is-danger'>Error " + data.status + " : " + data.responseJSON['message'] + "</span><br><span class='tag is-warning mb-3'>file " + data.responseJSON['file'] + ", line " + data.responseJSON['line'] + "</span><br>" + $(".logs").html());

                    $("#btn_"+request_id).removeClass("is-loading");
                    console.log(data);
                    if(request_id == 3)
                    $(".pageloader").removeClass("is-active");
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
