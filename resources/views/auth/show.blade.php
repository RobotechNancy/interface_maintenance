<x-app-layout>
    <?php
        $role = "";
        switch ($user->role) {
            case 1:
                $role = "Editeur";
                break;

            case 2:
                $role = "Administrateur";
                break;

            default:
                $role = "Lecteur";
                break;
        }
    ?>
    <x-slot name="title"> @lang('My profile') </x-slot>
    <div class="box content">
        <nav class="level">
            <div class="level-item has-text-centered mb-6">
                <h1 class="title is-4">Affichage de mon profil <i class="fa-regular fa-address-card"></i></h1>
            </div>
        </nav>
        <hr>
        <nav class="level mb-6">
            <div class="level-item has-text-centered">
              <div>
                <p class="heading">ID</p>
                <p class="title is-5">{{ $user->id }}</p>
              </div>
            </div>
            <div class="level-item has-text-centered">
              <div>
                <p class="heading">@lang('Name')</p>
                <p class="title is-5">{{ $user->name }}</p>
              </div>
            </div>
            <div class="level-item has-text-centered">
              <div>
                <p class="heading">@lang('Email')</p>
                <p class="title is-5">{{ $user->email }}</p>
              </div>
            </div>
            <div class="level-item has-text-centered">
              <div>
                <p class="heading">Création du compte</p>
                <p class="title is-5">le {{ $user->created_at->format("d/m/Y") }} à {{ $user->created_at->format("H:i:s") }}</p>
              </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                  <p class="heading">Dernière modification du compte</p>
                  <p class="title is-5">le {{ $user->updated_at->format("d/m/Y") }} à {{ $user->updated_at->format("H:i:s") }}</p>
                </div>
              </div>
              <div class="level-item has-text-centered">
                <div>
                  <p class="heading">Rôle</p>
                  <p class="title is-5">{{ $role }} <?php if($user->role == 2) echo "🥇"; else if($user->role == 1) echo "🥈"; else echo "🥉"; ?></p>
                </div>
              </div>
        </nav>
        <hr>
        <nav class="level">
            <div class="level-item has-text-right mt-6">
                <div>
                    <a class="button is-link" href="{{ route('edit', ['id' => Auth::user()->id]) }}">
                        <span>@lang('Edit my profile')</span>
                        <span class="icon">
                            <i class="fa-solid fa-pencil"></i>
                        </span>
                    </a>
                    <form id="delete{{ Auth::user()->id }}" action="{{ route('delete', ['user' => Auth::user()]) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="button is-danger ml-5" onclick="event.preventDefault(); document.getElementById('delete{{ Auth::user()->id }}').submit();">
                        <span>@lang('Delete my profile')</span>
                        <span class="icon">
                            <i class="fa-regular fa-trash-can"></i>
                        </span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</x-app-layout>
