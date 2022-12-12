<nav id="sidebar"
    class="nav flex-column position-fixed nav-pills bg-dark p-2 border-end border-light border-opacity-25 d-none d-lg-block min-vh-100 max-vh-100 rounded"
    style="z-index:99; overflow: scroll;">
    <div class="d-grid gap-3 m-1">

        <a href="/" class="mb-4">
            <img src="{{ asset('img/logo.png') }}" width="120">
        </a>

        <!--span class="nav-link bg-secondary text-white">Batterie <i class="fa-solid fa-car-battery"></i> <span class="badge text-bg-info">Beta</span></span>

        <div class="hstack gap-2" style="margin-left:10px;">
            <span class="badge text-dark bg-secondary">Cellule 1</span>
            <i class="text-success fa-solid fa-battery-three-quarters" style="font-size: 20px;"></i>
            <span class="badge text-dark bg-success">67%</span>
        </div>

        <div class="hstack gap-2" style="margin-left:10px;">
            <span class="badge text-dark bg-secondary">Cellule 2</span>
            <i class="text-danger fa-solid fa-battery-quarter" style="font-size: 20px;"></i>
            <span class="badge text-dark bg-danger">31%</span>
        </div>

        <div class="hstack gap-2" style="margin-left:10px;">
            <span class="badge text-dark bg-secondary">Cellule 3</span>
            <i class="text-warning fa-solid fa-battery-half" style="font-size: 20px;"></i>
            <span class="badge text-dark bg-warning">49%</span>
        </div>

        <div class="hstack gap-2" style="margin-left:10px;">
            <span class="badge text-dark bg-secondary">Cellule 4</span>
            <i class="text-success fa-solid fa-battery-full" style="font-size: 20px;"></i>
            <span class="badge text-dark bg-success">91%</span>
        </div>

        <div class="hstack gap-2" style="margin-left:10px;">
            <span class="badge text-dark bg-secondary">Cellule 5</span>
            <i class="text-danger fa-solid fa-battery-empty" style="font-size: 20px;"></i>
            <span class="badge text-dark bg-danger">8%</span>
        </div>

        <div class="hstack gap-2" style="margin-left:10px;">
            <span class="badge text-dark bg-secondary">Cellule 6</span>
            <i class="text-danger fa-solid fa-battery-quarter" style="font-size: 20px;"></i>
            <span class="badge text-dark bg-danger">33%</span>
        </div-->

        @if ($_SERVER["REQUEST_URI"] == "/dashboard")

        <a class="nav-link bg-success text-black">Base roulante <i class="fa-solid fa-map-location-dot"></i></a>

        <label for="rangeDistance" class="form-label">Distance : <span id="valeurSliderDistance"></span> cm</label>
        <input type="range" class="form-range" value="1" min="0" max="200" step="1"
            id="rangeDistance" onchange="changeValueRange(0)">

        <label for="rangeVitesse" class="form-label">Vitesse : <span id="valeurSliderVitesse"></span> %</label>
        <input type="range" class="form-range" value="50" min="0" max="100" step="1"
            id="rangeVitesse" onchange="changeValueRange(1)">

        <div class="vstack gap-2">
            <div class="hstack gap-2">

                <x-button id="4" icon="fa-solid fa-arrow-rotate-right" url="{{ route('log') }}"
                    color="btn-dark" addons="btn-sm" />

                <div class="vstack gap-2">

                    <div class="hstack gap-2">

                        <x-button id="5" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                            iconstyle="--fa-rotate-angle: 210deg;" color="btn-dark" addons="btn-sm" />

                        <x-button id="7" icon="fa-solid fa-arrow-up fa-rotate-by" url="{{ route('log') }}"
                            color="btn-dark" addons="btn-sm" />


                        <x-button id="9" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                            iconstyle="--fa-rotate-angle: 330deg;" color="btn-dark" addons="btn-sm" />

                    </div>

                    <div class="hstack gap-2">

                        <x-button id="6" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                            iconstyle="--fa-rotate-angle: 150deg;" color="btn-dark" addons="btn-sm" />
                        <x-button id="8" icon="fa-solid fa-arrow-down fa-rotate-by" url="{{ route('log') }}"
                            color="btn-dark" addons="btn-sm" />

                        <x-button id="10" icon="fa-solid fa-arrow-right fa-rotate-by"
                            url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 30deg;" color="btn-dark"
                            addons="btn-sm" />

                    </div>
                </div>

                <x-button id="11" icon="fa-solid fa-arrow-rotate-left" url="{{ route('log') }}"
                    color="btn-dark" addons="btn-sm" />

            </div>

        </div>

        <a class="nav-link bg-primary text-black">Commandes <i class="fa-solid fa-gamepad"></i></a>

        <div class="vstack gap-2">
            <x-button title="Test connectivité" id="1" icon="fa-solid fa-tower-cell"
                url="{{ route('log') }}" addons="btn-outlined" />

            <x-button title="Position du robot" id="3" icon="fa-solid fa-crosshairs"
                url="{{ route('log') }}" />
        </div>

        @else

        <li class="nav-item">
            <a class="btn btn-primary w-100" href="{{ route('dashboard') }}">
                <span class="icon">
                    <i class="fa-solid fa-arrow-left"></i>
                </span>
                <span>Tableau de bord</span>
            </a>
        </li>

        <li class="nav-header mt-2 badge text-bg-secondary">
            <span>ADMINISTRATION</span>
        </li>

        <li class="nav-item">
            <a class="btn w-100 @if ($_SERVER["REQUEST_URI"] == "/index") btn-light @else btn-outline-light @endif" href="{{ route('users') }}">
                <span class="icon">
                    <i class="fa-solid fa-users-gear"></i>
                </span>
                <span>Gestion des utilisateurs</span>
            </a>
        </li>

        <li class="nav-header mt-2 badge text-bg-secondary">
            <span>GESTION DU PROFIL</span>
        </li>

        <li class="nav-item">
            <a class="btn w-100 @if ($_SERVER["REQUEST_URI"] == "/edit/".Auth::user()->id) btn-light @else btn-outline-light @endif" href="{{ route('edit', ['id' => Auth::user()->id]) }}">
                <span class="icon">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
                <span>Éditer mes informations</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="btn w-100 btn-outline-warning" href="{{ route('logout') }}">
                <span class="icon">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </span>
                <span>Fermer ma session</span>
            </a>
        </li>

        <li class="nav-item">
            <form method="POST" action="{{ route('delete', ['user' => Auth::user()]) }}" class="d-none" id="form_my_delete">
                @csrf
            </form>

            <a class="btn w-100 btn-outline-danger" onclick="event.preventDefault(); $('#form_my_delete').submit();">
                <span class="icon">
                    <i class="fa-solid fa-trash-can"></i>
                </span>
                <span>@lang('Delete my profile')</span>
            </a>
        </li>

        @endif
    </div>
</nav>
