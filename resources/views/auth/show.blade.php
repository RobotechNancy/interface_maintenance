<x-app-layout>
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
    <x-slot name="title"> @lang('My profile') </x-slot>


    <h4 class="mb-5"><x-button-back />Affichage de mon profil <i class="fa-regular fa-address-card"></i></h4>

    <dl class="row">
        <dt class="col-sm-3">ID</dt>
        <dd class="col-sm-9">{{ $user->id }}</dd>

        <hr>

        <dt class="col-sm-3">@lang('Name')</dt>
        <dd class="col-sm-9">{{ $user->name }}</dd>

        <hr>

        <dt class="col-sm-3">@lang('Email')</dt>
        <dd class="col-sm-9">{{ $user->email }}</dd>

        <hr>

        <dt class="col-sm-3">Création du compte</dt>
        <dd class="col-sm-9">le {{ $user->created_at->format('d/m/Y') }} à
            {{ $user->created_at->format('H:i:s') }}</dd>

        <hr>

        <dt class="col-sm-3">Dernière modification du compte</dt>
        <dd class="col-sm-9">le {{ $user->updated_at->format('d/m/Y') }} à
            {{ $user->updated_at->format('H:i:s') }}</dd>

        <hr>

        <dt class="col-sm-3">@lang('Role')</dt>
        <dd class="col-sm-9">{{ $role }}</dd>

        <hr>
    </dl>
    <div class="d-grid d-md-block mt-3" role="group">
        <a class="btn btn-primary" href="{{ route('edit', ['id' => Auth::user()->id]) }}">
            <span>@lang('Edit my profile')</span>
            <span class="icon">
                <i class="fa-solid fa-pencil"></i>
            </span>
        </a>
        <a class="btn btn-danger"
            onclick="event.preventDefault(); document.getElementById('delete{{ Auth::user()->id }}').submit();">
            <span>@lang('Delete my profile')</span>
            <span class="icon">
                <i class="fa-regular fa-trash-can"></i>
            </span>
        </a>
    </div>

    <form id="delete{{ Auth::user()->id }}" action="{{ route('delete', ['user' => Auth::user()]) }}"
        method="POST" style="display: none;">
        @csrf
    </form>
</x-app-layout>
