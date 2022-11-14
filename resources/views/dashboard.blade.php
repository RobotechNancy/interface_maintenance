<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>

    <div class="container">
        <div class="row">
          <div class="col">
            <h5 class="mb-4">Console

                <x-button id="20" icon="fa-solid fa-eraser"
                    url="{{ route('clearlogs') }}" color="btn-danger" addons="btn-sm"/>

                <x-button id="0" icon="fa-solid fa-file-export"
                    url="{{ route('exportlogs') }}" addons="btn-sm" />

                <a href="{{ asset('logs.txt') }}" target="_blank">
                    <button class="button is-info ml-2">
                        <span>Consulter le fichier de logs</span>
                        <span class="icon">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </button>
                </a>

            </h5>
            <div id="logs_console" style="height: 100%; overflow: scroll;" style="font-family: monospace !important">
                @if (count($logs) > 0)
                    @foreach ($logs as $log)

                        <?php $log->response = str_replace("\\r", "\r", $log->response); ?>

                        <i class="fa-solid fa-caret-right" id="log_icon_<?= $log->id ?>" onclick="showCompleteLog('{{ $log->id }}');"></i>
                        <span>[Le {{ $log->created_at->format('d/m/Y') }} à {{ $log->created_at->format('H:i:s') }}]</span><br class="d-sm-none">
                        <span>{{ $log->command_name }}</span><br>

                        <?php $datas = json_decode($log->response); ?>

                        <div id="log_reponse_<?= $log->id ?>" style="display: none">
                        @foreach ($datas as $data)

                            <span>{{ $data->{"id"} }}</span>
                            <span>{{ $data->{"data"} }}</span>
                            <span>{{ $data->{"status"} }}</span>

                        @endforeach
                        </div>
                        <br>
                    @endforeach

                @else
                    <span>Aucun log pour le moment, veuillez sélectionner une action pour commencer.</span>
                @endif
            </div>
          </div>

          <div class="w-100 d-sm-none"></div>

          <div class="col text-center">
            Column
          </div>
        </div>
      </div>

    <div class="columns">
        <div class="column is-full">
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
                        url="{{ route('log') }}" addons="mt-2" />
                </div>
            </div>
        </div>
        <div class="column is-two-fifths box">
            <p class="title is-5">Commandes de la base roulante</p>
            <div class="columns is-mobile is-centered is-gapless">
                <div class="column">
                    <x-button id="4" icon="fa-solid fa-arrow-rotate-right" url="{{ route('log') }}"
                        color="is-white" addons="is-rounded is-medium is-fullwidth" />
                </div>
                <div class="column">
                    <x-button id="5" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                        iconstyle="--fa-rotate-angle: 210deg;" color="is-white"
                        addons="is-rounded is-medium is-fullwidth" />
                    <x-button id="6" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                        iconstyle="--fa-rotate-angle: 150deg;" color="is-white"
                        addons="is-rounded is-medium is-fullwidth" />
                </div>
                <div class="column">
                    <x-button id="7" icon="fa-solid fa-arrow-up fa-rotate-by" url="{{ route('log') }}"
                        color="is-white" addons="is-rounded is-medium is-fullwidth" />
                    <x-button id="8" icon="fa-solid fa-arrow-down fa-rotate-by" url="{{ route('log') }}"
                        color="is-white" addons="is-rounded is-medium is-fullwidth" />
                </div>
                <div class="column">
                    <x-button id="9" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                        iconstyle="--fa-rotate-angle: 330deg;" color="is-white"
                        addons="is-rounded is-medium is-fullwidth" />
                    <x-button id="10" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                        iconstyle="--fa-rotate-angle: 30deg;" color="is-white"
                        addons="is-rounded is-medium is-fullwidth" />
                </div>

                <div class="column">
                    <x-button id="11" icon="fa-solid fa-arrow-rotate-left" url="{{ route('log') }}"
                        color="is-white" addons="is-rounded is-medium is-fullwidth" />
                </div>
            </div>
        </div>
        <div class="column box">
            <p class="title is-5">Autres commandes</p>
            <p class="control">
            <div class="b-checkbox is-default is-circular">
                <input id="checkbox" class="switch is-medium is-success" name="remember" checked type="checkbox">
                <label for="checkbox">
                    {{ __('Alimentation générale') }}
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
    @if (session()->has('message'))
        <x-notification title="Gestion du profil">{{ session('message') }}</x-notification>
    @endif
    @if (session()->has('warning'))
        <x-notification title="Erreur de compte" color="bg-warning">{{ session('warning') }}</x-notification>
    @endif
    @if (session()->has('actions'))
        <x-notification title="Compte rendu d'action">{{ session('actions') }}</x-notification>
    @endif

</x-app-layout>
