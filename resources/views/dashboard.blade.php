<x-app-layout>
    <x-slot name="title"> @lang('Dashboard') </x-slot>
    <div class="tile is-ancestor">
        <div class="tile is-5 is-vertical is-parent">
          <div class="tile is-child box notification is-light">
            <p class="title is-5">Commandes de contrôle</p>
            <div class="buttons">
                <form method="POST" id="form_1">
                    @csrf
                    <button class="button is-link btn_form" id="btn_1" type="submit">
                        <span>Vérification de la connectivité</span>
                        <span class="icon">
                            <i class="fa-solid fa-tower-cell"></i>
                        </span>
                    </button>
                </form>
                <form method="POST" id="form_2" class="ml-5">
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
                <button class="button is-danger mb-5 btn_form mt-5" id="btn_0" type="submit">
                    <span>Supprimer les logs</span>
                    <span class="icon">
                        <i class="fa-solid fa-eraser"></i>
                    </span>
                </button>
            </form>
            <div id="logs_console">
                <pre class="has-background-black logs" style="height:400px; width:780px !important; overflow: scroll;"><?php if(count($logs) > 0) { ?>@foreach($logs as $log)<?php $log->response = str_replace("\\r", "\r", $log->response); ?>
<div class="tags has-addons"><span class="tag icon is-black"><i class="fa-solid fa-caret-right" id="log_icon_<?= $log->id ?>" onclick="showCompleteLog('{{ $log->id }}');"></i></span> <span class="tag is-dark">[{{ $log->created_at->format("d/m/Y") }} à {{ $log->created_at->format("H:i:s") }}]</span><span class="tag is-info"><strong>{{ $log->command_name }}</strong></span><span class="tag <?php if($log->state == 0) echo "is-success"; else echo "is-danger"; ?>"><strong>{{ $log->state }}</strong></span></div><table class="table is-narrow has-text-centered is-fullwidth is-bordered has-background-grey-darker has-text-light" id="log_reponse_<?= $log->id ?>" style="display: none"><tbody><tr class="has-background-info-dark"><td>ID</td><td>Data</td><td>Status</td></tr><?php $datas = json_decode($log->response);?>@foreach($datas as $data)<tr><td class="has-background-grey">{{ $data->{"id"} }}</td><td>{{ $data->{"data"} }}</td><td class="<?php if($log->state == 0) echo "has-background-success-dark"; else echo "has-background-danger-dark"; ?>"><strong>{{ $data->{"status"} }}</strong></td></tr>@endforeach</tbody></table>@endforeach
                    <?php } else { ?><span class="tag is-dark">Aucun log pour le moment, veuillez sélectionner une action pour commencer</span><?php } ?>
                </pre>
            </div>
        </div>
        </div>
      </div>
      <div class="pageloader is-link"><span class="title">L'action est en cours de traitement, veuillez patienter...</span></div>
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
