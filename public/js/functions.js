function sendData(request_url, request_id) {
    $(document).ready(function () {
        $("#form_" + request_id).submit(function (e) {
            e.preventDefault();
            processRequestBtn(request_id, request_url);
        });
    });
}

function refreshTooltips(){
    $('[data-bs-toggle="tooltip"]').tooltip();
}

function alertConsole(message, type){
    wrapper = [
        '<div class="alert alert-' +
            type +
            ' alert-dismissible" role="alert">',
        "   <div>" + message + "</div>",
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        "</div>",
    ].join("");

    $(".title_console").prepend(wrapper);
}

function processRequestBtn(request_id, request_url){
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(".btn_form").attr("disabled", true);

    final_id =
        $("#btn_12").hasClass("btn-success") && request_id == 12
            ? 13
            : request_id;

    $.ajax({
        type: "POST",
        url: request_url,
        data: {
            id: final_id,
            distance: $("#rangeDistance").val(),
            vitesse: $("#rangeVitesse").val(),
        },

        success: function (data) {

            if(request_id == 1 || request_id == 2){

                try {
                    var trame_can_rec = JSON.parse(data["rep"][0]["trame_can_rec"]);

                    if(typeof trame_can_rec.data === 'undefined'){
                        var icon_autotest = "<i class='fa-solid fa-xmark'></i>";
                        var color_autotest = "danger";
                        var msg_tooltip = "Connexion non établie avec la carte - Vérifiez l'alimentation de la carte et le code implémenté";
                    }else{
                        var icon_autotest = (trame_can_rec.data == "0x1") ? "<i class='fa-solid fa-check'></i>" : "<i class='fa-solid fa-triangle-exclamation'></i>";
                        var color_autotest = (trame_can_rec.data == "0x1") ? "success" : "warning";
                        var msg_tooltip = (trame_can_rec.data == "0x1") ? "Connexion établie avec succès - La carte est alimentée correctement - La réponse de la carte est cohérente" : "Connexion établie avec succes - La carte est alimentée correctement - La réponse de la carte est incohérente";
                    }

                } catch (error) {
                    alertConsole(error, "danger");
                    var icon_autotest = "<i class='fa-solid fa-xmark'></i>";
                    var color_autotest = "danger";
                    var msg_tooltip = "Connexion non établie avec la carte - Vérifiez l'état du BUS CAN, l'alimentation de la carte et le code implémenté";
                }

                if(request_id == 1){

                    $("#result_test_odo").html(icon_autotest);
                    $("#result_test_odo").removeClass("text-bg-success");
                    $("#result_test_odo").removeClass("text-bg-danger");
                    $("#result_test_odo").addClass("text-bg-"+color_autotest);
                    $('#result_test_odo').attr('data-bs-title', msg_tooltip);
                    new bootstrap.Tooltip("#result_test_odo")
                    $("#container_test_odo_datetime").removeClass("d-none");
                    $("#maj_test_odo_datetime").text(getCurrentDatetime);


                } else {

                    $("#result_test_br").html(icon_autotest);
                    $("#result_test_br").removeClass("text-bg-success");
                    $("#result_test_br").removeClass("text-bg-danger");
                    $("#result_test_br").addClass("text-bg-"+color_autotest);
                    $('#result_test_br').attr('data-bs-title', msg_tooltip);
                    new bootstrap.Tooltip("#result_test_br")
                    $("#container_test_br_datetime").removeClass("d-none");
                    $("#maj_test_br_datetime").text(getCurrentDatetime);
                }
            }

            if (request_id == 0)
                alertConsole(
                    "Les logs ont correctement été exportés vers le fichier <a class='alert-link' href='logs.txt' target='_blank'>" +
                        data["file"] +
                        "</a>",
                    "success"
                );
            else if (request_id == 12) {
                $("#btn_" + request_id).toggleClass("btn-danger");
                $("#btn_" + request_id).toggleClass("btn-success");
                $("#logs_console").load(" #logs_console");
                $("#maj_console_datetime").text(getCurrentDatetime());

            } else {
                $("#logs_console").load(" #logs_console");
                $("#maj_console_datetime").text(getCurrentDatetime());
            }

            refreshTooltips();
            $(".btn_form").attr("disabled", false);
        },

        error: function (data) {

            alertConsole("Error " +
                    data.status +
                    " : " +
                    data.responseJSON["message"] +
                    "<br><br> Exception : " +
                    data.responseJSON["exception"] +
                    "<br><br>File : " +
                    data.responseJSON["file"] +
                    ", line " +
                    data.responseJSON["line"],
                "danger");

            $(".btn_form").attr("disabled", false);
        },
    });
}

function cycleAutotests(){
    var route_log = "/log";
    processRequestBtn(1, route_log);
    processRequestBtn(2, route_log);
}

function addToClipboard(data, id, type) {
    let type_trame = "", trame = "", obj = JSON.parse(JSON.stringify(data));

    if(type == 0) {

        type_trame = "CAN envoyée";
        trame = obj.addr + "," + obj.emetteur + "," + obj.code_fct + "," + obj.id_msg + "," + obj.is_rep + "," + obj.id_rep + "," + obj.data;

    } else if(type == 1) {

        type_trame = "CAN reçue";
        trame = obj.addr + "," + obj.emetteur + "," + obj.code_fct + "," + obj.is_rep + "," + obj.id_rep + "," + obj.data;

    } else if(type == 2) {

        type_trame = "PHP envoyée";
        trame = (obj.arg != undefined) ? obj.commande + "," + obj.arg : obj.commande + "," + obj.distance + "," + obj.vitesse + "," + obj.direction;
    }

    navigator.clipboard
        .writeText(trame)
        .then(() => {
            alertConsole(
                "Le contenu de la <b>trame " + type_trame + " n°"+ id + "</b> a été copié avec succès dans le presse-papier.<br/><i>Trame : " + trame + "</i>",
                "success"
            );
        })
        .catch((err) => {
            alertConsole(
                "Impossible d'ajouter le contenu de la <b>trame " + type_trame + " n°"+ id + "</b> au presse-papier.<br/>Détail de l'erreur : " + err + "<br/><i>Trame : " + trame + "</i>",
                "danger"
            );
        });
}

function tabs_manager(tab_name) {
    $("#btn_" + tab_name).click(function () {
        if (!$("#btn_" + tab_name).hasClass("active")) {
            $(".tabs").addClass("d-none");
            $("#" + tab_name).removeClass("d-none");
            $(".btn_tabs").removeClass("active");
            $("#btn_" + tab_name).addClass("active");
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

function checkRelaisStatus() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        }
    });

    $.ajax({
        type: "POST",
        url: "/relais",

        success: function (data) {
            console.log(data)
        },

        error: function(error) {
            alertConsole("Error " +
                    error.status +
                    " : " +
                    error.responseJSON["message"] +
                    "<br><br> Exception : " +
                    error.responseJSON["exception"] +
                    "<br><br>File : " +
                    error.responseJSON["file"] +
                    ", line " +
                    error.responseJSON["line"],
                "danger");
        }
    });
}

function getCurrentDatetime() {
    var now = new Date(Date.now());

    var jour = (now.getDate() < 10) ? "0" + now.getDate() : now.getDate();
    var mois = (now.getMonth() < 10) ? "0" + now.getMonth() : now.getMonth();

    var heures = (now.getHours() < 10) ? "0" + now.getHours() : now.getHours();
    var minutes = (now.getMinutes() < 10) ? "0" + now.getMinutes() : now.getMinutes();
    var secondes = (now.getSeconds() < 10) ? "0" + now.getSeconds() : now.getSeconds();

    var formatted = jour + "/" + mois + "/" + now.getFullYear() + " à " + heures + ":" + minutes + ":" + secondes;

    return formatted;
}

function checkLogTable() {

    refreshTooltips();

    if($(location).attr('pathname') == "/dashboard"){

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            }
        });

        $.ajax({
            type: "POST",
            url: "/get_logtable_size",

            success: function (nb_logs) {
                if(nb_logs != $('.accordion-header').length){
                    $("#logs_console").load(" #logs_console");
                    $("#maj_console_datetime").text(getCurrentDatetime());
                }
            },

            error: function(error) {

                alertConsole("Error " +
                        error.status +
                        " : " +
                        error.responseJSON["message"] +
                        "<br><br> Exception : " +
                        error.responseJSON["exception"] +
                        "<br><br>File : " +
                        error.responseJSON["file"] +
                        ", line " +
                        error.responseJSON["line"],
                    "danger");
            }
        });
    }

}

$(document).ready(function () {

    refreshTooltips();

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

    setInterval(checkLogTable, 1000);

    //setInterval(checkRelaisStatus, 1000);
});

function changeValueRange(type) {
    if (type == 0) $("#valeurSliderDistance").text($("#rangeDistance").val());
    else $("#valeurSliderVitesse").text($("#rangeVitesse").val());
}
