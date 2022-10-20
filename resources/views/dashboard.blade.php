<x-app-layout>
    <x-slot name="title"> @lang('Dashboard') </x-slot>
    <div class="tile is-ancestor">
        <div class="tile is-5 is-vertical is-parent">
          <div class="tile is-child box notification is-light">
            <p class="title is-5">Commandes de contrôle</p>
            <div class="buttons">
                <form method="POST" action="{{ route('log', ['id' => 0]) }}">
                    @csrf
                    <a class="button is-fullwidth is-link is-outlined" onclick="event.preventDefault(); this.closest('form').submit();">
                        <span>Vérification de la connectivité</span>
                        <span class="icon">
                            <i class="fa-solid fa-tower-cell"></i>
                        </span>
                    </a>
                </form>
            </div>
          </div>
          <div class="tile is-child box notification is-light">
            <p class="title is-5">Commandes de diagnostic</p>
          </div>
        </div>
        <div class="tile is-parent">
          <div class="tile is-child box notification is-light">
            <p class="title is-5">Console</p>
            <pre class="has-background-black has-text-primary logs" id="logs" style="height:440px; overflow: scroll;"><?php if(isset($logs)) { ?>@foreach($logs as $log)[{{ $log->created_at->format("d/m/Y") }} à {{ $log->created_at->format("H:i:s") }}] : {{ $log->title }}, {{ $log->detail }} | {{ $log->state }}<br>@endforeach<?php } else { ?>Aucun log pour le moment, veuillez sélectionner une action pour commencer<?php } ?></pre>
          </div>
        </div>
      </div>
</x-app-layout>
@if (session()->has('message'))
<x-notification title="Gestion du profil">{{ session('message') }}</x-notification>
@endif
@if (session()->has('warning'))
<x-notification title="Erreur de compte" color="is-warning">{{ session('warning') }}</x-notification>
@endif
@if (session()->has('actions'))
<x-notification title="Compte rendu d'action" color="is-info">{{ session('actions') }}</x-notification>
<script>
    $(".logs").append("dd")
</script>
@endif
