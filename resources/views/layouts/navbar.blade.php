<nav class="navbar is-link is-spaced has-shadow" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-logo" href="/">
            <x-application-logo />
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navBarMenu">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="navBarMenu" class="navbar-menu has-background-link">
        <div class="navbar-start">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-link" href="/">
                        <span class="icon">
                            <i class="fa-solid fa-house-chimney"></i>
                        </span>
                        <span>@lang('Home')</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    @auth
                        <a class="button is-link is-inverted" href="{{ url('/dashboard') }}">
                            <span class="icon">
                                <i class="fa-solid fa-terminal"></i>
                            </span>
                            <span>@lang('Dashboard')</span>
                        </a>

                        @if (Route::has('users'))
                        <a class="button is-link is-outlined is-inverted" href="{{ route('users') }}">
                            <span class="icon">
                                <i class="fa-solid fa-users-gear"></i>
                            </span>
                            <span>@lang('Users list')</span>
                        </a>
                        @endif
                        <div class="dropdown is-hoverable is-right">
                            <div class="dropdown-trigger">
                              <button class="button is-link" aria-haspopup="true" aria-controls="dropdown-menu-user">
                                <span class="icon">
                                    <?php if(Auth::user()->role == 2) echo "🥇"; else if(Auth::user()->role == 1) echo "🥈"; else echo "🥉"; ?>
                                </span>
                                <span>{{ Auth::user()->name }}</span>
                                <span class="icon is-small">
                                  <i class="fas fa-angle-down" aria-hidden="true"></i>
                                </span>
                              </button>
                            </div>

                            <div class="dropdown-menu" id="dropdown-menu-user" role="menu">
                              <div class="dropdown-content">
                                @if (Route::has('show'))
                                <a href="{{ route('show') }}" class="dropdown-item">
                                    <i class="fa-solid fa-circle-user"></i> | @lang('Show my profile')
                                </a>
                                @endif
                                <a href="{{ route('edit', ['id' => Auth::user()->id]) }}" class="dropdown-item">
                                    <i class="fa-solid fa-user-gear"></i> | @lang('Edit my profile')
                                </a>
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('delete', ['user' => Auth::user()]) }}">
                                    @csrf
                                    <a class="dropdown-item has-text-danger" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fa-solid fa-user-xmark"></i> | @lang('Delete my profile')
                                    </a>
                                </form>
                                @if (Route::has('logout'))
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i> | @lang('Logout')
                                    </a>
                                </form>
                                @endif
                              </div>
                            </div>
                        </div>
                    @else
                        @if (Route::has('login'))
                        <a class="button is-light" href="{{ route('login') }}">
                            <span class="icon">
                                <i class="fa-solid fa-right-to-bracket"></i>
                            </span>
                            <span>
                                @lang('Log in')
                            </span>
                        </a>
                        @endif
                        @if (Route::has('register'))
                            <a class="button is-link" href="{{ route('register') }}">
                                <span class="icon">
                                    <i class="fa-solid fa-user-plus"></i>
                                </span>
                                <span>
                                    @lang('Sign up')
                                </span>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
      </div>
</nav>
