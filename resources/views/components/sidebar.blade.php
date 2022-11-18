<nav id="sidebar" class="nav flex-column position-fixed nav-pills bg-dark p-3 border border-light border-opacity-25 rounded d-none d-md-block vh-100" style="z-index:100;">

    <button class="btn btn-light d-inline d-sm-none btn_sidebar mb-3"><i class="fa-solid fa-xmark"></i></button>

    <div class="d-grid gap-3">

        <a class="nav-link bg-dark text-white">Commandes</a>

        <x-button title="Test connectivité" id="1" icon="fa-solid fa-tower-cell"
        url="{{ route('log') }}"/>
        <x-button title="Position du robot" id="3" icon="fa-solid fa-crosshairs"
        url="{{ route('log') }}" />

        <a class="nav-link bg-dark text-white">Alimentation</a>

        <div class="hstack gap-3">
            <x-button title="On" id="12" url="{{ route('log') }}" />
            <x-button title="Off" id="13" url="{{ route('log') }}"/>
        </div>

    </div>
</nav>
