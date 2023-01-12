<nav id="sidebar"
    class="nav flex-column position-fixed nav-pills bg-dark p-2 border-end border-light border-opacity-25 d-none h-100 d-lg-block rounded"
    style="z-index:99; overflow: scroll;">

    <div class="d-grid gap-3 m-1">

        <a href="/" class="mb-4">
            <img src="img/logo.png" width="120">
        </a>

        @if ($_SERVER["REQUEST_URI"] == "/dashboard")

            @include("components.sidebar-navigation")

            <!--@include("components.sidebar-batterie")-->

            @if (Auth::user()->role == 2)

                @include("components.sidebar-base-roulante")

                <!--@include("components.sidebar-commandes")-->

            @endif

        @else

            <ul class="nav nav-pills flex-column mb-auto gap-2 mt-none">
                <li class="nav-item">
                    <a role="button" class="btn_tabs nav-link text-bg-light" href="{{ route('dashboard') }}">

                        <i class="fa-solid fa-arrow-left bi pe-none me-1" width="16" height="16"></i>

                        Tableau de bord
                    </a>
                </li>
            </ul>

            @if (Auth::user()->role == 2)
                @include("components.sidebar-administration")
            @else
                @include("components.sidebar-navigation")
            @endif

            @include("components.sidebar-gestion-profil")

        @endif
    </div>
</nav>
