<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>

    <div class="ms-3 me-3">
        <div class="row">
            <div class="col border">
                @include('components.navbar')
            </div>
        </div>
        <div class="row">
            <div class="col-2 border">
                @include('components.sidebar')
            </div>
            <div class="col border">
                <div id="">
                    <ul class="nav nav-tabs nav-fill mb-5">
                        <li class="nav-item">
                            <button class="nav-link active btn_tabs" id="btn_tab_console_logs">Console de logs</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link text-white btn_tabs" id="btn_tab_connectivite">Connectivité (CAN, XBee) <span
                                    class="badge text-bg-info">Beta</span></button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link disabled">Actionneurs <span class="badge text-bg-light">A venir</span></button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link disabled">Odométrie <span class="badge text-bg-light">A venir</span></button>
                        </li>
                    </ul>

                    @include('components.autotests')
                    @include('components.console')
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <x-notification title="Gestion du profil">{{ session('message') }}</x-notification>
    @endif
    @if (session()->has('warning'))
        <x-notification title="Erreur de compte" color="bg-warning">{{ session('warning') }}</x-notification>
    @endif
    @if (session()->has('actions'))
        <x-notification title="Compte rendu d'action">{{ session('actions') }}</x-notification>
    @endif

</x-app-layout>
