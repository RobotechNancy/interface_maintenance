<x-app-layout>
    <x-slot name="title"> @lang('Dashboard') </x-slot>
    <div class="tile is-ancestor">
        <div class="tile is-5 is-vertical is-parent">
          <div class="tile is-child box notification is-light">
            <p class="title is-5">Commandes de contrôle</p>
            <div class="buttons">
                <form method="POST" id="form_check_connect">
                    @csrf
                    <button class="button is-link" type="submit" id="btn_check_connect">
                        <span>Vérification de la connectivité</span>
                        <span class="icon">
                            <i class="fa-solid fa-tower-cell"></i>
                        </span>
                    </button>
                </form>
                <form method="POST" id="form_move" class="ml-5">
                    @csrf
                    <button class="button is-link" type="submit" id="btn_move">
                        <span>Avancer le robot</span>
                        <span class="icon">
                            <i class="fa-solid fa-tower-cell"></i>
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
            <form id="form_clearlogs" method="POST">
                @csrf
                <button class="button is-danger ml-5 mb-5" type="submit" id="btn_clearlogs">
                    <span>Supprimer les logs</span>
                    <span class="icon">
                        <i class="fa-solid fa-eraser"></i>
                    </span>
                </button>
            </form>
            <div id="logs_console">
            <pre class="has-background-black logs" style="height:440px; overflow: scroll;"><?php if(count($logs) > 0) { ?>@foreach($logs as $log)<span class="has-text-info">[{{ $log->created_at->format("d/m/Y") }} à {{ $log->created_at->format("H:i:s") }}] :</span> <span class="has-text-white">{{ $log->title }}, {{ $log->detail }}</span> <span class="has-text-primary">({{ $log->state }})</span><br>@endforeach<?php } else { ?><span class="has-text-info">Aucun log pour le moment, veuillez sélectionner une action pour commencer</span><?php } ?></pre>
            </div>
        </div>
        </div>
      </div>
    <script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#form_clearlogs").submit(function(e){

            e.preventDefault();

            $.ajax({
                type:'POST',
                url:'{{ route('clearlogs') }}',
                data:'',
                success:function(data) {
                    $("#logs_console").load(" #logs_console");
                    console.log(data)
                }
                });
        });

        $("#form_check_connect").submit(function(e){

            e.preventDefault();

            $.ajax({
                type:'POST',
                url:'{{ route('log') }}',
                data:{id:0},
                success:function(data) {
                    $("#logs_console").load(" #logs_console");
                    console.log(data);
                }
                });
        });

        $("#form_move").submit(function(e){

            e.preventDefault();

            $.ajax({
                type:'POST',
                url:'{{ route('log') }}',
                data:{id:1},
                success:function(data) {
                    $("#logs_console").load(" #logs_console");
                    console.log(data);
                }
            });
        });


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
