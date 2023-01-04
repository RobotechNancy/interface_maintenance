<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-2 d-none d-md-block"></div>
            <div class="col ms-lg-4" id="container_dashboard">
                @include('components.autotests')
                @include('components.console')
            </div>
        </div>
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
