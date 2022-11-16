<x-app-layout>
    <x-slot name="addons"></x-slot>
    <x-slot name="title"> @lang('Dashboard') </x-slot>

    <div class="container">
        <div class="row g-2">
            <div class="col pr-4">
                <h5 class="mb-4">
                    <div class="hstack gap-2">
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
                        @foreach ($logs as $log)
                            <?php $log->response = str_replace("\\r", "\r", $log->response); ?>

                            <i class="fa-solid fa-caret-right mt-2" id="log_icon_<?= $log->id ?>"
                                onclick="showCompleteLog('{{ $log->id }}');"></i>&nbsp;
                            <span class="text-dark bg-white">
                                &nbsp;Le <b>{{ $log->created_at->format('d/m') }}</b> à
                                <b>{{ $log->created_at->format('H:i:s') }}</b>&nbsp;
                            </span>
                            <br class="d-sm-none">
                            <span class="text-warning">&nbsp;&nbsp;<b>{{ $log->command_name }}</b></span><span class="@if ($log->state == 0) text-success @else text-danger @endif">&nbsp;&nbsp;(<b>{{ $log->state }}</b>)</span><br>

                            <?php $datas = json_decode($log->response); ?>

                            <div id="log_reponse_<?= $log->id ?>" style="display: none">
                                @foreach ($datas as $data)
                                <ul class="mt-3 list-group">
                                    {
                                        <li class="text-info">&nbsp;&nbsp;&nbsp;ID : <b>{{ $data->{"id"} }}</b></li>
                                        <li class="text-warning">&nbsp;&nbsp;&nbsp;Data : {{ $data->{"data"} }}</li>
                                        <li class="@if ($data->{'status'} == 0) text-success @else text-danger @endif">&nbsp;&nbsp;&nbsp;Status : <b>{{ $data->{"status"} }}</b></li>
                                    },
                                </ul>
                                @endforeach
                            </div>
                            <br>
                        @endforeach
                    @else
                        <span>Aucun log pour le moment, veuillez sélectionner une action pour commencer.</span>
                    @endif
                </div>
            </div>

            <div class="w-100 d-sm-none"></div>

            <div class="col d-grid m-3">
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    <div class="col">
                        <h5 class="mb-3">Commandes de diagnostic</h5>
                        <x-button title="Test connectivité" id="1" icon="fa-solid fa-tower-cell"
                            url="{{ route('log') }}" />
                        <x-button title="Position du robot" id="3" icon="fa-solid fa-crosshairs"
                            url="{{ route('log') }}" addons="mt-2 mb-4" />
                    </div>

                    <div class="w-100 d-sm-none"></div>

                    <div class="col">
                        <h5 class="mb-3">Base roulante</h5>

                        <div class="vstack gap-2">
                            <div class="hstack gap-2">

                                <x-button id="4" icon="fa-solid fa-arrow-rotate-right"
                                    url="{{ route('log') }}" color="btn-dark" addons="btn-lg" />

                                <div class="vstack gap-2">

                                    <div class="hstack gap-2">

                                        <x-button id="5" icon="fa-solid fa-arrow-right fa-rotate-by"
                                            url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 210deg;"
                                            color="btn-dark" addons="btn-lg" />

                                        <x-button id="7" icon="fa-solid fa-arrow-up fa-rotate-by"
                                            url="{{ route('log') }}" color="btn-dark" addons="btn-lg" />


                                        <x-button id="9" icon="fa-solid fa-arrow-right fa-rotate-by"
                                            url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 330deg;"
                                            color="btn-dark" addons="btn-lg" />

                                    </div>

                                    <div class="hstack gap-2">

                                        <x-button id="6" icon="fa-solid fa-arrow-right fa-rotate-by"
                                            url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 150deg;"
                                            color="btn-dark" addons="btn-lg" />
                                        <x-button id="8" icon="fa-solid fa-arrow-down fa-rotate-by"
                                            url="{{ route('log') }}" color="btn-dark" addons="btn-lg" />

                                        <x-button id="10" icon="fa-solid fa-arrow-right fa-rotate-by"
                                            url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 30deg;"
                                            color="btn-dark" addons="btn-lg" />

                                    </div>
                                </div>

                                <x-button id="11" icon="fa-solid fa-arrow-rotate-left" url="{{ route('log') }}"
                                color="btn-dark" addons="btn-lg" />

                            </div>

                        </div>

                    </div>

                    <div class="w-100 d-sm-none"></div>

                    <div class="col">
                        <h5 class="mb-3">Alimentation générale</h5>
                        <span class="icon is-large fa-3x text-success">
                            <i class="fas fa-check-square"></i>
                        </span>
                        <x-button title="On" id="12" url="{{ route('log') }}" />

                        <x-button title="Off" id="13" url="{{ route('log') }}" addons="mt-2" />

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--div class="fixed-bottom bg-dark text-white text-center d-sm-none">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="col">
                    <h5 class="mb-3">Alimentation générale</h5>

                    <div class="hstack gap-2">

                        <span class="icon is-large fa-3x text-success">
                            <i class="fas fa-check-square"></i>
                        </span>
                        <x-button title="On" id="12" url="{{ route('log') }}" />

                        <x-button title="Off" id="13" url="{{ route('log') }}"/>

                    </div>

                </div>
              </div>
              <div class="carousel-item">
                <div class="col">
                    <h5 class="mb-3">Commandes de la base roulante</h5>

                    <div class="vstack gap-2">
                        <div class="hstack gap-2">

                            <x-button id="4" icon="fa-solid fa-arrow-rotate-right"
                                url="{{ route('log') }}" color="btn-dark" addons="btn-lg" />

                            <div class="vstack gap-2">

                                <div class="hstack gap-2">

                                    <x-button id="5" icon="fa-solid fa-arrow-right fa-rotate-by"
                                        url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 210deg;"
                                        color="btn-dark" addons="btn-lg" />

                                    <x-button id="7" icon="fa-solid fa-arrow-up fa-rotate-by"
                                        url="{{ route('log') }}" color="btn-dark" addons="btn-lg" />


                                    <x-button id="9" icon="fa-solid fa-arrow-right fa-rotate-by"
                                        url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 330deg;"
                                        color="btn-dark" addons="btn-lg" />

                                </div>

                                <div class="hstack gap-2">

                                    <x-button id="6" icon="fa-solid fa-arrow-right fa-rotate-by"
                                        url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 150deg;"
                                        color="btn-dark" addons="btn-lg" />
                                    <x-button id="8" icon="fa-solid fa-arrow-down fa-rotate-by"
                                        url="{{ route('log') }}" color="btn-dark" addons="btn-lg" />

                                    <x-button id="10" icon="fa-solid fa-arrow-right fa-rotate-by"
                                        url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 30deg;"
                                        color="btn-dark" addons="btn-lg" />

                                </div>
                            </div>

                            <x-button id="11" icon="fa-solid fa-arrow-rotate-left" url="{{ route('log') }}"
                            color="btn-dark" addons="btn-lg" />

                        </div>

                    </div>

                </div>
              </div>
              <div class="carousel-item">
                <div class="col">
                    <h5 class="mb-3">Commandes de diagnostic</h5>
                    <x-button title="Test connectivité" id="1" icon="fa-solid fa-tower-cell"
                        url="{{ route('log') }}" />
                    <x-button title="Position du robot" id="3" icon="fa-solid fa-crosshairs"
                        url="{{ route('log') }}" addons="mt-2 mb-4" />
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>

    </div-->


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
