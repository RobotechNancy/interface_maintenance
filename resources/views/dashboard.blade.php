<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>


    <div class="columns has-background-white">
        <div class="column is-full">
            <div id="logs_console">
                <span class="title is-5">
                    Console
                </span>
                <pre class="has-background-black logs" style="height: 300px; overflow: scroll;"><?php if(count($logs) > 0) { ?>@foreach($logs as $log)<?php $log->response = str_replace("\\r", "\r", $log->response); ?><div class="tags has-addons"><span class="tag icon is-black"><i class="fa-solid fa-caret-right" id="log_icon_<?= $log->id ?>" onclick="showCompleteLog('{{ $log->id }}');"></i></span> <span class="tag is-dark">[{{ $log->created_at->format("d/m/Y") }} à {{ $log->created_at->format("H:i:s") }}]</span><span class="tag is-info"><strong>{{ $log->command_name }}</strong></span><span class="tag <?php if($log->state == 0) echo "is-success"; else echo "is-danger"; ?>"><strong>{{ $log->state }}</strong></span></div><div class="table-container"><table class="table is-narrow has-text-centered is-fullwidth is-bordered has-background-grey-darker has-text-light" id="log_reponse_<?= $log->id ?>" style="display: none"><tbody><tr class="has-background-link-dark"><td>ID</td><td>Data</td><td>Status</td></tr><?php $datas = json_decode($log->response);?>@foreach($datas as $data)<tr><td class="has-background-grey-dark">{{ $data->{"id"} }}</td><td>{{ $data->{"data"} }}</td><td class="<?php if($log->state == 0) echo "has-background-success"; else echo "has-background-danger"; ?>"><strong>{{ $data->{"status"} }}</strong></td></tr>@endforeach</tbody></table></div>@endforeach
                    <?php } else { ?><span class="tag is-dark">Aucun log pour le moment, veuillez sélectionner une action pour commencer</span><?php } ?>
                </pre>
            </div>
            <div class="buttons are-small mt-3">
                <x-button title="Supprimer les logs" id="20" icon="fa-solid fa-eraser" url="{{ route('clearlogs') }}" addons="is-danger"/>
                <x-button title="Exporter les logs" id="0" icon="fa-solid fa-file-export" url="{{ route('exportlogs') }}" addons="ml-2"/>

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

    <div class="tile is-ancestor">
        <div class="tile is-4">
            <div class="tile is-parent is-vertical">
                <div class="tile is-child box notification is-light">
                    <p class="title is-5">Commandes de diagnostic</p>
                    <div class="buttons">

                        <x-button title="Vérification de la connectivité" id="1" icon="fa-solid fa-tower-cell" url="{{ route('log') }}"/>
                        <x-button title="Avancer le robot" id="2" icon="fa-solid fa-gamepad" url="{{ route('log') }}"/>
                        <x-button title="Position du robot" id="3" icon="fa-solid fa-crosshairs" url="{{ route('log') }}"/>

                    </div>
                </div>

                <div class="tile is-child box notification is-light">
                    <p class="title is-5">Commandes de la base roulante</p>
                    <div class="columns is-vcentered is-gapless">
                        <div class="column">
                            <x-button id="4" icon="fa-solid fa-arrow-rotate-right" url="{{ route('log') }}"/>
                        </div>
                        <div class="column">
                            <x-button id="5" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" icon_style="--fa-rotate-angle: 210deg;"/>
                            <x-button id="6" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" icon_style="--fa-rotate-angle: 150deg;"/>
                        </div>
                        <div class="column">
                            <x-button id="7" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" icon_style="--fa-rotate-angle: 270deg;"/>
                            <x-button id="8" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" icon_style="--fa-rotate-angle: 90deg;"/>
                        </div>
                        <div class="column">
                            <x-button id="9" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" icon_style="--fa-rotate-angle: 330deg;"/>
                            <x-button id="10" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}" icon_style="--fa-rotate-angle: 30deg;"/>
                        </div>

                        <div class="column">
                            <x-button id="11" icon="fa-solid fa-arrow-rotate-left" url="{{ route('log') }}"/>
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


          </div>
        </div>
    </div>
    <div class="pageloader is-link"><span class="title">L'action est en cours de traitement, veuillez patienter...</span></div>
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
