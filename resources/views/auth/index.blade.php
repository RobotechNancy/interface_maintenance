<x-app-layout>
    <x-slot name="title"> @lang('Users list') </x-slot>
    <h4 class="mb-2 ms-3">Liste des utilisateurs du site</h4>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 p-3">

        @foreach ($users as $user)
            <?php
            $role = '';
            switch ($user->role) {
                case 1:
                    $role = 'Editeur 🥈';
                    break;

                case 2:
                    $role = 'Administrateur 🥇';
                    break;

                default:
                    $role = 'Lecteur 🥉';
                    break;
            }
            ?>

            <div class="col">
                <div aria-hidden="true" class="card text-bg-dark border border-light border-opacity-25">
                    <div class="card-body">
                        <h5 class="card-title">
                            <span>{{ $user->name }}

                                @if(Cache::has('user-is-online-' . $user->email))
                                    <span class="text-success fs-6 ms-2 fst-italic"><small>En ligne</small></span>
                                @else
                                    <span class="text-danger fs-6 ms-2 fst-italic"><small>Déconnecté</small></span>
                                @endif


                                @if(Auth::user()->id == $user->id)
                                    <span class="badge rounded-pill ms-2 text-bg-info"><small>Mon compte</small></span>
                                @endif
                            </span>
                        </h5>
                        <h6 class="card-subtitle pt-2 text-muted">
                            <small>
                                <i class="fa-solid fa-circle-info"></i> Profil modifié le
                                {{ $user->updated_at->format('d/m/Y') }} à
                                {{ $user->updated_at->format('H:i:s') }}
                            </small>
                        </h6>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-bg-dark border border-white border-opacity-10"><i
                                class="fa-solid fa-id-card-clip pe-1"></i> Identifiant : {{ $user->id }}</li>
                        <li class="list-group-item text-bg-dark border border-white border-opacity-25"><i
                                class="fa-solid fa-at pe-1"></i> @lang('Email') : <a
                                href="mailto:{{ $user->email }}" class="text-white" style="text-decoration: none;">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item text-bg-dark border border-white border-opacity-10"><i
                                class="fa-solid fa-ranking-star pe-1"></i> @lang('Role') : {{ $role }}</li>
                    </ul>

                    @if (Auth::user()->role == 2 || $user->id == Auth::user()->id)
                        <div class="card-footer text-center m-2">
                            <a class="btn btn-sm btn-primary" href="{{ route('edit', ['id' => $user->id]) }}"><i
                                    class="fa-solid fa-pen-to-square"></i> Éditer <span class="d-none d-lg-inline">@if(Auth::user()->id == $user->id) mon @else le @endif profil</span></a>

                            <form id="delete{{ $user->id }}" action="{{ route('delete', ['user' => $user]) }}"
                                method="POST" style="display: none;">
                                @csrf
                            </form>

                            <a class="btn btn-sm btn-danger ms-2"
                                onclick="event.preventDefault(); document.getElementById('delete{{ $user->id }}').submit();"><i
                                    class="fa-solid fa-trash-can"></i> Supprimer <span class="d-none d-lg-inline">@if(Auth::user()->id == $user->id) mon compte @else l'utilisateur @endif</span></a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
</x-app-layout>
@if (session()->has('message'))
    <x-notification title="Suppression de profil" color="bg-danger">{{ session('message') }}</x-notification>
@endif
