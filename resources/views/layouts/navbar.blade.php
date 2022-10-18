<nav class="navbar is-link is-light is-spaced has-shadow" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-logo" href="/">
            <x-application-logo />
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-start">
            <div class="navbar-item">
                <div class="buttons ml-2">
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
                        <a class="button is-link is-outlined is-inverted" href="{{ route('users') }}">
                            <span class="icon">
                                <i class="fa-solid fa-users-gear"></i>
                            </span>
                            <span>@lang('Users list')</span>
                        </a>
                        <div class="dropdown is-hoverable is-right">
                            <div class="dropdown-trigger">
                              <button class="button is-link" aria-haspopup="true" aria-controls="dropdown-menu-user">
                                <span class="icon">
                                    <i class="fa-regular fa-id-badge"></i>
                                </span>
                                <span>{{ Auth::user()->name }}</span>
                                <span class="icon is-small">
                                  <i class="fas fa-angle-down" aria-hidden="true"></i>
                                </span>
                              </button>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu-user" role="menu">
                              <div class="dropdown-content">
                                <a href="{{ route('show') }}" class="dropdown-item">
                                    <i class="fa-solid fa-circle-user"></i> | @lang('Show my profile')
                                </a>
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
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i> | @lang('Logout')
                                    </a>
                                </form>
                              </div>
                            </div>
                        </div>
                    @else
                        <a class="button is-light" href="{{ route('login') }}">
                            @lang('Log in')
                        </a>
                        @if (Route::has('register'))
                            <a class="button is-link" href="{{ route('register') }}">@lang('Sign up')</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
      </div>
</nav>
