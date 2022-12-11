<nav id="navbar"
    class="navbar navbar-expand navbar-dark bg-dark sticky-top border-bottom border-light border-opacity-25 rounded"
    style="z-index: 100;">

    <div class="container-fluid">

        <a class="navbar-brand d-none d-lg-inline" href="/">
            <img src="{{ asset('img/logo.png') }}" width="120">
        </a>

        <a class="navbar-brand d-inline d-lg-none" href="/">
            <img src="{{ asset('img/logo_court_couleur.jpg') }}" width="50">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBarMain"
            aria-controls="navBarMain" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navBarMain">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item">
                        <x-button title="OFF" id="12" url="{{ route('log') }}" icon="fa-solid fa-toggle-off" addons="btn-danger"/>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav mb-2 mb-lg-0 gap-2">
                @auth
                    @if ($_SERVER["REQUEST_URI"] == "/dashboard")

                    <li class="nav-item">
                        <a class="btn btn-light" href="{{ route('users') }}">
                            <span class="icon">
                                <i class="fa-solid fa-users-gear"></i>
                            </span>
                            <span class="d-none d-lg-inline">Administration</span>
                        </a>
                    </li>

                    @endif

                    <li class="nav-item">
                        <div class="dropstart">

                            <a type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                style="text-decoration: none;">

                                <span class="hstack">
                                    <span class="vstack ms-lg-3">

                                        <span style="font-size:15px" class="d-none d-lg-inline text-white">
                                            {{ Auth::user()->name }}
                                        </span>

                                        <span style="font-size:11px;" class="d-none d-lg-inline text-white-50">
                                            {{ Auth::user()->email }}
                                        </span>

                                    </span>


                                    <span class="border border-white rounded p-1 ps-2 pe-2 ms-3 text-white">
                                        {{ $initiales }}
                                    </span>
                                </span>

                            </a>

                            <ul class="dropdown-menu dropdown-menu-dark position-absolute mt-5 end-0">
                                <li>
                                    <h4 class="dropdown-header fs-5 text-white">{{ Auth::user()->name }}<br>
                                        <span class="fs-6 text-white-50">{{ Auth::user()->email }}</span>
                                    </h4>
                                </li>
                                <li><a class="dropdown-item disabled"><span class="badge rounded-pill text-bg-info">{{ $role }}</span></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item btn" href="{{ route('edit', ['id' => Auth::user()->id]) }}"><i class="fa-solid fa-user-gear"></i> Gestion du profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout">
                                    @csrf
                                </form>
                                <li><a class="dropdown-item disabled"><a role="button" class="d-grid btn btn-warning me-2 ms-2 mb-1" onclick="event.preventDefault(); $('#logout').submit();">Se déconnecter</a></a></li>
                            </ul>

                        </div>
                    </li>
                @else
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('login') }}">
                                <span class="icon">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                </span>
                                <span class="d-none d-lg-inline">
                                    @lang('Log in')
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-dark" href="{{ route('register') }}">
                                <span class="icon">
                                    <i class="fa-solid fa-user-plus"></i>
                                </span>
                                <span class="d-none d-lg-inline">
                                    @lang('Sign up')
                                </span>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>
