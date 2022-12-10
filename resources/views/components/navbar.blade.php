<nav id="navbar"
    class="navbar navbar-expand navbar-dark bg-dark sticky-top border-bottom border-light border-opacity-25 rounded"
    style="z-index: 100;">

    <div class="container-fluid">

        <a class="navbar-brand" href="/">
            <img src="{{ asset('img/logo.png') }}" width="120">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBarMain"
            aria-controls="navBarMain" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navBarMain">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"></li>
            </ul>

            <ul class="navbar-nav mb-2 mb-lg-0 gap-2">

                @auth
                    <li class="nav-item">
                        <a class="btn btn-dark" href="{{ route('users') }}">
                            <span class="icon">
                                <i class="fa-solid fa-users-gear"></i>
                            </span>
                            <span class="">Utilisateurs</span>
                        </a>
                    </li>

                    <li class="nav-item d-none d-lg-inline">
                        <div class="dropdown">

                        <a type="button" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">

                            <span class="vstack ms-lg-5">

                                <span style="font-size:15px" class="text-white">
                                    {{ Auth::user()->name }}
                                </span>

                                <span style="font-size:11px;" class="text-white-50">
                                    {{ Auth::user()->email }}
                                </span>

                            </span>

                        </a>

                        </div>
                    </li>

                    <li class="nav-item">
                        <a type="button" data-bs-toggle="modal" data-bs-target="#modalUser"
                            class="btn btn-outline-secondary text-white fw-semibold">
                            <span>
                                <?php

                                $username = Auth::user()->name;
                                $initiales = strtoupper(substr($username, 0, 2));

                                ?>
                                {{ $initiales }}
                            </span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                          </ul>
                    </li>
                @else
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('login') }}">
                                <span class="icon">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                </span>
                                <span>
                                    @lang('Log in')
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-light" href="{{ route('register') }}">
                                <span class="icon">
                                    <i class="fa-solid fa-user-plus"></i>
                                </span>
                                <span>
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
