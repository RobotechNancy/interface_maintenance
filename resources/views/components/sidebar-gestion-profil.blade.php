<li class="nav-header mt-2 badge text-bg-secondary">
    <span>GESTION DU PROFIL</span>
</li>

<ul class="nav nav-pills flex-column mb-auto gap-2 mt-none">

    <li class="nav-item">
        <a role="button" class="btn_tabs nav-link text-white @if ($_SERVER["REQUEST_URI"] == "/edit/".Auth::user()->id) active @endif" href="{{ route('edit', ['id' => Auth::user()->id]) }}">

            <i class="fa-solid fa-pen-to-square bi pe-none me-1" width="16" height="16"></i>

            Éditer mon profil
        </a>
    </li>
</ul>
