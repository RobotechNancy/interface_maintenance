<li class="nav-header badge text-bg-secondary">
    <span>NAVIGATION</span>
</li>

<ul class="nav nav-pills flex-column mb-auto gap-2">

@if($_SERVER["REQUEST_URI"] == "/dashboard")

@include("components.sidebar-navigation-item", ["id" => "console_logs",
                                                "name" => "Console de logs",
                                                "icon" => "fa-solid fa-terminal",
                                                "main" => true])

@include("components.sidebar-navigation-item", ["id" => "connectivite",
                                                "name" => "Connectivité",
                                                "icon" => "fa-solid fa-signal"])

@include("components.sidebar-navigation-item", ["id" => "services",
                                                "name" => "État des services",
                                                "icon" => "fa-solid fa-microchip"])


@elseif(Auth::user()->role != 2)

<ul class="nav nav-pills flex-column mb-auto gap-2 mt-none">
    <li class="nav-item">
        <a role="button" class="btn_tabs nav-link text-white @if ($_SERVER['REQUEST_URI'] == '/index') active @endif" href="{{ route('users') }}">

            <i class="fa-solid fa-users bi pe-none me-1" width="16" height="16"></i>

            Liste des utilisateurs
        </a>
    </li>
</ul>

@endif

</ul>
