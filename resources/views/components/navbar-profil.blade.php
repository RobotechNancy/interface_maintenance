<li class="nav-item">
    <div class="dropstart">

        <a type="button" data-bs-toggle="dropdown" aria-expanded="false"
            style="text-decoration: none;">

            <span class="hstack">
                <span class="vstack ms-lg-3">

                    <span style="font-size:15px" class="d-none d-lg-inline text-white">
                        {{ Auth::user()->name }}
                    </span>

                    <span style="font-size:11px;" class="d-none d-lg-inline text-white-50">
                        {{ Auth::user()->email }}
                    </span>

                </span>


                <span class="border border-white rounded p-1 ps-2 pe-2 ms-3 text-white">
                    {{ $initiales }}
                </span>
            </span>

        </a>

        <ul class="dropdown-menu dropdown-menu-dark position-absolute mt-5 end-0">
            <li>
                <h4 class="dropdown-header fs-5 text-white">{{ Auth::user()->name }}<br>
                    <span class="fs-6 text-white-50">{{ Auth::user()->email }}</span>
                </h4>
            </li>
            <li><a class="dropdown-item disabled"><span class="badge rounded-pill text-bg-info">{{ $role }}</span></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item btn" href="{{ route('dashboard') }}"><i class="fa-solid fa-map-location-dot"></i> Tableau de bord</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item btn" href="{{ route('edit', ['id' => Auth::user()->id]) }}"><i class="fa-solid fa-user-gear"></i> Gestion du profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout">
                @csrf
            </form>
            <li><a class="dropdown-item disabled"><a role="button" class="d-grid btn btn-warning me-2 ms-2 mb-1" onclick="event.preventDefault(); $('#logout').submit();">Se déconnecter</a></a></li>
        </ul>

    </div>
</li>
