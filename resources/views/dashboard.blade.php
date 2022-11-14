<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>


    <div class="columns">
        <div class="column is-full">
            <div id="logs_console">
                <span class="title is-5">
                    Console
                </span>
                <pre class="has-background-black logs" style="height: 300px; overflow: scroll;"><?php if(count($logs) > 0) { ?>@foreach ($logs as $log)
<?php $log->response = str_replace("\\r", "\r", $log->response); ?><div class="tags has-addons"><span class="tag icon is-black"><i class="fa-solid fa-caret-right" id="log_icon_<?= $log->id ?>" onclick="showCompleteLog('{{ $log->id }}');"></i></span> <span class="tag is-dark">[{{ $log->created_at->format('d/m/Y') }} à {{ $log->created_at->format('H:i:s') }}]</span><span class="tag is-info"><strong>{{ $log->command_name }}</strong></span><span class="tag <?php if ($log->state == 0) {
    echo 'is-success';
} else {
    echo 'is-danger';
} ?>"><strong>{{ $log->state }}</strong></span></div><div class="table-container"><table class="table is-narrow has-text-centered is-fullwidth is-bordered has-background-grey-darker has-text-light" id="log_reponse_<?= $log->id ?>" style="display: none"><tbody><tr class="has-background-link-dark"><td>ID</td><td>Data</td><td>Status</td></tr><?php $datas = json_decode($log->response); ?>@foreach ($datas as $data)
<tr><td class="has-background-grey-dark">{{ $data->{"id"} }}</td><td>{{ $data->{"data"} }}</td><td class="<?php if ($log->state == 0) {
    echo 'has-background-success';
} else {
    echo 'has-background-danger';
} ?>"><strong>{{ $data->{"status"} }}</strong></td></tr>
@endforeach
</tbody></table></div>
@endforeach
                    <?php } else { ?><span class="tag is-dark">Aucun log pour le moment, veuillez sélectionner une action pour commencer</span><?php } ?>
                </pre>
            </div>
            <div class="buttons are-small mt-3">
                <x-button title="Supprimer les logs" id="20" icon="fa-solid fa-eraser"
                    url="{{ route('clearlogs') }}" color="is-danger" />
                <x-button title="Exporter les logs" id="0" icon="fa-solid fa-file-export"
                    url="{{ route('exportlogs') }}" addons="ml-2" />

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

    <div class="columns mt-4">
        <div class="column box">
            <p class="title is-5">Commandes de diagnostic</p>
            <div class="columns">
                <div class="column">
                <x-button title="Test connectivité" id="1" icon="fa-solid fa-tower-cell"
                    url="{{ route('log') }}" />
                <x-button title="Position du robot" id="3" icon="fa-solid fa-crosshairs"
                    url="{{ route('log') }}" addons="mt-2"/>
                </div>
            </div>
        </div>
        <div class="column is-two-fifths box">
            <p class="title is-5">Commandes de la base roulante</p>
            <div class="columns is-mobile is-centered is-gapless">
                <div class="column">
                    <x-button id="4" icon="fa-solid fa-arrow-rotate-right" url="{{ route('log') }}" color="is-white" addons="is-rounded is-medium is-fullwidth"/>
                </div>
                <div class="column">
                    <x-button id="5" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                        iconstyle="--fa-rotate-angle: 210deg;" color="is-white" addons="is-rounded is-medium is-fullwidth" />
                    <x-button id="6" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                        iconstyle="--fa-rotate-angle: 150deg;" color="is-white" addons="is-rounded is-medium is-fullwidth" />
                </div>
                <div class="column">
                    <x-button id="7" icon="fa-solid fa-arrow-up fa-rotate-by" url="{{ route('log') }}"
                        color="is-white" addons="is-rounded is-medium is-fullwidth" />
                    <x-button id="8" icon="fa-solid fa-arrow-down fa-rotate-by" url="{{ route('log') }}"
                        color="is-white" addons="is-rounded is-medium is-fullwidth" />
                </div>
                <div class="column">
                    <x-button id="9" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                        iconstyle="--fa-rotate-angle: 330deg;" color="is-white" addons="is-rounded is-medium is-fullwidth" />
                    <x-button id="10" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                        iconstyle="--fa-rotate-angle: 30deg;" color="is-white" addons="is-rounded is-medium is-fullwidth" />
                </div>

                <div class="column">
                    <x-button id="11" icon="fa-solid fa-arrow-rotate-left" url="{{ route('log') }}" color="is-white" addons="is-rounded is-medium is-fullwidth" />
                </div>
            </div>
        </div>
        <div class="column box">
            <p class="title is-5">Autres commandes</p>
            <p class="control">
                <div class="b-checkbox is-default is-circular">
                    <input id="checkbox" class="switch is-medium is-success" name="remember" checked type="checkbox">
                    <label for="checkbox">
                        {{  __('Alimentation générale') }}
                    </label>
                </div>
            </p>
            <!--div class="columns is-vcentered">
                <div class="column">
                    <span class="icon is-large fa-3x has-text-success">
                        <i class="fas fa-check-square"></i>
                    </span>
                </div>
                <div class="column">
                    <x-button title="On" id="12" url="{{ route('log') }}" />
                </div>

                <div class="column">
                    <x-button title="Off" id="13" url="{{ route('log') }}" />
                </div>
            </div-->
        </div>
    </div>
    <div class="pageloader is-link"><span class="title">L'action est en cours de traitement, veuillez
            patienter...</span></div>
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
