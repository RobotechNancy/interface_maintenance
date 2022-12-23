<div class="container tabs" id="tab_console_logs">
    <h5 class="mb-4">
        <div class="hstack gap-2 fw-bold">
            Console de logs

            @if (Auth::user()->role == 2)
                <x-button id="20" icon="fa-solid fa-eraser" url="{{ route('clearlogs') }}" color="btn-danger"
                    addons="btn-sm" />
            @endif

            <x-button id="0" icon="fa-solid fa-file-export" url="{{ route('exportlogs') }}" addons="btn-sm" />

            <a href="{{ asset('logs.txt') }}" target="_blank">
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

                        <?php $datas = json_decode($log->response); ?>

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
                                                                    class="badge text-bg-primary rounded-pill">{{ $data->{"id"} }}</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li
                                                        class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center border-none">
                                                        <div class="me-auto">
                                                            <div class="fw-bold">Données</div>
                                                            <span class="text-white-50">
                                                                @if ($data->{"data"} == '')
                                                                    Aucune donnée disponible
                                                                @else
                                                                    {{ $data->{"data"} }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li
                                                        class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                                                        <div class="me-auto">
                                                            <div class="fw-bold">Statut
                                                                <span
                                                                    class="badge @if ($data->{'status'} == 0) text-bg-success @else text-bg-danger @endif rounded-pill">{{ $data->{"status"} }}</span>
                                                            </div>
                                                            <span class="text-white-50">
                                                                {{ $data->{"status_description"} }} </span>
                                                        </div>
                                                    </li>

                                                    <?php

                                                        $trame_can_rec = json_decode($data->{"trame_can_rec"});
                                                        $trame_can_env = json_decode($data->{"trame_can_env"});

                                                        $convert_trame_can = config('app.convert_trame_can');
                                                        $convert_type_trame_can = config('app.convert_type_trame_can');

                                                        $trame_php = json_decode($data->{"trame_php"});

                                                        $convert_trame_php = config('app.convert_trame_php');

                                                        if(isset($convert_trame_can[$trame_can_env->{"addr"}]) && isset($convert_trame_can[$trame_can_rec->{"emetteur"}])){
                                                            $test_addr = ($convert_trame_can[$trame_can_env->{"addr"}] == $convert_trame_can[$trame_can_rec->{"emetteur"}]) ? "success" : "danger";
                                                        }else{
                                                            $test_addr = "danger";
                                                        }

                                                        if(isset($convert_trame_can[$trame_can_rec->{"addr"}]) && isset($convert_trame_can[$trame_can_env->{"emetteur"}])){
                                                            $test_emetteur = ($convert_trame_can[$trame_can_rec->{"addr"}] == $convert_trame_can[$trame_can_env->{"emetteur"}]) ? "success" : "danger";
                                                        }else{
                                                            $test_emetteur = "danger";
                                                        }

                                                        $test_code_fct = ($trame_can_env->{"code_fct"} == $trame_can_rec->{"code_fct"}) ? "success" : "danger";

                                                        if(isset($convert_type_trame_can[$trame_can_env->{"is_rep"}])){
                                                            $test_is_rep_env = ($convert_type_trame_can[$trame_can_env->{"is_rep"}] == "Trame d'envoi") ? "success" : "danger";
                                                        }else{
                                                            $test_is_rep_env = "danger";
                                                        }

                                                        if(isset($convert_type_trame_can[$trame_can_rec->{"is_rep"}])){
                                                            $test_is_rep_rec = ($convert_type_trame_can[$trame_can_rec->{"is_rep"}] == "Trame de réponse") ? "success" : "danger";
                                                        }else{
                                                            $test_is_rep_rec = "danger";
                                                        }

                                                        $test_id_rep = ($trame_can_env->{"id_rep"} == $trame_can_rec->{"id_rep"}) ? "success" : "danger";

                                                        $test_trame_can_env = ($test_addr != "danger" && $test_emetteur != "danger" && $test_is_rep_env != "danger" && $test_code_fct != "danger" && $test_id_rep != "danger" && $test_is_rep_env != "danger") ? "success" : "danger";
                                                        $test_trame_can_rec = ($test_addr != "danger" && $test_emetteur != "danger" && $test_is_rep_env != "danger" && $test_code_fct != "danger" && $test_id_rep != "danger" && $test_is_rep_rec != "danger") ? "success" : "danger";

                                                        $test_icon = ["success" => "fa-check", "danger" => "fa-xmark"];
                                                    ?>
                                                    <div class="p-1 row row-cols-1 row-cols-md-3 g-2">
                                                        <div class="col">
                                                            <div class="card text-bg-dark h-100" style="border:none;">
                                                                <div class="card-body">
                                                                    <button class="btn btn-warning btn-sm"
                                                                        onclick="addToClipboard({{ $data->{'trame_can_env'} }}, {{ $log->id }}, 0)"><i
                                                                            class="fa-solid fa-copy"></i></button>
                                                                    <span class="fw-bold" style="cursor: pointer;"
                                                                        onclick="afficherMasquerTrames('trame_can_env_{{ $log->id }}')">
                                                                        <span class="ps-1">Trame CAN envoyée
                                                                        </span>
                                                                        <span class="badge text-bg-{{ $test_trame_can_env }}"><i class='fa-solid {{ $test_icon[$test_trame_can_env] }}'></i></span>
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
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"addr"} }}</span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($convert_trame_can[$trame_can_env->{"addr"}])
                                                                                        {{ $convert_trame_can[$trame_can_env->{"addr"}] }}
                                                                                    @endisset
                                                                                    <span class="badge text-bg-{{ $test_addr }}"><i class='fa-solid {{ $test_icon[$test_addr] }}'></i></span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Adresse emetteur
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"emetteur"} }}</span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($convert_trame_can[$trame_can_env->{"emetteur"}])
                                                                                        {{ $convert_trame_can[$trame_can_env->{"emetteur"}] }}
                                                                                    @endisset
                                                                                    <span class="badge text-bg-{{ $test_emetteur }}"><i class='fa-solid {{ $test_icon[$test_emetteur] }}'></i></span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white  d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Code fonction
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"code_fct"} }}</span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($convert_trame_can[$trame_can_env->{"code_fct"}])
                                                                                        {{ $convert_trame_can[$trame_can_env->{"code_fct"}] }}
                                                                                    @endisset
                                                                                    <span class="badge text-bg-{{ $test_code_fct }}"><i class='fa-solid {{ $test_icon[$test_code_fct] }}'></i></span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Priorité
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"id_msg"} }}
                                                                                    </span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @if ($trame_can_env->{"id_msg"} == 0)
                                                                                        Non prioritaire
                                                                                    @else
                                                                                        Prioritaire
                                                                                    @endif
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">ID trame
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"id_rep"} }}</span>
                                                                                        <span class="badge text-bg-{{ $test_id_rep }}"><i class='fa-solid {{ $test_icon[$test_id_rep] }}'></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Type de trame
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"is_rep"} }}
                                                                                    </span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($convert_type_trame_can[$trame_can_env->{"is_rep"}])
                                                                                        {{ $convert_type_trame_can[$trame_can_env->{"is_rep"}] }}
                                                                                    @endisset
                                                                                    <span class="badge text-bg-{{ $test_is_rep_env }}"><i class='fa-solid {{ $test_icon[$test_is_rep_env] }}'></i></span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Données
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_env->{"data"} }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card text-bg-dark h-100" style="border:none;">
                                                                <div class="card-body">
                                                                    <button class="btn btn-warning btn-sm"
                                                                        onclick="addToClipboard({{ $data->{'trame_can_rec'} }}, {{ $log->id }}, 1)"><i
                                                                            class="fa-solid fa-copy"></i></button>
                                                                    <span class="fw-bold" style="cursor: pointer;"
                                                                        onclick="afficherMasquerTrames('trame_can_rec_{{ $log->id }}')">
                                                                        <span class="ps-1">Trame CAN reçue
                                                                        </span>
                                                                        <span class="badge text-bg-{{ $test_trame_can_rec }}"><i class='fa-solid {{ $test_icon[$test_trame_can_rec] }}'></i></span>
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
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"addr"} }}</span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($convert_trame_can[$trame_can_rec->{"addr"}])
                                                                                        {{ $convert_trame_can[$trame_can_rec->{"addr"}] }}
                                                                                    @endisset
                                                                                    <span class="badge text-bg-{{ $test_emetteur }}"><i class='fa-solid {{ $test_icon[$test_emetteur] }}'></i></span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Adresse emetteur
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"emetteur"} }}</span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($convert_trame_can[$trame_can_rec->{"emetteur"}])
                                                                                        {{ $convert_trame_can[$trame_can_rec->{"emetteur"}] }}
                                                                                    @endisset
                                                                                    <span class="badge text-bg-{{ $test_addr }}"><i class='fa-solid {{ $test_icon[$test_addr] }}'></i></span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Code fonction
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"code_fct"} }}</span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($convert_trame_can[$trame_can_rec->{"code_fct"}])
                                                                                        {{ $convert_trame_can[$trame_can_rec->{"code_fct"}] }}
                                                                                    @endisset
                                                                                    <span class="badge text-bg-{{ $test_code_fct }}"><i class='fa-solid {{ $test_icon[$test_code_fct] }}'></i></span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">ID trame
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"id_rep"} }}</span>

                                                                                    <span class="badge text-bg-{{ $test_id_rep }}"><i class='fa-solid {{ $test_icon[$test_id_rep] }}'></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Type de trame
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"is_rep"} }}
                                                                                    </span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($convert_type_trame_can[$trame_can_rec->{"is_rep"}])
                                                                                        {{ $convert_type_trame_can[$trame_can_rec->{"is_rep"}] }}
                                                                                    @endisset
                                                                                    <span class="badge text-bg-{{ $test_is_rep_rec }}"><i class='fa-solid {{ $test_icon[$test_is_rep_rec] }}'></i></span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-start">
                                                                            <div class="ms-2 me-auto">
                                                                                <div class="">Données
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_can_rec->{"data"} }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card text-bg-dark h-100" style="border:none;">
                                                                <div class="card-body">
                                                                    <button class="btn btn-warning btn-sm"
                                                                        onclick="addToClipboard({{ $data->{'trame_php'} }}, {{ $log->id }}, 2)"><i
                                                                            class="fa-solid fa-copy"></i></button>
                                                                    <span class="fw-bold" style="cursor: pointer;"
                                                                        onclick="afficherMasquerTrames('trame_php_{{ $log->id }}')">
                                                                        <span class="ps-1">Trame PHP envoyée
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
                                                                                    <span
                                                                                        class="badge bg-primary rounded-pill">
                                                                                        {{ $trame_php->{"commande"} }}</span>
                                                                                </div>
                                                                                <span class="text-white-50">
                                                                                    @isset($convert_trame_php[$trame_php->{"commande"}])
                                                                                        {{ $convert_trame_php[$trame_php->{"commande"}] }}
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
                                                                                            cm</span>
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


                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
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
