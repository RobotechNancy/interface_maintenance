<x-app-layout>
    <x-slot name="title"> @lang('Home') </x-slot>
    <section class="section is-small">
        <h1 class="title mb-6"> @auth Hello {{ Auth::user()->name }} ! <br> @endauth Bienvenue sur l'interface de maintenance de Robotech Nancy !</h1>
        <h2 class="subtitle">
          @auth
            Toutes les fonctions de contrôle et de commande des robots sont disponibles sur le <strong><a href="{{ url('dashboard') }}">tableau de bord</a></strong>.
          @else
            Pour commencer, veuillez <strong><a href="{{ route('register') }}">créer un compte</a></strong>, ou <strong><a href="{{ route('login') }}">vous connecter</a></strong>.
          @endauth
        </h2>
    </section>
</x-app-layout>
