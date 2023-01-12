<div class="container tabs" id="tab_console_logs">
    <h5 class="mb-4">
        <div class="hstack gap-2 fw-bold">
            <span class="pe-2">Console de logs</span>

            @if (Auth::user()->role == 2)
                <x-button id="20" icon="fa-solid fa-eraser" url="{{ route('clearlogs') }}" color="btn-danger"
                    addons="btn-sm" />
            @endif

            @if (Auth::user()->role != 0)
            <x-button id="0" icon="fa-solid fa-file-export" url="{{ route('exportlogs') }}" addons="btn-sm" />
            @endif

            <a href="/logs.txt" target="_blank">
                <button class="btn btn-secondary btn-sm">
                    <span class="icon">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </button>
            </a>

            <button id="btn_reload_console" class="btn btn-info btn-sm">
                <span class="icon">
                    <i class="fa-solid fa-rotate"></i>
                </span>
            </button>
        </div>

        <p class="fs-6 mt-3 text-muted"><small><i class="fa-solid fa-circle-info"></i> Dernière mise à jour le <span id="maj_console_datetime">XX/XX/XXXX à xx:xx:xx</span></small></p>
    </h5>
    <div class="title_console"></div>
    <div id="logs_console" style="max-height: 70vh; overflow: scroll;">
        @if (count($logs) > 0)
            <div class="accordion accordion-flush mb-4" id="accordionConsole">
                @foreach ($logs as $log)
                    <?php $log->response = str_replace("\\r", "\r", $log->response); ?>

                    <div class="accordion-item bg-dark text-white-50">
                        <h2 class="accordion-header" id="log_<?= $log->id ?>">
                            <button class="accordion-button btn-dark bg-dark text-white-50" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse_log_<?= $log->id ?>"
                                aria-expanded="false" aria-controls="log_<?= $log->id ?>">

                                <?php $custom_id = ($log->id < 10) ? "0".strval($log->id) : strval($log->id); ?>

                                <span class="d-none d-md-block font-monospace"><b>Log n°<?= $custom_id ?></b>&nbsp;&nbsp;</span>
                                <span class="text-white">
                                    <b>[<span class="d-none d-md-inline">Le
                                            {{ $log->created_at->format('d/m') }} à
                                        </span>{{ $log->created_at->format('H:i:s') }}]</b>
                                    &nbsp;
                                </span>
                                <span class="text-warning"><b>{{ $log->command_name }}</b></span>&nbsp;<span
                                    class="@if ($log->state == 0) text-success @else text-danger @endif">(<b>{{ $log->state }}</b>)</span><br>
                            </button>
                        </h2>

                        <?php
                            $errors_json = [];

                            $log->response = preg_replace('/[[:cntrl:]]/', '', $log->response);
                            $datas = json_decode($log->response, JSON_UNESCAPED_SLASHES);

                            if(json_last_error() != JSON_ERROR_NONE)
                            array_push($errors_json, "Erreur JSON n°".json_last_error() ." lors du décodage de la réponse du log : ".json_last_error_msg());
                        ?>

                        @if (json_last_error() == JSON_ERROR_NONE)

                        <div id="collapse_log_<?= $log->id ?>" class="accordion-collapse collapse"
                            aria-labelledby="log_<?= $log->id ?>" data-bs-parent="#accordionConsole">
                            <div class="accordion-body">
                                <div class="row row-cols-1 g-4 p-3">
                                    @foreach ($datas as $data)
                                        <div class="col">
                                            <div class="card text-bg-dark border border-light h-100 border-opacity-25">
                                                <ul class="list-group list-group-flush pt-2">
                                                    <li
                                                        class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center border-none">
                                                        <div class="me-auto">
                                                            <div class="fw-bold">Identifiant
                                                                <span
                                                                    class="badge text-bg-primary rounded-pill">{{ $data["id"] }}</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li
                                                        class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center border-none">
                                                        <div class="me-auto">
                                                            <div class="fw-bold">Données</div>
                                                            <span class="text-white-50">
                                                                @if ($data["data"] == '')
                                                                    Aucune donnée disponible
                                                                @else
                                                                    {{ $data["data"] }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li
                                                        class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                                                        <div class="me-auto">
                                                            <div class="fw-bold">Statut
                                                                <span
                                                                    class="badge @if ($data['status'] == 0) text-bg-success @else text-bg-danger @endif rounded-pill">{{ $data["status"] }}</span>
                                                            </div>
                                                            <span class="text-white-50">
                                                                {{ $data["status_description"] }} </span>
                                                        </div>
                                                    </li>

                                                    <?php

                                                        if(!empty($data["trame_can_rec"]))
                                                        $trame_can_rec = json_decode($data["trame_can_rec"]);

                                                        if(json_last_error() != JSON_ERROR_NONE)
                                                        array_push($errors_json, "Erreur JSON n°".json_last_error() ." lors du décodage de la trame CAN d'envoi : ".json_last_error_msg());

                                                        if(!empty($data["trame_can_env"]))
                                                        $trame_can_env = json_decode($data["trame_can_env"]);

                                                        if(json_last_error() != JSON_ERROR_NONE)
                                                        array_push($errors_json, "Erreur JSON n°".json_last_error() ." lors du décodage de la trame CAN de réponse : ".json_last_error_msg());

                                                        $convert_trame_can = config('app.convert_trame_can');
                                                        $convert_type_trame_can = config('app.convert_type_trame_can');

                                                        $trame_php = json_decode($data["trame_php"]);

                                                        if(json_last_error() != JSON_ERROR_NONE)
                                                        array_push($errors_json, "Erreur JSON n°".json_last_error() ." lors du décodage de la trame PHP : ".json_last_error_msg());

                                                        $convert_trame_php = config('app.convert_trame_php');
                                                    ?>

                                                    @if (json_last_error() == JSON_ERROR_NONE)

                                                    <?php

                                                        if(!empty($trame_can_env) && !empty($trame_can_rec)){

                                                            if(isset($convert_trame_can[$trame_can_env->{"addr"}]) && isset($convert_trame_can[$trame_can_rec->{"emetteur"}])){
                                                                $test_addr = ($convert_trame_can[$trame_can_env->{"addr"}] == $convert_trame_can[$trame_can_rec->{"emetteur"}]) ? "success" : "warning";
                                                            }else{
                                                                $test_addr = "danger";
                                                            }

                                                            if($test_addr == "success") $msg_addr = "Le destinataire du message envoyé est bien l'expéditeur du message reçu";
                                                            else if($test_addr == "warning") $msg_addr = "Le destinataire du message envoyé est différent de l'expéditeur du message reçu";
                                                            else $msg_addr = "Le destinataire du message envoyé et/ou l'expéditeur du message reçu n'est pas spécifié dans la trame";

                                                            if(isset($convert_trame_can[$trame_can_rec->{"addr"}]) && isset($convert_trame_can[$trame_can_env->{"emetteur"}])){
                                                                $test_emetteur = ($convert_trame_can[$trame_can_rec->{"addr"}] == $convert_trame_can[$trame_can_env->{"emetteur"}]) ? "success" : "warning";
                                                            }else{
                                                                $test_emetteur = "danger";
                                                            }

                                                            if($test_emetteur == "success") $msg_emetteur = "L'expéditeur du message envoyé est bien le destinataire du message reçu";
                                                            else if($test_emetteur == "warning") $msg_emetteur = "L'expéditeur du message envoyé est différent du destinataire du message reçu";
                                                            else $msg_emetteur = "L'expéditeur du message envoyé et/ou le destinataire du message reçu n'est pas spécifié dans la trame";

                                                            $test_code_fct = ($trame_can_env->{"code_fct"} == $trame_can_rec->{"code_fct"}) ? "success" : "warning";

                                                            if($test_code_fct == "success") $msg_code_fct = "Les codes fonctions envoyés et reçus sont connus et cohérents";
                                                            else $msg_code_fct = "Les codes fonctions envoyés et reçus ne sont pas les mêmes";

                                                            $test_id_rep = ($trame_can_env->{"id_rep"} == $trame_can_rec->{"id_rep"}) ? "success" : "warning";

                                                            if($test_id_rep == "success") $msg_id_rep = "Le numéro de trame de reçu est le même que celui envoyé";
                                                            else $msg_id_rep = "Le numéro de trame de reçu ne correspond pas à celui envoyé";

                                                        }

                                                        if(!isset($test_addr)) $test_addr = "success";
                                                        if(!isset($test_emetteur)) $test_emetteur = "success";
                                                        if(!isset($test_code_fct)) $test_code_fct = "success";
                                                        if(!isset($test_id_rep)) $test_id_rep = "success";

                                                        if(!empty($trame_can_env)){

                                                            if(isset($convert_type_trame_can[$trame_can_env->{"is_rep"}])){
                                                                $test_is_rep_env = ($convert_type_trame_can[$trame_can_env->{"is_rep"}] == "Trame d'envoi") ? "success" : "warning";
                                                            }else{
                                                                $test_is_rep_env = "danger";
                                                            }

                                                            if($test_is_rep_env == "success") $msg_is_rep_env = "Le type de trame spécifié à l'envoi est connu et cohérent";
                                                            else if($test_is_rep_env == "warning") $msg_is_rep_env = "Le type de trame spécifié à l'envoi est connu mais incohérent";
                                                            else $msg_is_rep_env = "Aucun type de trame n'a été spécifié à l'envoi";

                                                            $test_trame_can_env = ($test_addr != "danger" && $test_emetteur != "danger" && $test_is_rep_env != "danger" && $test_code_fct != "danger" && $test_id_rep != "danger" && $test_is_rep_env != "danger") ? "success" : "danger";

                                                            if($test_addr == "warning" || $test_emetteur == "warning" || $test_is_rep_env == "warning" || $test_code_fct == "warning" || $test_id_rep == "warning" || $test_is_rep_env == "warning")
                                                            $test_trame_can_env = "warning";

                                                            switch ($test_trame_can_env) {
                                                                case 'success':
                                                                    $msg_trame_can_env = "Les élements contenus dans la trame sont cohérents";
                                                                    break;

                                                                case 'warning':
                                                                    $msg_trame_can_env = "Certains élements contenus dans la trame sont incohérents";
                                                                    break;

                                                                default:
                                                                    $msg_trame_can_env = "Certains élements contenus dans la trame sont inconnus et/ou incohérents";
                                                                    break;
                                                            }
                                                        }

                                                        if(!empty($trame_can_rec)){
                                                            if(isset($convert_type_trame_can[$trame_can_rec->{"is_rep"}])){
                                                                $test_is_rep_rec = ($convert_type_trame_can[$trame_can_rec->{"is_rep"}] == "Trame de réponse") ? "success" : "warning";
                                                            }else{
                                                                $test_is_rep_rec = "danger";
                                                            }

                                                            if($test_is_rep_rec == "success") $msg_is_rep_rec = "Le type de trame spécifié à la réception est connu et cohérent";
                                                            else if($test_is_rep_rec == "warning") $msg_is_rep_rec = "Le type de trame spécifié à la réception est connu mais incohérent";
                                                            else $msg_is_rep_rec = "Aucun type de trame n'a été spécifié à la réception";

                                                            $test_trame_can_rec = ($test_addr != "danger" && $test_emetteur != "danger" && $test_is_rep_rec != "danger" && $test_code_fct != "danger" && $test_id_rep != "danger" && $test_is_rep_rec != "danger") ? "success" : "danger";

                                                            if($test_addr == "warning" || $test_emetteur == "warning" || $test_is_rep_rec == "warning" || $test_code_fct == "warning" || $test_id_rep == "warning" || $test_is_rep_rec == "warning")
                                                            $test_trame_can_rec = "warning";

                                                            switch ($test_trame_can_rec) {
                                                                case 'success':
                                                                    $msg_trame_can_rec = "Les élements contenus dans la trame sont cohérents";
                                                                    break;

                                                                case 'warning':
                                                                    $msg_trame_can_rec = "Certains élements contenus dans la trame sont incohérents";
                                                                    break;

                                                                default:
                                                                    $msg_trame_can_rec = "Certains élements contenus dans la trame n'ont pas été spécifiés et/ou sont incohérents";
                                                                    break;
                                                            }

                                                        }

                                                        $test_icon = ["success" => "fa-check", "danger" => "fa-xmark", "warning" => "fa-triangle-exclamation"];
                                                    ?>
                                                    <div class="p-1 row row-cols-1 row-cols-lg-3 row-cols-md-2 g-2">
                                                        @if(!empty($trame_can_env))
                                                        <div class="col">
                                                            <div class="card text-bg-dark h-100" style="border:none;">
                                                                <div class="card-body">
                                                                    <button class="btn btn-warning btn-sm"
                                                                        onclick="addToClipboard({{ $data['trame_can_env'] }}, {{ $log->id }}, 0)"><i
                                                                            class="fa-solid fa-copy"></i></button>
                                                                    <span class="fw-bold" style="cursor: pointer;"
                                                                        onclick="afficherMasquerTrames('trame_can_env_{{ $log->id }}')">
                                                                        <span class="ps-1">Trame CAN envoyée
                                                                        </span>
                                                                        @isset($test_trame_can_env)
                                                                        @isset($msg_trame_can_env)
                                                                        <span class="badge text-bg-{{ $test_trame_can_env }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_trame_can_env }}"><i class='fa-solid {{ $test_icon[$test_trame_can_env] }}'></i></span>
                                                                        @endisset
                                                                        @endisset
                                                                        <span
                                                                            class="text-muted fst-italic fw-normal"
                                                                            id="comment_trame_can_env_{{ $log->id }}">Afficher</span>
                                                                    </span>

                                                                    <ul class="list-group d-none pt-2"
                                                                        id="list_trame_can_env_{{ $log->id }}">
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Adresse destination
                                                                                    @isset($trame_can_env->{"addr"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"addr"} }}</span>
                                                                                    @endisset
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($trame_can_env->{"addr"})
                                                                                        @isset($convert_trame_can[$trame_can_env->{"addr"}])
                                                                                            {{ $convert_trame_can[$trame_can_env->{"addr"}] }}
                                                                                        @endisset
                                                                                    @endisset
                                                                                    @isset($test_addr)
                                                                                    @isset($msg_addr)
                                                                                    <span class="badge text-bg-{{ $test_addr }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_addr }}"><i class='fa-solid {{ $test_icon[$test_addr] }}'></i></span>
                                                                                    @endisset
                                                                                    @endisset
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Adresse emetteur

                                                                                    @isset($trame_can_env->{"emetteur"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"emetteur"} }}</span>
                                                                                    @endisset
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($test_trame_can_env->{"emetteur"})
                                                                                        @isset($convert_trame_can[$trame_can_env->{"emetteur"}])
                                                                                            {{ $convert_trame_can[$trame_can_env->{"emetteur"}] }}
                                                                                        @endisset
                                                                                    @endisset
                                                                                    @isset($test_emetteur) @isset($msg_emetteur) <span class="badge text-bg-{{ $test_emetteur }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_emetteur }}"><i class='fa-solid {{ $test_icon[$test_emetteur] }}'></i></span> @endisset @endisset
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white  d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Code fonction
                                                                                @isset($trame_can_env->{"code_fct"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"code_fct"} }}</span>
                                                                                @endisset
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($trame_can_env->{"code_fct"})
                                                                                        @isset($convert_trame_can[$trame_can_env->{"code_fct"}])
                                                                                            {{ $convert_trame_can[$trame_can_env->{"code_fct"}] }}
                                                                                        @endisset
                                                                                    @endisset
                                                                                    @isset($test_code_fct)
                                                                                    @isset($msg_code_fct)
                                                                                    <span class="badge text-bg-{{ $test_code_fct }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_code_fct }}"><i class='fa-solid {{ $test_icon[$test_code_fct] }}'></i></span>
                                                                                    @endisset
                                                                                    @endisset
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Priorité
                                                                                    @isset($trame_can_env->{"id_msg"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"id_msg"} }}
                                                                                    </span>
                                                                                    @endisset
                                                                                </div>
                                                                                @isset($trame_can_env->{"id_msg"})
                                                                                <span class="text-white-50">
                                                                                    @if ($trame_can_env->{"id_msg"} == 0)
                                                                                        Non prioritaire
                                                                                    @else
                                                                                        Prioritaire
                                                                                    @endif
                                                                                </span>
                                                                                @endisset
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">ID trame
                                                                                    @isset($trame_can_env->{"id_rep"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"id_rep"} }}</span>
                                                                                    @endisset

                                                                                        @isset($test_id_rep)
                                                                                        @isset($msg_id_rep)
                                                                                        <span class="badge text-bg-{{ $test_id_rep }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_id_rep }}"><i class='fa-solid {{ $test_icon[$test_id_rep] }}'></i></span>
                                                                                        @endisset
                                                                                        @endisset
                                                                                    </div>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Type de trame
                                                                                    @isset($trame_can_env->{"is_rep"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"is_rep"} }}
                                                                                    </span>
                                                                                    @endisset
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($trame_can_env->{"is_rep"})
                                                                                        @isset($convert_type_trame_can[$trame_can_env->{"is_rep"}])
                                                                                            {{ $convert_type_trame_can[$trame_can_env->{"is_rep"}] }}
                                                                                        @endisset
                                                                                    @endisset

                                                                                    @isset($test_is_rep_env)
                                                                                    @isset($msg_is_rep_env)
                                                                                    <span class="badge text-bg-{{ $test_is_rep_env }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_is_rep_env }}"><i class='fa-solid {{ $test_icon[$test_is_rep_env] }}'></i></span>
                                                                                    @endisset
                                                                                    @endisset
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Données
                                                                                    @isset($trame_can_env->{"data"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"data"} }}</span>
                                                                                    @endisset
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if(!empty($trame_can_rec))
                                                        <div class="col">
                                                            <div class="card text-bg-dark h-100" style="border:none;">
                                                                <div class="card-body">
                                                                    <button class="btn btn-warning btn-sm"
                                                                        onclick="addToClipboard({{ $data['trame_can_rec'] }}, {{ $log->id }}, 1)"><i
                                                                            class="fa-solid fa-copy"></i></button>
                                                                    <span class="fw-bold" style="cursor: pointer;"
                                                                        onclick="afficherMasquerTrames('trame_can_rec_{{ $log->id }}')">
                                                                        <span class="ps-1">Trame CAN reçue
                                                                        </span>
                                                                        @isset($test_trame_can_rec)
                                                                        @isset($msg_trame_can_rec)
                                                                        <span class="badge text-bg-{{ $test_trame_can_rec }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_trame_can_rec }}"><i class='fa-solid {{ $test_icon[$test_trame_can_rec] }}'></i></span>
                                                                        @endisset
                                                                        @endisset
                                                                        <span
                                                                            class="text-muted fst-italic fw-normal"
                                                                            id="comment_trame_can_rec_{{ $log->id }}">Afficher</span>
                                                                    </span>

                                                                    <ul class="list-group d-none pt-2"
                                                                        id="list_trame_can_rec_{{ $log->id }}">
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Adresse destination

                                                                                    @isset($trame_can_rec->{"addr"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"addr"} }}</span>
                                                                                    @endisset
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($trame_can_rec->{"addr"})
                                                                                        @isset($convert_trame_can[$trame_can_rec->{"addr"}])
                                                                                            {{ $convert_trame_can[$trame_can_rec->{"addr"}] }}
                                                                                        @endisset
                                                                                    @endisset

                                                                                    @isset($test_emetteur)
                                                                                    @isset($msg_emetteur)
                                                                                    <span class="badge text-bg-{{ $test_emetteur }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_emetteur }}"><i class='fa-solid {{ $test_icon[$test_emetteur] }}'></i></span>
                                                                                    @endisset
                                                                                    @endisset
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Adresse emetteur

                                                                                    @isset($trame_can_rec->{"emetteur"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"emetteur"} }}</span>
                                                                                    @endisset
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($trame_can_rec->{"emetteur"})
                                                                                        @isset($convert_trame_can[$trame_can_rec->{"emetteur"}])
                                                                                            {{ $convert_trame_can[$trame_can_rec->{"emetteur"}] }}
                                                                                        @endisset
                                                                                    @endisset
                                                                                    @isset($test_addr)
                                                                                    @isset($msg_addr)
                                                                                    <span class="badge text-bg-{{ $test_addr }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_addr }}"><i class='fa-solid {{ $test_icon[$test_addr] }}'></i></span>
                                                                                    @endisset
                                                                                    @endisset
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Code fonction

                                                                                    @isset($trame_can_rec->{"code_fct"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"code_fct"} }}</span>
                                                                                    @endisset

                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($trame_can_rec->{"code_fct"})
                                                                                        @isset($convert_trame_can[$trame_can_rec->{"code_fct"}])
                                                                                            {{ $convert_trame_can[$trame_can_rec->{"code_fct"}] }}
                                                                                        @endisset
                                                                                    @endisset

                                                                                    @isset($test_code_fct)
                                                                                    @isset($msg_code_fct)
                                                                                    <span class="badge text-bg-{{ $test_code_fct }}" data-bs-toggle="tooltip" data-bs-placement="right" @isset($msg_code_fct) data-bs-title="{{ $msg_code_fct }}" @endisset><i class='fa-solid {{ $test_icon[$test_code_fct] }}'></i></span>
                                                                                    @endisset
                                                                                    @endisset
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">ID trame
                                                                                    @isset($trame_can_rec->{"id_rep"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"id_rep"} }}</span>
                                                                                    @endisset

                                                                                    @isset($test_id_rep)
                                                                                    @isset($msg_id_rep)
                                                                                    <span class="badge text-bg-{{ $test_id_rep }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_id_rep }}"><i class='fa-solid {{ $test_icon[$test_id_rep] }}'></i></span>
                                                                                    @endisset
                                                                                    @endisset
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Type de trame

                                                                                    @isset($trame_can_rec->{"is_rep"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"is_rep"} }}
                                                                                    </span>
                                                                                    @endisset

                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($trame_can_rec->{"is_rep"})
                                                                                        @isset($convert_type_trame_can[$trame_can_rec->{"is_rep"}])
                                                                                            {{ $convert_type_trame_can[$trame_can_rec->{"is_rep"}] }}
                                                                                        @endisset
                                                                                    @endisset

                                                                                    @isset($test_is_rep_rec)
                                                                                    @isset($msg_is_rep_rec)
                                                                                    <span class="badge text-bg-{{ $test_is_rep_rec }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $msg_is_rep_rec }}"><i class='fa-solid {{ $test_icon[$test_is_rep_rec] }}'></i></span>
                                                                                    @endisset
                                                                                    @endisset
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Données
                                                                                    @isset($trame_can_rec->{"data"})
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"data"} }}</span>
                                                                                    @endisset
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <div class="col">
                                                            <div class="card text-bg-dark h-100" style="border:none;">
                                                                <div class="card-body">
                                                                    <button class="btn btn-warning btn-sm"
                                                                        onclick="addToClipboard({{ $data['trame_php'] }}, {{ $log->id }}, 2)"><i
                                                                            class="fa-solid fa-copy"></i></button>
                                                                    <span class="fw-bold" style="cursor: pointer;"
                                                                        onclick="afficherMasquerTrames('trame_php_{{ $log->id }}')">
                                                                        <span class="ps-1">Trame PHP
                                                                        </span><span
                                                                            class="text-muted fst-italic fw-normal"
                                                                            id="comment_trame_php_{{ $log->id }}">Afficher</span>
                                                                    </span>

                                                                    <ul class="list-group d-none pt-2"
                                                                        id="list_trame_php_{{ $log->id }}">
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Commande

                                                                                    @isset($trame_php->{"commande"})
                                                                                        <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_php->{"commande"} }}</span>
                                                                                    @endisset

                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($trame_php->{"commande"})
                                                                                        @isset($convert_trame_php[$trame_php->{"commande"}])
                                                                                            {{ $convert_trame_php[$trame_php->{"commande"}] }}
                                                                                        @endisset
                                                                                    @endisset
                                                                                </span>
                                                                            </div>
                                                                        </li>

                                                                        @isset($trame_php->{"distance"})
                                                                            <li
                                                                                class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                                <div class="ms-2 me-auto">
                                                                                    <div class="">Distance
                                                                                        <span
                                                                                            class="badge bg-primary rounded-pill">
                                                                                            {{ $trame_php->{"distance"} }}
                                                                                            mm</span>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        @endisset

                                                                        @isset($trame_php->{"vitesse"})
                                                                            <li
                                                                                class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                                <div class="ms-2 me-auto">
                                                                                    <div class="">Vitesse
                                                                                        <span
                                                                                            class="badge bg-primary rounded-pill">
                                                                                            {{ $trame_php->{"vitesse"} }}
                                                                                            %</span>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        @endisset

                                                                        @isset($trame_php->{"direction"})
                                                                            <li
                                                                                class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                                <div class="ms-2 me-auto">
                                                                                    <div class="">Direction
                                                                                        <span
                                                                                            class="badge bg-primary rounded-pill">
                                                                                            {{ $trame_php->{"direction"} }}
                                                                                        </span>
                                                                                    </div>
                                                                                    <span class="text-white-50">
                                                                                        @isset($convert_trame_php[$trame_php->{"direction"}])
                                                                                            {{ $convert_trame_php[$trame_php->{"direction"}] }}
                                                                                        @endisset
                                                                                    </span>
                                                                                </div>
                                                                            </li>
                                                                        @endisset

                                                                        @isset($trame_php->{"arg"})
                                                                            <li
                                                                                class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                                <div class="ms-2 me-auto">
                                                                                    <div class="">Argument
                                                                                        <span
                                                                                            class="badge bg-primary rounded-pill">
                                                                                            {{ $trame_php->{"arg"} }}</span>
                                                                                    </div>
                                                                                    <span class="text-white-50">
                                                                                        @isset($convert_trame_php[$trame_php->{"arg"}])
                                                                                            {{ $convert_trame_php[$trame_php->{"arg"}] }}
                                                                                        @endisset
                                                                                    </span>
                                                                                </div>
                                                                            </li>
                                                                        @endisset

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        @if(count($errors_json) > 0)
                                                            <hr>
                                                            <div class="mb-3">
                                                                <p class="ps-3 text-muted"><i class="fa-solid fa-triangle-exclamation"></i> Des erreurs ont été détectées lors de la lecture du log : </p>
                                                                <ul>
                                                                @foreach($errors_json as $error_json)
                                                                    <li class="text-danger fst-italic">{{ $error_json }}</li>
                                                                @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Aucun log pour le moment, veuillez sélectionner une action pour commencer.
            </div>
        @endif
    </div>
</div>
