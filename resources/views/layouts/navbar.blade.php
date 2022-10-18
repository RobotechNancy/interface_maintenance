<nav class="navbar is-light is-spaced has-shadow" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-logo" href="/">
            <x-application-logo />
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-start">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-light is-inverted is-outlined" href="/">@lang('Home')</a>
                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    @auth
                        <a class="button is-link" href="{{ url('/dashboard') }}">@lang('Dashboard')</a>
                        <a class="button is-link is-outlined" href="{{ route('users') }}">@lang('Users list')</a>
                        <div class="dropdown is-hoverable is-right">
                            <div class="dropdown-trigger">
                              <button class="button" aria-haspopup="true" aria-controls="dropdown-menu-user">
                                <span>{{ Auth::user()->name }}</span>
                                <span class="icon is-small">
                                  <i class="fas fa-angle-down" aria-hidden="true"></i>
                                </span>
                              </button>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu-user" role="menu">
                              <div class="dropdown-content">
                                <a href="{{ route('show') }}" class="dropdown-item">
                                    @lang('Show my profile')
                                </a>
                                <a href="{{ route('edit', ['id' => Auth::user()->id]) }}" class="dropdown-item">
                                    @lang('Edit my profile')
                                </a>
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                        @lang('Logout')
                                    </a>
                                </form>
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('delete', ['user' => Auth::user()]) }}">
                                    @csrf
                                    <a class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                        @lang('Delete profile')
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
