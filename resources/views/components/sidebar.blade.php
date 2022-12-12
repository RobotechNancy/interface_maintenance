<nav id="sidebar"
    class="nav flex-column position-fixed nav-pills bg-dark p-2 border-end border-light border-opacity-25 d-none h-100 d-lg-block rounded"
    style="z-index:99; overflow: scroll;">

    <div class="d-grid gap-3 m-1">

        <a href="/" class="mb-4">
            <img src="{{ asset('img/logo.png') }}" width="120">
        </a>

        @if ($_SERVER["REQUEST_URI"] == "/dashboard")

            @include("components.sidebar-navigation")

            <!--@include("components.sidebar-batterie")-->

            @include("components.sidebar-base-roulante")
            @include("components.sidebar-commandes")

        @else

            <li class="nav-item">
                <a class="btn btn-primary w-100" href="{{ route('dashboard') }}">
                    <span class="icon">
                        <i class="fa-solid fa-arrow-left"></i>
                    </span>
                    <span>Tableau de bord</span>
                </a>
            </li>

            @include("components.sidebar-administration")
            @include("components.sidebar-gestion-profil")

        @endif
    </div>
</nav>
