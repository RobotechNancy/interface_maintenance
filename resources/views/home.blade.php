<x-app-layout>
    <x-slot name="title"> @lang('Home') </x-slot>
    <h3 class="title mb-6 p-3"> @auth Hello {{ Auth::user()->name }} ! <br> @endauth Bienvenue sur l'interface de
        maintenance de Robotech Nancy !
    </h3>
    <h5 class="mt-5 p-3">
        @auth
            Toutes les fonctions de contrôle et de commande des robots sont disponibles sur le <strong><a
                    href="{{ url('dashboard') }}" style="text-decoration: none;">tableau de bord</a></strong>.
        @else
            Pour commencer, veuillez <strong><a href="{{ route('register') }}" style="text-decoration: none;">créer un compte</a></strong>, ou
            <strong><a href="{{ route('login') }}" style="text-decoration: none;">vous connecter</a></strong>.
        @endauth
    </h5>

    @if (session()->has('message'))
    <x-notification title="Action réussie" color="bg-success">{{ session('message') }}</x-notification>
    @endif

    @if (session()->has('warning'))
        <x-notification title="Erreur de compte" color="bg-warning">{{ session('warning') }}</x-notification>
    @endif
</x-app-layout>

