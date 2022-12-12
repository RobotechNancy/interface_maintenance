<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>

    <div id="container_dashboard">
        @include('components.autotests')
        @include('components.console')
    </div>

    @if (session()->has('message'))
        <x-notification title="Gestion du profil">{{ session('message') }}</x-notification>
    @endif
    @if (session()->has('warning'))
        <x-notification title="Erreur de compte" color="text-bg-warning">{{ session('warning') }}</x-notification>
    @endif
    @if (session()->has('actions'))
        <x-notification title="Compte rendu d'action">{{ session('actions') }}</x-notification>
    @endif

</x-app-layout>
