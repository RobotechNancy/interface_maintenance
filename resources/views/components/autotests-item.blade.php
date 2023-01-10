<div class="col">
    <div class="card h-100 card text-bg-dark border border-light border-opacity-25">
        <div class="text-center">
            <img src="{{ $img }}" class="rounded mt-4 mb-3" style="max-width: 180px; max-height: 120px">
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $title }}</h5>

            @if (Auth::user()->role != 0)

                @if (isset($btn_title) && isset($carte_id))
                    <x-button title="{{ $btn_title }}" icon="fa-solid fa-plug-circle-bolt" id="{{ $carte_id }}" url="{{ route('log') }}"/>
                @endif

            @endif
        </div>

        @isset($carte_id)
            <div class="card-footer border-light border-opacity-25">
                <p class="mt-2">Accès à la carte : <span class="badge text-bg-secondary" id="access_autotest_carte_{{ $carte_id }}">Inconnu <i class="fa-solid fa-question"></i></span></p>

                @isset($config)
                    @if($config)
                        <p>Configuration de la carte : <span class="badge text-bg-secondary" id="config_autotest_carte_{{ $carte_id }}">Inconnue <i class="fa-solid fa-question"></i></span></p>
                    @endif
                @endisset

                <p>Réponse de la carte : <span class="badge text-bg-secondary" id="response_autotest_carte_{{ $carte_id }}">Inconnue <i class="fa-solid fa-question"></i></span></p>
                <small class="text-muted"><i class="fa-solid fa-circle-info"></i> Dernier test le <span id="date_autotest_carte_{{ $carte_id }}">XX/XX/XXX à xx:xx:xx</span></small>
            </div>
        @endisset
    </div>
</div>
