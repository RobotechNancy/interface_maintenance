<div class="container tabs d-none" id="tab_services">
    <div class="vstack gap-5">
        <div class="hstack gap-2">
            <span class="fs-5 fw-bold">
                État des services web
            </span>
            @if (Auth::user()->role != 0)
            <div class="vr"></div>
                <button role="button" type="button" class="btn btn-warning btn_form"><span class="d-none d-md-inline">Tester tous les services</span> <i class="fa-solid fa-wrench"></i></button>
            @endif
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">

        <?php $id_service_web = config('app.id_service_web'); ?>

            @include("components.service-item", ["title" => "Export de logs",
                                                "text" => "Gère l'export des logs contenu dans la base de données sous la forme d'un fichier texte.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[LogController::class, 'export']",
                                                "btn_id" => $id_service_web["Export de logs"]])

            @include("components.service-item", ["title" => "Suppression des logs",
                                                "text" => "Gère la suppression des logs dans la base de données.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[LogController::class, 'clear']",
                                                "btn_id" => $id_service_web["Suppression des logs"]])

            @include("components.service-item", ["title" => "Création et traitement des logs",
                                                "text" => "Gère la création, le traitement et l'insertion des logs dans la base de données.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[LogController::class, 'create']",
                                                "btn_id" => $id_service_web["Création de logs"]])

            @include("components.service-item", ["title" => "Statut du relais de l'arrêt d'urgence",
                                                "text" => "Récupère le statut courant du relais de l'arrêt d'urgence.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[RelaisController::class, 'relaisStatus']",
                                                "btn_id" => $id_service_web["Relais arrêt d'urgence"]])

            @include("components.service-item", ["title" => "Nombre de logs dans la base de données",
                                                "text" => "Récupère le nombre actuel de logs présents dans la base de données.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[LogController::class, 'getLogtableSize']",
                                                "btn_id" => $id_service_web["Nombre de logs"]])

            @include("components.service-item", ["title" => "Création d'un compte utilisateur",
                                                "text" => "Gère l'ajout d'un nouveau compte utilisateur dans la base de données.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[RegisteredUserController::class, 'store']",
                                                "btn_id" => $id_service_web["Création utilisateur"]])

            @include("components.service-item", ["title" => "Connexion d'un compte utilisateur",
                                                "text" => "Gère la connexion d'un utilisateur au site.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[AuthenticatedSessionController::class, 'store']",
                                                "btn_id" => $id_service_web["Connexion utilisateur"]])

            @include("components.service-item", ["title" => "Modification d'un compte utilisateur",
                                                "text" => "Gère la modification d'un compte utilisateur et la mise à jour des informations associées dans la base de données.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[RegisteredUserController::class, 'update']",
                                                "btn_id" => $id_service_web["Modification compte utilisateur"]])

            @include("components.service-item", ["title" => "Suppression d'un compte utilisateur",
                                                "text" => "Gère la suppression définitive dans la base de données d'un compte utilisateur.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[RegisteredUserController::class, 'destroy']",
                                                "btn_id" => $id_service_web["Suppression compte utilisateur"]])

            @include("components.service-item", ["title" => "Affichage de tous les comptes utilisateurs",
                                                "text" => "Gère l'affichage de l'ensemble des comptes utilisateurs.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[RegisteredUserController::class, 'index']",
                                                "btn_id" => $id_service_web["Affichage utilisateurs"]])

            @include("components.service-item", ["title" => "Création du compte administrateur par défaut",
                                                "text" => "Gère la création et l'ajout dans la base de données du compte administrateur.",
                                                "btn_title" => "Tester le service",
                                                "route" => "[RegisteredUserController::class, 'defaultuser']",
                                                "btn_id" => $id_service_web["Compte administrateur par défaut"]])
    </div>
</div>
