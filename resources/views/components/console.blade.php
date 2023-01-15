<div class="container tabs" id="tab_console_logs">
    <h5 class="mb-4">
        <div class="hstack gap-2 fw-bold">
            <span class="pe-2">Console de logs</span>

            @if (Auth::user()->role == 2)
                <x-button id="20" icon="fa-solid fa-eraser" url="{{ route('clearlogs') }}" color="btn-danger"
                    addons="btn-sm" />
            @endif

            @if (Auth::user()->role != 0)
            <x-button id="0" icon="fa-solid fa-file-export" url="{{ route('exportlogs') }}" addons="btn-sm" />
            @endif

            <a href="/logs.txt" target="_blank">
                <button class="btn btn-secondary btn-sm">
                    <span class="icon">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </button>
            </a>

            <button id="btn_reload_console" class="btn btn-info btn-sm btn_form">
                <span class="icon">
                    <i class="fa-solid fa-rotate"></i>
                </span>
            </button>
        </div>

        <p class="fs-6 mt-3 text-muted"><small><i class="fa-solid fa-circle-info"></i> Dernière mise à jour le <span id="maj_console_datetime">XX/XX/XXXX à xx:xx:xx</span></small></p>
    </h5>
    <div class="title_console"></div>
    <div id="logs_console" style="max-height: 70vh; overflow: scroll;">
        @if (count($logs) > 0)
            <div class="accordion accordion-flush mb-4" id="accordionConsole">
                @foreach ($logs as $log)
                    @include("components.log-item", ["element" => $log])
                @endforeach
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Aucun log pour le moment, veuillez sélectionner une action pour commencer.
            </div>
        @endif
    </div>
</div>
