<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>

    <ul class="nav nav-tabs nav-fill ms-lg-5 mb-4">
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

    <div class="container tabs ms-lg-5 d-none" id="tab_connectivite">
        <h5 class="mb-4">
            <div class="hstack gap-2">
                Connectivité (CAN, XBee)
            </div>
        </h5>
        <div style="max-height: 65vh;">
            <div class="hstack gap-2">
                Bus CAN
            </div>
            <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4 p-3">
                <div class="col">
                    <img src="{{ asset('img/carte_stm32.png') }}" height="70" width="230" /><br>
                    <span class="mt-3 mb-3 d-block">Base roulante</span>
                    <button class="btn btn-primary disabled">Tester <span class="badge text-bg-light">A
                            venir</span></button>
                </div>
                <div class="col">
                    <img src="{{ asset('img/carte_stm32.png') }}" height="70" width="230" /><br>
                    <span class="mt-3 mb-3 d-block">Odométrie</span>
                    <button class="btn btn-primary disabled">Tester <span class="badge text-bg-light">A
                            venir</span></button>
                </div>
                <div class="col">
                    <img src="{{ asset('img/carte_stm32.png') }}" height="70" width="230" /><br>
                    <span class="mt-3 mb-3 d-block">Actionneurs</span>
                    <button class="btn btn-primary disabled">Tester <span class="badge text-bg-light">A
                            venir</span></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container tabs ms-lg-5" id="tab_console_logs">
        <h5 class="mb-4">
            <div class="hstack gap-2">
                @include('components.sidebarbtn')
                Console de logs
                <x-button id="20" icon="fa-solid fa-eraser" url="{{ route('clearlogs') }}" color="btn-danger"
                    addons="btn-sm" />

                <x-button id="0" icon="fa-solid fa-file-export" url="{{ route('exportlogs') }}"
                    addons="btn-sm" />

                <a href="{{ asset('logs.txt') }}" target="_blank">
                    <button class="btn btn-secondary btn-sm">
                        <span class="icon">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </button>
                </a>

                <button id="btn_reload_console" class="btn btn-info btn-sm">
                    <span class="icon">
                        <i class="fa-solid fa-rotate"></i>
                    </span>
                </button>
            </div>
        </h5>
        <div class="title_console"></div>
        <div id="logs_console" style="max-height: 65vh; overflow: scroll;">
            @if (count($logs) > 0)
                <div class="accordion accordion-flush mb-4" id="accordionConsole">
                    @foreach ($logs as $log)
                        <?php $log->response = str_replace("\\r", "\r", $log->response); ?>

                        <div class="accordion-item bg-dark text-white-50">
                            <h2 class="accordion-header" id="log_<?= $log->id ?>">
                                <button class="accordion-button btn-dark bg-dark text-white-50" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse_log_<?= $log->id ?>"
                                    aria-expanded="false" aria-controls="log_<?= $log->id ?>">
                                    <span class="d-none d-md-block"><b>Log n°<?= $log->id ?></b>&nbsp;&nbsp;</span>
                                    <span class="text-white">
                                        <b>[<span class="d-none d-md-inline">Le {{ $log->created_at->format('d/m') }} à
                                            </span>{{ $log->created_at->format('H:i:s') }}]</b>
                                        &nbsp;
                                    </span>
                                    <span class="text-warning"><b>{{ $log->command_name }}</b></span>&nbsp;<span
                                        class="@if ($log->state == 0) text-success @else text-danger @endif">(<b>{{ $log->state }}</b>)</span><br>
                                </button>
                            </h2>

                            <?php $datas = json_decode($log->response); ?>

                            <div id="collapse_log_<?= $log->id ?>" class="accordion-collapse collapse"
                                aria-labelledby="log_<?= $log->id ?>" data-bs-parent="#accordionConsole">
                                <div class="accordion-body">
                                    <div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4 p-3">
                                        @foreach ($datas as $data)
                                            <div class="col">
                                                <div
                                                    class="card text-bg-dark border border-light h-100 border-opacity-25">
                                                    <ul class="list-group list-group-flush">
                                                        <li
                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                                                            ID
                                                            <span
                                                                class="badge bg-primary rounded-pill">{{ $data->{"id"} }}</span>
                                                        </li>
                                                        <li
                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                                                            Data
                                                            <span
                                                                class="badge bg-primary rounded-pill">'{{ $data->{"data"} }}'</span>
                                                        </li>
                                                        <li
                                                            class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                                                            Status
                                                            <span
                                                                class="badge @if ($data->{'status'} == 0) bg-success @else bg-danger @endif rounded-pill">{{ $data->{"status"} }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    Aucun log pour le moment, veuillez sélectionner une action pour commencer.
                </div>
            @endif
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
