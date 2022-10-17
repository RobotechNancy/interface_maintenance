<nav class="navbar is-light is-spaced has-shadow" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="/">
            <x-application-logo />
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-start">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-light" href="/">@lang('Home')</a>
                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    @auth
                        <a class="button is-link" href="{{ url('/dashboard') }}">@lang('Dashboard')</a>
                        <div class="dropdown is-hoverable">
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
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                        @lang('Logout')
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
