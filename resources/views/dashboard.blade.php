<x-app-layout>
    <x-slot name="title"> @lang('Dashboard') </x-slot>
    <div class="tile is-ancestor">
        <div class="tile is-5 is-vertical is-parent">
          <div class="tile is-child box notification is-light">
            <p class="title is-5">Commandes de contrôle</p>
            <div class="buttons">
                <form method="POST" id="form_1">
                    @csrf
                    <button class="button is-link" type="submit">
                        <span>Vérification de la connectivité</span>
                        <span class="icon">
                            <i class="fa-solid fa-tower-cell"></i>
                        </span>
                    </button>
                </form>
                <form method="POST" id="form_2" class="ml-5">
                    @csrf
                    <button class="button is-link" type="submit">
                        <span>Avancer le robot</span>
                        <span class="icon">
                            <i class="fa-solid fa-gamepad"></i>
                        </span>
                    </button>
                </form>
                <form method="POST" id="form_3">
                    @csrf
                    <button class="button is-link" type="submit">
                        <span>Récupérer position robot</span>
                        <span class="icon">
                            <i class="fa-solid fa-crosshairs"></i>
                        </span>
                    </button>
                </form>
            </div>
          </div>
          <div class="tile is-child box notification is-light">
            <p class="title is-5">Commandes de diagnostic</p>
          </div>
        </div>
        <div class="tile is-parent">
          <div class="tile is-child box notification is-light">
            <span class="title is-5">
                Console
            </span>
            <form id="form_0" method="POST" action="">
                @csrf
                <button class="button is-danger ml-5 mb-5" type="submit">
                    <span>Supprimer les logs</span>
                    <span class="icon">
                        <i class="fa-solid fa-eraser"></i>
                    </span>
                </button>
            </form>
            <div id="logs_console">
            <pre class="has-background-black logs" style="height:440px; overflow: scroll;"><?php if(count($logs) > 0) { ?>@foreach($logs as $log)<span class="has-text-info">[{{ $log->created_at->format("d/m/Y") }} à {{ $log->created_at->format("H:i:s") }}] :</span> <span class="has-text-white">{{ $log->command_name }} -> {{ $log->response }}</span> <span class="<?php if($log->state == 0) echo "has-text-success"; else echo "has-text-danger"; ?>">({{ $log->state }})</span><br>@endforeach<?php } else { ?><span class="has-text-info">Aucun log pour le moment, veuillez sélectionner une action pour commencer</span><?php } ?></pre>
            </div>
        </div>
        </div>
      </div>
    <script>
    $(document).ready(function () {
        logUrl = "{{ route('log') }}";
        deleteUrl = "{{ route('clearlogs') }}";

        deleteId = "0";
        connectivityId = "1";
        moveId = "2";
        positionId = "3";

        sendData(deleteUrl, deleteId);
        sendData(logUrl, connectivityId);
        sendData(logUrl, moveId);
        sendData(logUrl, positionId);
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
