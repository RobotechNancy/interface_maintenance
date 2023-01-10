<div class="container tabs d-none" id="tab_services">
    <div class="vstack gap-5">
        <div class="hstack gap-2">
            <span class="fs-5 fw-bold">
                État des services web
            </span>
            @if (Auth::user()->role != 0)
            <div class="vr"></div>
                <button role="button" type="button" onclick="cycleTestServices()" id="btn_test_services" class="btn btn-warning btn_form">Tester tous les services <i class="fa-solid fa-wrench"></i></button>
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
    </div>
</div>
