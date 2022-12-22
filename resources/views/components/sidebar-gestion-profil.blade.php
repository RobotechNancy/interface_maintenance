<li class="nav-header mt-2 badge text-bg-secondary">
    <span>GESTION DU PROFIL</span>
</li>

<li class="nav-item">
    <a class="btn w-100 @if ($_SERVER["REQUEST_URI"] == "/edit/".Auth::user()->id) btn-light @else btn-dark @endif" href="{{ route('edit', ['id' => Auth::user()->id]) }}">
        <span class="icon">
            <i class="fa-solid fa-pen-to-square"></i>
        </span>
        <span>Éditer mes informations</span>
    </a>
</li>

<li class="nav-item">
    <a class="btn w-100 btn-warning" href="{{ route('logout') }}">
        <span class="icon">
            <i class="fa-solid fa-right-from-bracket"></i>
        </span>
        <span>Fermer ma session</span>
    </a>
</li>

<li class="nav-item">
    <form method="POST" action="{{ route('delete', ['user' => Auth::user()]) }}" class="d-none" id="form_my_delete">
        @csrf
    </form>

    <a class="btn w-100 btn-danger" onclick="event.preventDefault(); $('#form_my_delete').submit();">
        <span class="icon">
            <i class="fa-solid fa-trash-can"></i>
        </span>
        <span>@lang('Delete my profile')</span>
    </a>
</li>
