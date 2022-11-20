<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>

    <div class="container">
        <div class="row g-2">
            <div class="col pr-4 p-3">
                <h5 class="mb-4">
                    <div class="hstack gap-2">
                        @include('components.sidebarbtn')
                        Console
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
                    </div>
                </h5>
                <div id="logs_console" style="height: 70vh; overflow: scroll;">
                    @if (count($logs) > 0)
                    <div class="accordion accordion-flush mb-4" id="accordionConsole">
                        @foreach ($logs as $log)
                            <?php $log->response = str_replace("\\r", "\r", $log->response); ?>

                            <div class="accordion-item bg-dark text-white-50">
                                <h2 class="accordion-header" id="log_<?= $log->id ?>">
                                    <button class="accordion-button btn-dark bg-dark text-white-50" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_log_<?= $log->id ?>" aria-expanded="false" aria-controls="log_<?= $log->id ?>">
                                        <b>Log n°<?= $log->id ?></b>&nbsp;&nbsp;&nbsp;
                                        <span class="text-break text-white">
                                            [Le <b>{{ $log->created_at->format('d/m') }}</b> à
                                            <b>{{ $log->created_at->format('H:i:s') }}</b>]&nbsp;
                                        </span>
                                        <span
                                            class="text-break text-warning">&nbsp;&nbsp;<b>{{ $log->command_name }}</b></span><span
                                            class="@if ($log->state == 0) text-success @else text-danger @endif">&nbsp;&nbsp;(<b>{{ $log->state }}</b>)</span><br>
                                    </button>
                                </h2>

                                <?php $datas = json_decode($log->response); ?>

                                <div id="collapse_log_<?= $log->id ?>" class="accordion-collapse collapse" aria-labelledby="log_<?= $log->id ?>" data-bs-parent="#accordionConsole">
                                    <div class="accordion-body">
                                        <div class="row row-cols-1 row-cols-md-4 g-4 p-3">
                                        @foreach ($datas as $data)
                                        <div class="col">
                                            <div class="card text-bg-dark border border-light h-100 border-opacity-25">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">ID
                                                        <span class="badge bg-primary rounded-pill">{{ $data->{"id"} }}</span>
                                                    </li>
                                                    <li class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">Data
                                                        <span class="badge bg-primary rounded-pill">'{{ $data->{"data"} }}'</span>
                                                    </li>
                                                    <li class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">Status
                                                        <span class="badge @if ($data->{'status'} == 0) bg-success @else bg-danger @endif rounded-pill">{{ $data->{"status"} }}</span>
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
