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

            alertPlaceholder.prepend(wrapper);
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

$(document).ready(function () {
    $(".btn_sidebar").click(function () {
        $("#sidebar").toggleClass("d-none");
        $("#sidebar").toggleClass("d-md-block");
    });

    $("#sidebar").css("top", $("#navbar").height() + 18);
    $("#sidebar").css("height", document.documentElement.scrollHeight - 18 - $("#navbar").height());
});
