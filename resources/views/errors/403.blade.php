<x-app-layout>
    <x-slot name="title"> @lang('Erreur 403') </x-slot>
    <section class="section is-small">
        <h1 class="title mb-6">Erreur 403 : accès non autorisé</h1>
        <h2 class="subtitle">
          @auth
            Le compte {{ Auth::user()->name }} n'est pas autorisé à accéder à cette page. <br>  <strong><a href="{{ url('dashboard') }}">Retour au tableau de bord</a></strong>.
          @else
            Vous n'êtes pas connecté et cette page n'est pas disponible sans connexion. <br>Pour continuer, veuillez <strong><a href="{{ route('register') }}">créer un compte</a></strong>, ou <strong><a href="{{ route('login') }}">vous connecter</a></strong>.
          @endauth
        </h2>
    </section>
</x-app-layout>
