<x-app-layout>
    <x-slot name="title"> @lang('Users list') </x-slot>
    <h1 class="title is-4">Liste des utilisateurs du site</h1>
    <table class="table mt-5 is-fullwidth is-striped is-hoverable is-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Création du compte</th>
                <th>Dernière modification du compte</th>
                <th>Actions</th>
              </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
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
            <tr <?php if($user->id == Auth::user()->id) echo "class=\"is-selected\""; ?>>
                <th>{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $role }}</td>
                <td>le {{ $user->created_at->format("d/m/Y") }} à {{ $user->created_at->format("H:m:s") }}</td>
                <td>le {{ $user->updated_at->format("d/m/Y") }} à {{ $user->updated_at->format("H:m:s") }}</td>
                <td>
                    <?php if(Auth::user()->role == 2 || $user->id == Auth::user()->id) { ?>
                        <a class="button is-link" href="{{ route('edit', ['id' => $user->id]) }}"><i class="fa-solid fa-pencil"></i></a>
                        <a class="button is-danger" href="{{ url('/dashboard') }}"><i class="fa-regular fa-trash-can"></i></a>
                    <?php } ?>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
@if (session()->has('message'))
<x-notification title="Suppression de profil" color="is-danger">{{ session('message') }}</x-notification>
@endif
