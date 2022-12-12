<nav id="navbar"
    class="navbar navbar-expand navbar-dark bg-dark sticky-top border-bottom border-light border-opacity-25 rounded"
    style="z-index: 100;">

    <div class="container-fluid">

        @if ($_SERVER["REQUEST_URI"] != "/dashboard" && $_SERVER["REQUEST_URI"] != "/")

            <a role="button" onclick="history.go(-1)" class="text-white fs-5 d-inline d-lg-none">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </a>

        @endif

        @auth

            <button class="btn btn-dark d-inline d-lg-none btn_sidebar fs-5"><i class="fa-solid fa-bars"></i></button>

        @endauth

        <a class="navbar-brand d-none d-lg-inline" href="/">
            <img src="{{ asset('img/logo.png') }}" width="120">
        </a>

        <a class="navbar-brand d-inline d-lg-none" href="/">
            <img src="{{ asset('img/logo_court_couleur.jpg') }}" width="50">
        </a>

        <div class="collapse navbar-collapse">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                @auth
                    @if (Auth::user()->role != 0)
                        <li class="nav-item">
                            <x-button id="12" url="{{ route('log') }}" icon="fa-solid fa-power-off" addons="btn-danger"/>
                        </li>
                    @endif
                @endauth

            </ul>

            <ul class="navbar-nav mb-2 mb-lg-0 gap-2">
                @auth

                    @if ($_SERVER["REQUEST_URI"] == "/dashboard" && (Auth::user()->role == 2))

                        <li class="nav-item">
                            <a class="btn btn-light" href="{{ route('users') }}">
                                <span class="icon">
                                    <i class="fa-solid fa-users-gear"></i>
                                </span>
                                <span class="d-none d-lg-inline">Administration</span>
                            </a>
                        </li>

                    @endif

                    @include("components.navbar-profil")

                @else

                    @include("components.navbar-guest")

                @endauth
            </ul>
        </div>
    </div>
</nav>
