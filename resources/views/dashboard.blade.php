<x-app-layout>
    <x-slot name="title"> @lang('Dashboard') </x-slot>
    Tableau de bord et de contrôle
</x-app-layout>
@if (session()->has('message'))
<x-notification title="Gestion du profil">{{ session('message') }}</x-notification>
@endif
