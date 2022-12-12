<li class="nav-header mt-2 badge text-bg-secondary">
    <span>BASE ROULANTE</span>
</li>

<label for="rangeDistance" class="form-label">Distance : <span id="valeurSliderDistance"></span> cm</label>
<input type="range" class="form-range" value="1" min="0" max="200" step="1" id="rangeDistance"
    onchange="changeValueRange(0)">

<label for="rangeVitesse" class="form-label">Vitesse : <span id="valeurSliderVitesse"></span> %</label>
<input type="range" class="form-range" value="50" min="0" max="100" step="1" id="rangeVitesse"
    onchange="changeValueRange(1)">

<div class="vstack gap-2">
    <div class="hstack gap-2">

        <x-button id="4" icon="fa-solid fa-arrow-rotate-right" url="{{ route('log') }}" color="btn-dark"
            addons="btn-sm" />

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

                <x-button id="10" icon="fa-solid fa-arrow-right fa-rotate-by" url="{{ route('log') }}"
                    iconstyle="--fa-rotate-angle: 30deg;" color="btn-dark" addons="btn-sm" />

            </div>
        </div>

        <x-button id="11" icon="fa-solid fa-arrow-rotate-left" url="{{ route('log') }}" color="btn-dark"
            addons="btn-sm" />

    </div>

</div>
