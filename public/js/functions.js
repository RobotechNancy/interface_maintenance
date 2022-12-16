function sendData(request_url, request_id) {
    $(document).ready(function () {
        const alertPlaceholder = $(".title_console");

        const alert = (message, type) => {
            wrapper = [
                '<div class="alert alert-' +
                    type +
                    ' alert-dismissible" role="alert">',
                "   <div>" + message + "</div>",
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                "</div>",
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

            if ($("#btn_12").hasClass("btn-success") && request_id == 12)
                final_id = 13;
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
                    else if (request_id == 12) {
                        $("#btn_" + request_id).toggleClass("btn-danger");
                        $("#btn_" + request_id).toggleClass("btn-success");

                        if ($("#btn_" + request_id).hasClass("btn-success"))
                            $("#btn_" + request_id).html(
                                "<i class='fa-solid fa-power-off'></i>"
                            );
                        else
                            $("#btn_" + request_id).html(
                                "<i class='fa-solid fa-power-off'></i>"
                            );

                        $("#logs_console").load(" #logs_console");
                    } else $("#logs_console").load(" #logs_console");

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

function tabs_manager(tab_name) {
    $("#btn_" + tab_name).click(function () {
        if (!$("#btn_" + tab_name).hasClass("btn-light")) {
            $(".tabs").addClass("d-none");
            $("#" + tab_name).removeClass("d-none");
            $(".btn_tabs").removeClass("btn-light");
            $(".btn_tabs").addClass("btn-outline-light");
            $("#btn_" + tab_name).addClass("btn-light");
            $("#btn_" + tab_name).removeClass("btn-outline-light");
        }
    });
}

function afficherMasquerTrames(trame_name) {
    if ($("#list_" + trame_name).hasClass("d-none")) {
        $("#comment_" + trame_name).text("Masquer");
    } else {
        $("#comment_" + trame_name).text("Afficher");
    }
    $("#list_" + trame_name).toggleClass("d-none");
}

$(document).ready(function () {
    $(".btn_sidebar").click(function () {
        $("#sidebar").toggleClass("d-none");
        $("#sidebar").toggleClass("d-md-block");

        if ($("#sidebar").hasClass("d-md-block"))
            $(".btn_sidebar").html("<i class='fa-solid fa-xmark'></i>");
        else $(".btn_sidebar").html("<i class='fa-solid fa-bars'></i>");
    });

    $("#btn_reload_console").click(function () {
        $("#logs_console").load(" #logs_console");
    });

    $("#valeurSliderDistance").text($("#rangeDistance").val());
    $("#valeurSliderVitesse").text($("#rangeVitesse").val());
});

function changeValueRange(type) {
    if (type == 0) $("#valeurSliderDistance").text($("#rangeDistance").val());
    else $("#valeurSliderVitesse").text($("#rangeVitesse").val());
}
