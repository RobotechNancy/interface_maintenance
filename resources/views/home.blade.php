<x-app-layout>
    <x-slot name="title"> @lang('Home') </x-slot>
    <h3 class="title mb-6"> @auth Hello {{ Auth::user()->name }} ! <br> @endauth Bienvenue sur l'interface de
        maintenance de Robotech Nancy !
    </h3>
    <h5 class="mt-5">
        @auth
            Toutes les fonctions de contrôle et de commande des robots sont disponibles sur le <strong><a
                    href="{{ url('dashboard') }}">tableau de bord</a></strong>.
        @else
            Pour commencer, veuillez <strong><a href="{{ route('register') }}">créer un compte</a></strong>, ou
            <strong><a href="{{ route('login') }}">vous connecter</a></strong>.
        @endauth
    </h5>
</x-app-layout>
@if (session()->has('message'))
    <x-notification title="Action réussie" color="is-success">{{ session('message') }}</x-notification>
@endif

@if (session()->has('warning'))
    <x-notification title="Erreur de compte" color="is-warning">{{ session('warning') }}</x-notification>
@endif
