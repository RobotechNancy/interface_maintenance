<nav id="sidebar" class="nav flex-column position-fixed nav-pills bg-dark p-3 border border-light border-opacity-25 rounded d-none d-lg-block" style="z-index:100; overflow: scroll;">
    <div class="d-grid gap-3 m-3">

        <!--span class="nav-link bg-secondary text-white">Batterie <i class="fa-solid fa-car-battery"></i> <span class="badge text-bg-info">Beta</span></span>

        <button class="btn btn-light btn-sm d-lg-none btn_sidebar mb-3 position-absolute end-0 top-0"><i class="fa-solid fa-xmark"></i></button>

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

        <a class="nav-link bg-warning text-black mt-3">Alimentation <i class="fa-solid fa-plug-circle-bolt"></i></a>

        <x-button title="OFF" id="12" url="{{ route('log') }}" icon="fa-solid fa-toggle-off" addons="btn-danger"/>

        <a class="nav-link bg-success text-black mt-3">Base roulante <i class="fa-solid fa-map-location-dot"></i></a>

	<label for="rangeDistance" class="form-label">Distance : <span id="valeurSliderDistance"></span> cm</label>
	<input type="range" class="form-range" value="1" min="0" max="200" step="1" id="rangeDistance" onchange="changeValueRange(0)">

	<label for="rangeVitesse" class="form-label">Vitesse : <span id="valeurSliderVitesse"></span> %</label>
	<input type="range" class="form-range" value="50" min="0" max="100" step="1" id="rangeVitesse" onchange="changeValueRange(1)">

	<div class="vstack gap-2">
            <div class="hstack gap-2">

                <x-button id="4" icon="fa-solid fa-arrow-rotate-right"
                    url="{{ route('log') }}" color="btn-dark" addons="btn-sm" />

                <div class="vstack gap-2">

                    <div class="hstack gap-2">

                        <x-button id="5" icon="fa-solid fa-arrow-right fa-rotate-by"
                            url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 210deg;"
                            color="btn-dark" addons="btn-sm" />

                        <x-button id="7" icon="fa-solid fa-arrow-up fa-rotate-by"
                            url="{{ route('log') }}" color="btn-dark" addons="btn-sm" />


                        <x-button id="9" icon="fa-solid fa-arrow-right fa-rotate-by"
                            url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 330deg;"
                            color="btn-dark" addons="btn-sm" />

                    </div>

                    <div class="hstack gap-2">

                        <x-button id="6" icon="fa-solid fa-arrow-right fa-rotate-by"
                            url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 150deg;"
                            color="btn-dark" addons="btn-sm" />
                        <x-button id="8" icon="fa-solid fa-arrow-down fa-rotate-by"
                            url="{{ route('log') }}" color="btn-dark" addons="btn-sm" />

                        <x-button id="10" icon="fa-solid fa-arrow-right fa-rotate-by"
                            url="{{ route('log') }}" iconstyle="--fa-rotate-angle: 30deg;"
                            color="btn-dark" addons="btn-sm" />

                    </div>
                </div>

                <x-button id="11" icon="fa-solid fa-arrow-rotate-left" url="{{ route('log') }}"
                color="btn-dark" addons="btn-sm" />

            </div>

        </div>

        <a class="nav-link bg-primary text-black">Commandes <i class="fa-solid fa-gamepad"></i></a>

        <x-button title="Test connectivité" id="1" icon="fa-solid fa-tower-cell"
        url="{{ route('log') }}" addons="btn-sm"/>
        <x-button title="Position du robot" id="3" icon="fa-solid fa-crosshairs"
        url="{{ route('log') }}" addons="btn-sm"/>

    </div>
</nav>
