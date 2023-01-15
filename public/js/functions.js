/**
 * Gère l'évènement d'appui sur un bouton d'action du dashboard, et traite la requête en correspondance.
 *
 * @param string request_url : la route à utiliser pour le traitement de la requête
 * @param int request_id : l'identifiant unique correspondant au bouton pressé
 *
 * @return false : la tâche est terminée
 * @return true : la tâche est en cours ou ne peut pas se terminer
 */
function sendData(request_url, request_id) {
    $(document).ready(function () {
        $("#form_" + request_id).submit(function (e) {
            e.preventDefault();
            if(!busy) processRequestBtn(request_id, request_url);
        });
    });
}

/**
 * Permet de définir les tooltip en tant qu'objets bootstrap pour qu'ils soient reconnus comme tels.
 */
function refreshTooltips() {
    $('[data-bs-toggle="tooltip"]').tooltip();
}

/**
 * Gère l'affichage dans la console de logs d'un message d'information pour l'utilisateur.
 *
 * @param string message : le texte (brut) à afficher
 * @param string type : le type de message à afficher [ex : warning, danger, success, info] (cf. documentation Bootstrap)
 */
function alertConsole(message, type) {
    wrapper = [
        '<div class="alert alert-' + type + ' alert-dismissible" role="alert">',
        "   <div>" + message + "</div>",
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        "</div>",
    ].join("");

    $(".title_console").prepend(wrapper);
}

var busy = false;

/**
 * Traitement de la requête associée aux boutons d'évènements et transmise depuis la fonction sendData.
 *
 * @param string request_url : la route à utiliser pour le traitement de la requête
 * @param int request_id : l'identifiant unique correspondant au bouton pressé
 *
 * @return false : la tâche est terminée
 * @return true : la tâche est en cours ou ne peut pas se terminer
 */
function processRequestBtn(request_id, request_url) {
    busy = true;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(".btn_form").attr("disabled", true);

    final_id =
        $("#btn_12").hasClass("btn-success") && request_id == 12 ?
        13 :
        request_id;

    $.ajax({
        type: "POST",
        url: request_url,
        data: {
            id: final_id,
            distance: $("#rangeDistance").val(),
            vitesse: $("#rangeVitesse").val(),
        },

        success: function (data) {
            if (request_id == 1 || request_id == 2 || request_id == 3) {
                try {
                    if (data["rep"][0]["trame_can_rec"] != "")
                        var trame_can_rec = JSON.parse(
                            data["rep"][0]["trame_can_rec"]
                        );
                    else var trame_can_rec = "";

                    if (typeof trame_can_rec.data === "undefined") {
                        var icon_autotest_access = "<i class='fa-solid fa-triangle-exclamation'></i>";
                        var color_autotest_access = "warning";

                        var icon_autotest_config = "<i class='fa-solid fa-xmark'></i>";
                        var color_autotest_config = "danger";

                        var icon_autotest_response = "<i class='fa-solid fa-xmark'></i>";
                        var color_autotest_response = "danger";

                    } else {
                        if (trame_can_rec.data == "0x1") {
                            var icon_autotest_access = "<i class='fa-solid fa-check'></i>";
                            var color_autotest_access = "success";

                            var icon_autotest_config = "<i class='fa-solid fa-check'></i>";
                            var color_autotest_config = "success";

                            var icon_autotest_response = "<i class='fa-solid fa-check'></i>";
                            var color_autotest_response = "success";
                        } else {
                            var icon_autotest_access = "<i class='fa-solid fa-check'></i>";
                            var color_autotest_access = "success";

                            var icon_autotest_config = "<i class='fa-solid fa-triangle-exclamation'></i>";
                            var color_autotest_config = "warning";

                            var icon_autotest_response = "<i class='fa-solid fa-xmark'></i>";
                            var color_autotest_response = "danger";
                        }
                    }
                } catch (error) {
                    alertConsole(error, "danger");
                    var icon_autotest_access = "<i class='fa-solid fa-xmark'></i>";
                    var color_autotest_access = "danger";

                    var icon_autotest_config = "<i class='fa-solid fa-xmark'></i>";
                    var color_autotest_config = "danger";

                    var icon_autotest_response = "<i class='fa-solid fa-xmark'></i>";
                    var color_autotest_response = "danger";
                }

                $("#access_autotest_carte_" + request_id).html(icon_autotest_access);
                $("#access_autotest_carte_" + request_id).removeClass("text-bg-success");
                $("#access_autotest_carte_" + request_id).removeClass("text-bg-danger");
                $("#access_autotest_carte_" + request_id).removeClass("text-bg-warning");
                $("#access_autotest_carte_" + request_id).addClass("text-bg-" + color_autotest_access);

                $("#response_autotest_carte_" + request_id).html(icon_autotest_response);
                $("#response_autotest_carte_" + request_id).removeClass("text-bg-success");
                $("#response_autotest_carte_" + request_id).removeClass("text-bg-danger");
                $("#response_autotest_carte_" + request_id).removeClass("text-bg-warning");
                $("#response_autotest_carte_" + request_id).addClass("text-bg-" + color_autotest_response);

                if (request_id == 3) {
                    $("#config_autotest_carte_" + request_id).html(icon_autotest_config);
                    $("#config_autotest_carte_" + request_id).removeClass("text-bg-success");
                    $("#config_autotest_carte_" + request_id).removeClass("text-bg-danger");
                    $("#config_autotest_carte_" + request_id).removeClass("text-bg-warning");
                    $("#config_autotest_carte_" + request_id).addClass("text-bg-" + color_autotest_config);
                }

                $("#date_autotest_carte_" + request_id).text(getCurrentDatetime);

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
            busy = false;
            $(".btn_form").attr("disabled", false);
        },

        error: function (error) {
            var msg_error =
                "Error " + error.status + " : " + error.responseJSON["message"];

            if (error.responseJSON["exception"] != undefined)
                msg_error +=
                "<br><br> Exception : " + error.responseJSON["exception"];

            if (error.responseJSON["file"] != undefined)
                msg_error += "<br><br> File : " + error.responseJSON["file"];

            if (error.responseJSON["line"] != undefined)
                msg_error += ", line " + error.responseJSON["line"];

            if (
                error.status == 500 &&
                error.responseJSON["exception"] == undefined
            )
                msg_error +=
                "<br><br> Vérifier l'emplacement et l'intégrité de l'exécutable C++.";

            alertConsole(msg_error, "danger");

            $(".btn_form").attr("disabled", false);
            busy = false;
        },
    });

    return busy;
}

/**
 * Lancement du cycle de test de l'ensemble des services web.
 */
function cycleTestServices() {
    processTestServices(1);
    processTestServices(2);
    processTestServices(3);
    processTestServices(4);
    processTestServices(5);
}

/**
 * Traitement de la requête de test du service précisé par son identifiant.
 *
 * @param int id_service : l'identifiant unique de référence du service web
 */
function processTestServices(id_service) {
    var route = "";

    switch (id_service) {
        case 1:
            route = "/exportlogs";
            break;

        case 2:
            route = "/clearlogs";
            break;

        case 3:
            route = "/log";
            break;

        case 4:
            route = "/relais";
            break;

        case 5:
            route = "/get_logtable_size";
            break;

        default:
            route = "";
            break;
    }

    if (route != "") {

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "POST",
            url: route + "/true",

            success: function (data) {

                if (data == id_service) {
                    $("#dispo_test_service_" + id_service).text("OK");
                    $("#dispo_test_service_" + id_service).removeClass("text-bg-secondary");
                    $("#dispo_test_service_" + id_service).addClass("text-bg-success");

                    $("#result_test_service_" + id_service).text("OK");
                    $("#result_test_service_" + id_service).removeClass("text-bg-secondary");
                    $("#result_test_service_" + id_service).addClass("text-bg-success");
                } else {
                    $("#dispo_test_service_" + id_service).text("OK");
                    $("#dispo_test_service_" + id_service).removeClass("text-bg-secondary");
                    $("#dispo_test_service_" + id_service).addClass("text-bg-success");

                    $("#result_test_service_" + id_service).text("ERREUR");
                    $("#result_test_service_" + id_service).removeClass("text-bg-secondary");
                    $("#result_test_service_" + id_service).addClass("text-bg-warning");
                }

                $("#date_test_service_" + id_service).text(getCurrentDatetime());
            },

            error: function (error) {

                $("#dispo_test_service_" + id_service).text("ERREUR");
                $("#result_test_service_" + id_service).text("ERREUR");
                $("#date_test_service_" + id_service).text(getCurrentDatetime());

                alertConsole(
                    "Error " +
                    error.status +
                    " : " +
                    error.responseJSON["message"] +
                    "<br><br> Exception : " +
                    error.responseJSON["exception"] +
                    "<br><br>File : " +
                    error.responseJSON["file"] +
                    ", line " +
                    error.responseJSON["line"],
                    "danger"
                );
            },
        });
    }
}

/**
 * Permet de gérer un cycle d'autotests complet sur l'ensemble des cartes implémentées.
 */
function cycleAutotests() {
    var route_log = "/log";

    processRequestBtn(2, route_log);
    processRequestBtn(1, route_log);
}

/**
 * Gère l'ajout dans le presse papier de l'utilisateur la trame choisie.
 *
 * @param string data : la trame brute à insérer dans le presse papier
 * @param int id : l'identifiant unique associé à la trame
 * @param int type : le type de trame associé (0 : trame can envoyée, 1 : trame can recue, 2 : trame php envoyée)
 */
function addToClipboard(data, id, type) {
    let type_trame = "",
        trame = "",
        obj = JSON.parse(JSON.stringify(data));

    if (type == 0) {
        type_trame = "CAN envoyée";
        trame =
            obj.addr +
            "," +
            obj.emetteur +
            "," +
            obj.code_fct +
            "," +
            obj.id_msg +
            "," +
            obj.is_rep +
            "," +
            obj.id_rep +
            "," +
            obj.data;
    } else if (type == 1) {
        type_trame = "CAN reçue";
        trame =
            obj.addr +
            "," +
            obj.emetteur +
            "," +
            obj.code_fct +
            "," +
            obj.is_rep +
            "," +
            obj.id_rep +
            "," +
            obj.data;
    } else if (type == 2) {
        type_trame = "PHP envoyée";
        trame =
            obj.arg != undefined ?
            obj.commande + "," + obj.arg :
            obj.commande +
            "," +
            obj.distance +
            "," +
            obj.vitesse +
            "," +
            obj.direction;
    }

    navigator.clipboard
        .writeText(trame)
        .then(() => {
            alertConsole(
                "Le contenu de la <b>trame " +
                type_trame +
                " n°" +
                id +
                "</b> a été copié avec succès dans le presse-papier.<br/><i>Trame : " +
                trame +
                "</i>",
                "success"
            );
        })
        .catch((err) => {
            alertConsole(
                "Impossible d'ajouter le contenu de la <b>trame " +
                type_trame +
                " n°" +
                id +
                "</b> au presse-papier.<br/>Détail de l'erreur : " +
                err +
                "<br/><i>Trame : " +
                trame +
                "</i>",
                "danger"
            );
        });
}

/**
 * Gère l'affichage dynamique dans la sidebar des différentes pages constituant le dashboard.
 *
 * @param int tab_name : l'identifiant unique associé à la page du dashboard concernée (cf. ressources/views/components/sidebar-navigation-item)
 */
function tabsManager(tab_name) {
    $("#btn_" + tab_name).click(function () {
        if (!$("#btn_" + tab_name).hasClass("active")) {
            $(".tabs").addClass("d-none");
            $("#" + tab_name).removeClass("d-none");
            $(".btn_tabs").removeClass("active");
            $("#btn_" + tab_name).addClass("active");
        }
    });
}

/**
 * Gère l'affichage dynmaique des informations détaillées contenues dans la trame spécifique du log concerné.
 *
 * @param string trame_name : l'identifiant unique correspondant à la trame dont on souhaite afficher/masquer le contenu détaillé
 */
function afficherMasquerTrames(trame_name) {
    if ($("#list_" + trame_name).hasClass("d-none")) {
        $("#comment_" + trame_name).text("Masquer");
    } else {
        $("#comment_" + trame_name).text("Afficher");
    }
    $("#list_" + trame_name).toggleClass("d-none");
}

/**
 * Permet de vérifier l'état du relais d'arrêt d'urgence pour afficher son état en temps réel.
 */
function checkRelaisStatus() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "POST",
        url: "/relais",

        success: function (data) {
            if (data == 1 && $("#btn_12").hasClass("btn-danger")) {
                $("#btn_12").removeClass("btn-danger");
                $("#btn_12").addClass("btn-success");
            } else if (data != 1 && $("#btn_12").hasClass("btn-success")) {
                $("#btn_12").removeClass("btn-success");
                $("#btn_12").addClass("btn-danger");
            }
        },

        error: function (error) {
            $("#btn_12").addClass("btn-danger");
            $("#btn_12").removeClass("btn-success");

            alertConsole(
                "Error " +
                error.status +
                " : " +
                error.responseJSON["message"] +
                "<br><br> Exception : " +
                error.responseJSON["exception"] +
                "<br><br>File : " +
                error.responseJSON["file"] +
                ", line " +
                error.responseJSON["line"],
                "danger"
            );
        },
    });
}

/**
 * Retour la date et l'heure courante sous la forme "jj/MM/AAAA à hh:mm:ss".
 */
function getCurrentDatetime() {
    var now = new Date();

    var jour = String(now.getDate()).padStart(2, '0');
    var mois = String(now.getMonth() + 1).padStart(2, '0');

    var heures = now.getHours() < 10 ? "0" + now.getHours() : now.getHours();
    var minutes =
        now.getMinutes() < 10 ? "0" + now.getMinutes() : now.getMinutes();
    var secondes =
        now.getSeconds() < 10 ? "0" + now.getSeconds() : now.getSeconds();

    var formatted =
        jour +
        "/" +
        mois +
        "/" +
        now.getFullYear() +
        " à " +
        heures +
        ":" +
        minutes +
        ":" +
        secondes;

    return formatted;
}

/**
 * Vérifie si un changement est survenu dans la table des logs de la base de donnés
 * (en se basant sur le nombre de logs affichés dans la console du dashboard)
 * et mets à jour la console de logs si besoin.
 */
function checkLogTable() {
    refreshTooltips();

    if ($(location).attr("pathname") == "/dashboard") {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "POST",
            url: "/get_logtable_size",

            success: function (nb_logs) {
                if (nb_logs != $(".accordion-header").length) {
                    $("#logs_console").load(" #logs_console");
                    $("#maj_console_datetime").text(getCurrentDatetime());
                }
            },

            error: function (error) {
                alertConsole(
                    "Error " +
                    error.status +
                    " : " +
                    error.responseJSON["message"] +
                    "<br><br> Exception : " +
                    error.responseJSON["exception"] +
                    "<br><br>File : " +
                    error.responseJSON["file"] +
                    ", line " +
                    error.responseJSON["line"],
                    "danger"
                );
            },
        });
    }
}

/**
 * Gère l'affichage dynmaique de la valeur sélectionnée par l'utilisateur dans les sliders de la sidebar.
 *
 * @param id id_slider : l'identifiant du slider dont on doit mettre à jour la valeur (0 : slider de distance, 1 : slider de vitesse)
 */
function changeValueRange(id_slider) {
    if (id_slider == 0) $("#valeurSliderDistance").text($("#rangeDistance").val());
    else $("#valeurSliderVitesse").text($("#rangeVitesse").val());
}

/**
 * Gère les évènements clavier et lance les commandes de déplacement de la base roulante en conséquence.
 */
function handleKeyBoardEvent() {

    $("#btn_info_keyboard_shortcuts").click(function (){
        alertConsole(
            "Liste des raccourcis clavier pour commander la base roulante :"+
            "<ul>"+
            "<li><code>flèche droite</code> : Tourne à droite</li>"+
            "<li><code>flèche gauche</code> : Tourne à gauche</li>"+
            "<li><code>flèche haut</code> : Avance</li>"+
            "<li><code>flèche bas</code> : Recule</li>"+
            "<li><code>Ctrl + flèche haut</code> : Avance à gauche</li>"+
            "<li><code>Ctrl + flèche bas</code> : Recule à gauche</li>"+
            "<li><code>Ctrl + Alt + flèche haut</code> : Avance à droite</li>"+
            "<li><code>Ctrl + Alt + flèche bas</code> : Recule à droite</li>"+
            "</ul>",
            "info"
        );
    });

    $(document).keydown(function (event)
    {
        if(!$("#switch_keyboard_shortcuts").prop('checked'))
            return 0;

        if(busy)
            return 0;

        var touche = event.which;
        var touche_alt = event.altKey;
        var touche_ctrl = event.ctrlKey;
        var id_fleche_haut = 38;
        var id_fleche_bas = 40;
        var id_fleche_gauche = 37;
        var id_fleche_droite = 39;

        request_url = "/log";

        switch (touche)
        {
            case id_fleche_gauche:
                request_id = 11;
                break;

            case id_fleche_haut:
                request_id = 7;
                break;

            case id_fleche_droite:
                request_id = 4;
                break;

            case id_fleche_bas:
                request_id = 8;
                break;

            default:
                request_id = -1;
                break;
        }

        if (touche == id_fleche_haut && touche_ctrl && touche_alt)
            request_id = 9;

        else if (touche == id_fleche_haut && touche_ctrl)
            request_id = 5;

        else if (touche == id_fleche_bas && touche_ctrl && touche_alt)
            request_id = 10;

        else if (touche == id_fleche_bas && touche_ctrl)
            request_id = 6;

        if (request_id != -1)
            processRequestBtn(request_id, request_url);
    });
}
