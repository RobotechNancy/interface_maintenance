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
