<li class="nav-header mt-2 badge text-bg-secondary">
    <span>ADMINISTRATION</span>
</li>

<ul class="nav nav-pills flex-column mb-auto gap-2 mt-none">
    <li class="nav-item">
        <a role="button" class="btn_tabs nav-link text-white @if ($_SERVER['REQUEST_URI'] == '/index') active @endif" href="{{ route('users') }}">

            <i class="fa-solid fa-users-gear bi pe-none me-1" width="16" height="16"></i>

            Gestion des utilisateurs
        </a>
    </li>
</ul>
