function sendData(request_url, request_id) {
    $(document).ready(function () {
        const alertPlaceholder = $(".title_console");

        const alert = (message, type) => {
            wrapper = [
                '<div class="alert alert-'+type+' alert-dismissible" role="alert">',
                '   <div>'+message+'</div>',
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>',
            ].join("");

            alertPlaceholder.append(wrapper);
        };


        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $("#form_" + request_id).submit(function (e) {
            e.preventDefault();
            $(".btn_form").attr("disabled", true);

            if($("#btn_12").hasClass("btn-success")) final_id = 13;
            else final_id = request_id;

            $.ajax({
                type: "POST",
                url: request_url,
                data: { id: final_id },

                success: function (data) {
                    if (request_id == 0)
                        alert(
                            "Les logs ont correctement été exportés vers le fichier <a class='alert-link' href='logs.txt' target='_blank'>" +
                                data["file"] +
                                "</a>",
                            "success"
                        );

                    else if(request_id == 12){
                        $("#btn_"+request_id).toggleClass("btn-danger");
                        $("#btn_"+request_id).toggleClass("btn-success");

                        if($("#btn_"+request_id).hasClass("btn-success"))
                            $("#btn_"+request_id).html("ON <i class='fa-solid fa-toggle-on'></i>");
                        else
                            $("#btn_"+request_id).html("OFF <i class='fa-solid fa-toggle-off'></i>");

                        $("#logs_console").load(" #logs_console");
                    }

                    else $("#logs_console").load(" #logs_console");

                    $(".btn_form").attr("disabled", false);
                },

                error: function (data) {
                    alert(
                        "Error " +
                            data.status +
                            " : " +
                            data.responseJSON["message"] +
                            "<br>file " +
                            data.responseJSON["file"] +
                            ", line " +
                            data.responseJSON["line"],
                        "danger"
                    );
                    $(".btn_form").attr("disabled", false);
                },
            });
        });
    });
}

function tabs_manager(tab_name){
    $("#btn_"+tab_name).click(function(){
        if(!($("#btn_"+tab_name).hasClass("active"))){
            $(".tabs").addClass("d-none");
            $("#"+tab_name).removeClass("d-none");
            $(".btn_tabs").removeClass("active");
            $(".btn_tabs").addClass("text-white");
            $("#btn_"+tab_name).addClass("active");
            $("#btn_"+tab_name).removeClass("text-white");
        }
    });
}

$(document).ready(function () {
    $(".btn_sidebar").click(function () {
        $("#sidebar").toggleClass("d-none");
        $("#sidebar").toggleClass("d-md-block");
    });

    $("#sidebar").css("top", $("#navbar").height() + 18);
    $("#sidebar").css("height", document.documentElement.scrollHeight - 18 - $("#navbar").height());

    if($("#sidebar").hasClass("d-none")){
        $("#container_dashboard").css("left", $("#sidebar").width() + 35);
        $("#container_dashboard").css("width", $("#navbar").width() - $("#sidebar").width() - 35);
    }

    $("#btn_reload_console").click(function(){
        $("#logs_console").load(" #logs_console");
    });

    tabs_manager("tab_connectivite");
    tabs_manager("tab_console_logs");
});
