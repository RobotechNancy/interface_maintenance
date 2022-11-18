<nav id="sidebar" class="nav flex-column position-fixed nav-pills bg-dark p-3 border border-light border-opacity-25 rounded top-0 d-none d-md-block vh-100" style="z-index:100;">

    <button class="btn btn-dark d-inline d-sm-none btn_sidebar"><i class="fa-solid fa-xmark"></i></button>
    @include('components.application-logo')

    <a class="nav-link bg-light text-dark active mt-3" href="/">
        <span class="icon">
            <i class="fa-solid fa-house-chimney"></i>
        </span>
        <span class="m-1 d-none d-md-inline">@lang('Home')</span>
    </a>
    <a class="nav-link bg-primary text-white active mt-3" href="{{ url('/dashboard') }}">
        <span class="icon">
            <i class="fa-solid fa-terminal"></i>
        </span>
        <span class="m-1 d-none d-md-inline">@lang('Dashboard')</span>
    </a>
</nav>
