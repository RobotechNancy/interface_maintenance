<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>


    <div class="columns">
        <div class="column is-full">
            <div class="box" id="logs_console">
                <pre class="has-background-black logs" style="overflow: scroll;"><?php if(count($logs) > 0) { ?>@foreach($logs as $log)<?php $log->response = str_replace("\\r", "\r", $log->response); ?><div class="tags has-addons"><span class="tag icon is-black"><i class="fa-solid fa-caret-right" id="log_icon_<?= $log->id ?>" onclick="showCompleteLog('{{ $log->id }}');"></i></span> <span class="tag is-dark">[{{ $log->created_at->format("d/m/Y") }} à {{ $log->created_at->format("H:i:s") }}]</span><span class="tag is-info"><strong>{{ $log->command_name }}</strong></span><span class="tag <?php if($log->state == 0) echo "is-success"; else echo "is-danger"; ?>"><strong>{{ $log->state }}</strong></span></div><table class="table is-narrow has-text-centered is-fullwidth is-bordered has-background-grey-darker has-text-light" id="log_reponse_<?= $log->id ?>" style="display: none"><tbody><tr class="has-background-link-dark"><td>ID</td><td>Data</td><td>Status</td></tr><?php $datas = json_decode($log->response);?>@foreach($datas as $data)<tr><td class="has-background-grey-dark">{{ $data->{"id"} }}</td><td>{{ $data->{"data"} }}</td><td class="<?php if($log->state == 0) echo "has-background-success"; else echo "has-background-danger"; ?>"><strong>{{ $data->{"status"} }}</strong></td></tr>@endforeach</tbody></table>@endforeach
                    <?php } else { ?><span class="tag is-dark">Aucun log pour le moment, veuillez sélectionner une action pour commencer</span><?php } ?>
                </pre>
            </div>
        </div>
    </div>

    <div class="tile is-ancestor">
        <div class="tile is-4">
            <div class="tile is-parent is-vertical">
                <div class="tile is-child box notification is-light">
                    <p class="title is-5">Commandes de diagnostic</p>
                    <div class="buttons">

                        <x-button title="Vérification de la connectivité" id="1" icon="fa-solid fa-tower-cell" url="{{ route('log') }}"/>

                        <form method="POST" id="form_2" class="ml-2">
                            @csrf
                            <button class="button is-link btn_form" id="btn_2" type="submit">
                                <span>Avancer le robot</span>
                                <span class="icon">
                                    <i class="fa-solid fa-gamepad"></i>
                                </span>
                            </button>
                        </form>
                        <form method="POST" id="form_3">
                            @csrf
                            <button class="button is-link btn_form" id="btn_3" type="submit">
                                <span>Récupérer position robot</span>
                                <span class="icon">
                                    <i class="fa-solid fa-crosshairs"></i>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="tile is-child box notification is-light">
                    <p class="title is-5">Commandes de la base roulante</p>
                    <div class="columns is-vcentered is-gapless">
                        <div class="column">
                            <form method="POST" id="form_4">
                                @csrf
                                <button class="button is-link btn_form is-medium" id="btn_4" type="submit">
                                    <span class="icon">
                                        <i class="fa-solid fa-arrow-rotate-right"></i>
                                    </span>
                                </button>
                            </form>
                        </div>
                        <div class="column">
                            <form method="POST" id="form_5">
                                @csrf
                                <button class="button is-link btn_form is-medium" id="btn_5" type="submit">
                                    <span class="icon">
                                        <i class="fa-solid fa-arrow-right fa-rotate-by" style="--fa-rotate-angle: 210deg;"></i>
                                        </span>
                                </button>
                            </form>
                            <form method="POST" id="form_6">
                                @csrf
                                <button class="button is-link btn_form is-medium" id="btn_6" type="submit">
                                    <span class="icon">
                                        <i class="fa-solid fa-arrow-right fa-rotate-by" style="--fa-rotate-angle: 150deg;"></i>
                                        </span>
                                </button>
                            </form>
                        </div>
                        <div class="column">
                            <form method="POST" id="form_7">
                                @csrf
                                <button class="button is-link btn_form is-medium" id="btn_7" type="submit">
                                    <span class="icon">
                                        <i class="fa-solid fa-arrow-right fa-rotate-by" style="--fa-rotate-angle: 270deg;"></i>
                                        </span>
                                </button>
                            </form>
                            <form method="POST" id="form_8">
                                @csrf
                                <button class="button is-link btn_form is-medium" id="btn_8" type="submit">
                                    <span class="icon">
                                        <i class="fa-solid fa-arrow-right fa-rotate-by" style="--fa-rotate-angle: 90deg;"></i>
                                        </span>
                                </button>
                            </form>
                        </div>
                        <div class="column">
                            <form method="POST" id="form_9">
                                @csrf
                                <button class="button is-link btn_form is-medium" id="btn_9" type="submit">
                                    <span class="icon">
                                        <i class="fa-solid fa-arrow-right fa-rotate-by" style="--fa-rotate-angle: 330deg;"></i>
                                        </span>
                                </button>
                            </form>
                            <form method="POST" id="form_10">
                                @csrf
                                <button class="button is-link btn_form is-medium" id="btn_10" type="submit">
                                    <span class="icon">
                                        <i class="fa-solid fa-arrow-right fa-rotate-by" style="--fa-rotate-angle: 30deg;"></i>
                                        </span>
                                </button>
                            </form>
                        </div>
                        <div class="column">
                            <form method="POST" id="form_11">
                                @csrf
                                <button class="button is-link btn_form is-medium" id="btn_11" type="submit">
                                    <span class="icon">
                                        <i class="fa-solid fa-arrow-rotate-left"></i>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tile is-child box notification is-light">
                    <p class="title is-5">Commandes des actionneurs</p>
                </div>
                <div class="tile is-child box notification is-light">
                    <p class="title is-5">Alimentation générale</p>
                    <div class="columns is-vcentered">
                        <div class="column">
                            <span class="icon is-large fa-3x has-text-success">
                                <i class="fas fa-check-square"></i>
                            </span>
                        </div>
                        <div class="column">
                            <form method="POST" id="form_12">
                                @csrf
                                <button class="button is-link btn_form is-fullwidth is-success" id="btn_12" type="submit">
                                    <span>On</span>
                                </button>
                            </form>
                        </div>

                        <div class="column">
                            <form method="POST" id="form_13">
                                @csrf
                                <button class="button is-link btn_form is-fullwidth is-danger" id="btn_13" type="submit">
                                    <span>Off</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tile is-parent is-8">
            <div class="tile is-child box notification is-light">
            <span class="title is-5">
                Console
            </span>
            <div id="logs_console">
                <pre class="has-background-black logs" style="height:550px; width:780px; overflow: scroll;"><?php if(count($logs) > 0) { ?>@foreach($logs as $log)<?php $log->response = str_replace("\\r", "\r", $log->response); ?><div class="tags has-addons"><span class="tag icon is-black"><i class="fa-solid fa-caret-right" id="log_icon_<?= $log->id ?>" onclick="showCompleteLog('{{ $log->id }}');"></i></span> <span class="tag is-dark">[{{ $log->created_at->format("d/m/Y") }} à {{ $log->created_at->format("H:i:s") }}]</span><span class="tag is-info"><strong>{{ $log->command_name }}</strong></span><span class="tag <?php if($log->state == 0) echo "is-success"; else echo "is-danger"; ?>"><strong>{{ $log->state }}</strong></span></div><table class="table is-narrow has-text-centered is-fullwidth is-bordered has-background-grey-darker has-text-light" id="log_reponse_<?= $log->id ?>" style="display: none"><tbody><tr class="has-background-link-dark"><td>ID</td><td>Data</td><td>Status</td></tr><?php $datas = json_decode($log->response);?>@foreach($datas as $data)<tr><td class="has-background-grey-dark">{{ $data->{"id"} }}</td><td>{{ $data->{"data"} }}</td><td class="<?php if($log->state == 0) echo "has-background-success"; else echo "has-background-danger"; ?>"><strong>{{ $data->{"status"} }}</strong></td></tr>@endforeach</tbody></table>@endforeach
                    <?php } else { ?><span class="tag is-dark">Aucun log pour le moment, veuillez sélectionner une action pour commencer</span><?php } ?>
                </pre>
            </div>
            <div class="buttons are-small mt-3">
                <form id="form_20" method="POST">
                    @csrf
                    <button class="button is-danger btn_form" id="btn_20" type="submit">
                        <span>Supprimer les logs</span>
                        <span class="icon">
                            <i class="fa-solid fa-eraser"></i>
                        </span>
                    </button>
                </form>
                <form id="form_0" method="POST">
                    @csrf
                    <button class="button is-primary btn_form ml-2" id="btn_0" type="submit">
                        <span>Exporter les logs</span>
                        <span class="icon">
                            <i class="fa-solid fa-file-export"></i>
                        </span>
                    </button>
                </form>
                <a href="{{ asset('logs.txt') }}" target="_blank">
                    <button class="button is-info ml-2">
                        <span>Consulter le fichier de logs</span>
                        <span class="icon">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </button>
                </a>
            </div>
          </div>
        </div>
    </div>
    <div class="pageloader is-link"><span class="title">L'action est en cours de traitement, veuillez patienter...</span></div>
    <script>
    $(document).ready(function () {
        logUrl = "{{ route('log') }}";
        deleteUrl = "{{ route('clearlogs') }}";
        exportUrl = "{{ route('exportlogs') }}";

        exportId = "0";
        connectivityId = "1";
        moveId = "2";
        positionId = "3";
        rotateLeftId = "4";
        goLeftTopId = "5";
        goLeftBottomId = "6";
        goTopId = "7";
        goBottomId = "8";
        goRightTopId = "9";
        goRightBottomId = "10";
        rotateRightId = "11";
        relayOn = "12";
        relayOff = "13";
        deleteId = "20";

        sendData(deleteUrl, deleteId);
        sendData(exportUrl, exportId);
        //sendData(logUrl, connectivityId);
        sendData(logUrl, moveId);
        sendData(logUrl, positionId);
        sendData(logUrl, rotateLeftId);
        sendData(logUrl, goLeftTopId);
        sendData(logUrl, goLeftBottomId);
        sendData(logUrl, goTopId);
        sendData(logUrl, goBottomId);
        sendData(logUrl, goRightTopId);
        sendData(logUrl, goRightBottomId);
        sendData(logUrl, rotateRightId);
        sendData(logUrl, relayOn);
        sendData(logUrl, relayOff);
    });
    </script>
</x-app-layout>
@if (session()->has('message'))
<x-notification title="Gestion du profil">{{ session('message') }}</x-notification>
@endif
@if (session()->has('warning'))
<x-notification title="Erreur de compte" color="is-warning">{{ session('warning') }}</x-notification>
@endif
@if (session()->has('actions'))
<x-notification title="Compte rendu d'action" color="is-info">{{ session('actions') }}</x-notification>
@endif
