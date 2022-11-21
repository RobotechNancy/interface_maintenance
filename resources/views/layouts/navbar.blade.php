<nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border border-light border-opacity-25 rounded">
    <div class="container-fluid">
        <a class="navbar-brand mb-2" href="/">
            <img src="{{ asset('img/logo.png') }}" width="130">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBarMain"
            aria-controls="navBarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navBarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?php if (Auth::user()->role == 2) {
                                echo '🥇';
                            } elseif (Auth::user()->role == 1) {
                                echo '🥈';
                            } else {
                                echo '🥉';
                            } ?>

                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            @if (Route::has('show'))
                                <a href="{{ route('show') }}" class="dropdown-item">
                                    @lang('Show my profile')
                                </a>
                            @endif
                            <a href="{{ route('edit', ['id' => Auth::user()->id]) }}" class="dropdown-item">
                                @lang('Edit my profile')
                            </a>
                            <hr class="dropdown-divider">
                            <form method="POST" action="{{ route('delete', ['user' => Auth::user()]) }}">
                                @csrf
                                <a href="" class="dropdown-item text-danger"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    @lang('Delete my profile')
                                </a>
                            </form>
                            @if (Route::has('logout'))
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="" class="dropdown-item"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        @lang('Logout')
                                    </a>
                                </form>
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item active">
                        <a class="btn btn-primary" href="{{ url('/dashboard') }}">
                            <span class="icon">
                                <i class="fa-solid fa-terminal"></i>
                            </span>
                            <span>@lang('Dashboard')</span>
                        </a>
                    </li>

                    @if (Route::has('users'))
                        <li class="nav-item">
                            <a class="btn btn-light" href="{{ route('users') }}">
                                <span class="icon">
                                    <i class="fa-solid fa-users-gear"></i>
                                </span>
                                <span>@lang('Users list')</span>
                            </a>
                        </li>
                    @endif

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
                </div>
            </ul>
            @endauth
        </div>
    </div>
</nav>
