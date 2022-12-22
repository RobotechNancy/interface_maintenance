<li class="nav-header mt-2 badge text-bg-secondary">
    <span>ADMINISTRATION</span>
</li>

<li class="nav-item">
    <a class="btn w-100 @if ($_SERVER['REQUEST_URI'] == '/index') btn-light @else btn-dark @endif"
        href="{{ route('users') }}">
        <span class="icon">
            <i class="fa-solid fa-users-gear"></i>
        </span>
        <span>Gestion des utilisateurs</span>
    </a>
</li>
