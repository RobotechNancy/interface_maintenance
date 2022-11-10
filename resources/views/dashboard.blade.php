<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>


    <div class="columns has-background-white">
        <div class="column is-10">
            <div id="logs_console">
                <span class="title is-5">
                    Console
                </span>
                <pre class="has-background-black logs" style="height: 200px; overflow: scroll;"><?php if(count($logs) > 0) { ?>@foreach($logs as $log)<?php $log->response = str_replace("\\r", "\r", $log->response); ?><div class="tags has-addons"><span class="tag icon is-black"><i class="fa-solid fa-caret-right" id="log_icon_<?= $log->id ?>" onclick="showCompleteLog('{{ $log->id }}');"></i></span> <span class="tag is-dark">[{{ $log->created_at->format("d/m/Y") }} à {{ $log->created_at->format("H:i:s") }}]</span><span class="tag is-info"><strong>{{ $log->command_name }}</strong></span><span class="tag <?php if($log->state == 0) echo "is-success"; else echo "is-danger"; ?>"><strong>{{ $log->state }}</strong></span></div><div class="table-container"><table class="table is-narrow has-text-centered is-fullwidth is-bordered has-background-grey-darker has-text-light" id="log_reponse_<?= $log->id ?>" style="display: none"><tbody><tr class="has-background-link-dark"><td>ID</td><td>Data</td><td>Status</td></tr><?php $datas = json_decode($log->response);?>@foreach($datas as $data)<tr><td class="has-background-grey-dark">{{ $data->{"id"} }}</td><td>{{ $data->{"data"} }}</td><td class="<?php if($log->state == 0) echo "has-background-success"; else echo "has-background-danger"; ?>"><strong>{{ $data->{"status"} }}</strong></td></tr>@endforeach</tbody></table></div>@endforeach
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
                        <x-button title = "Avancer le robot" id ="2" icon ="fa-solid fa-gamepad" url="{{ route('log') }}"/>
                        <x-button id="3" icon="fa-solid fa-crosshairs" url="{{ route('log') }}"/>                        

                    </div>
                </div>

                <div class="tile is-child box notification is-light">
                    <p class="title is-5">Commandes de la base roulante</p>
                    <div class="columns is-vcentered is-gapless">
                        <div class="column">
                            <x-button  id="4" icon="fa-solid fa-arrow-rotate-right" url="{{ route('log') }}"/>
                        </div>
                        <div class="column">
                            <x-button  id="5" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" style = "--fa-rotate-angle: 210deg;"/>
                            <x-button  id="6" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" style = "--fa-rotate-angle: 150deg;"/>
                        </div>
                        <div class="column">
                            <x-button  id="7" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" style = "--fa-rotate-angle: 270deg;"/>
                            <x-button  id="8" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" style = "--fa-rotate-angle: 90deg;"/>
                        </div>
                        <div class="column">
                            <x-button  id="9" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" style = "--fa-rotate-angle: 330deg;"/>
                            <x-button  id="10" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" style = "--fa-rotate-angle: 30deg;"/>
                        </div>

                        <div class="column">
                            <x-button  id="11" icon="fa-solid fa-arrow-rotate-left" url="{{ route('log') }}"/>
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
                            <x-button title="On" id="12" url="{{ route('log') }}"/>
                        </div>

                        <div class="column">
                            <x-button title="Off" id="13" url="{{ route('log') }}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tile is-parent is-8">
            <div class="tile is-child box notification is-light">

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
