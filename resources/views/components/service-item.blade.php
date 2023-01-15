<div class="col">
    <div class="card h-100 card text-bg-dark border border-light border-opacity-25">
        <div class="card-body">
            <h5 class="card-title">{{ $title }}</h5>
            <p class="card-text">{{ $text }}</p>

            @if (isset($btn_title) && isset($btn_id))
                <button class="btn btn-primary btn_form" onclick="processTestServices({{ $btn_id }})">{{ $btn_title }} <i class="fa-solid fa-plug-circle-bolt"></i></button>
            @endif
        </div>

        <div class="card-footer border-light border-opacity-25">
            <p class="mt-2">Route utilisée : <span class="badge text-bg-info">{{ $route }}</span></p>
            <p>Disponibilité : <span class="badge text-bg-secondary" id="dispo_test_service_{{ $btn_id }}">Inconnue <i class="fa-solid fa-question"></i></span></p>
            <p>Fonctionnement : <span class="badge text-bg-secondary" id="result_test_service_{{ $btn_id }}">Inconnu <i class="fa-solid fa-question"></i></span></p>
            <small class="text-muted"><i class="fa-solid fa-circle-info"></i> Dernier test le <span id="date_test_service_{{ $btn_id }}">XX/XX/XXX à xx:xx:xx</span></small>
        </div>
    </div>
</div>
