<li class="nav-header badge text-bg-secondary">
    <span>NAVIGATION</span>
</li>

@include("components.sidebar-navigation-item", ["id" => "console_logs",
                                                "beta" => false,
                                                "name" => "Console de logs",
                                                "icon" => "fa-solid fa-terminal",
                                                "main" => true])

@include("components.sidebar-navigation-item", ["id" => "connectivite",
                                                "beta" => true,
                                                "name" => "Connectivité",
                                                "icon" => "fa-solid fa-signal"])
