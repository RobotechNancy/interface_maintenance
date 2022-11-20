function sendData(request_url, request_id) {
    $(document).ready(function () {
        const alertPlaceholder = $("#logs_console");

        const alert = (message, type) => {
            const wrapper = document.createElement("div");
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
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

            $.ajax({
                type: "POST",
                url: request_url,
                data: { id: request_id },

                success: function (data) {
                    if (request_id == 0)
                        alert(
                            "Les logs ont correctement été exportés vers le fichier <a class='alert-link' href='logs.txt' target='_blank'>" +
                                data["file"] +
                                "</a>",
                            "success"
                        );
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

function showCompleteLog(log_id) {
    $(document).ready(function () {
        $("#log_icon_" + log_id).toggleClass("fa-caret-down");
        $("#log_icon_" + log_id).toggleClass("fa-caret-right");
        $("#log_reponse_" + log_id).fadeToggle();
    });
}

$(document).ready(function () {
    $(".btn_sidebar").click(function () {
        $("#sidebar").toggleClass("d-none");
        $("#sidebar").toggleClass("d-md-block");
    });
});
