<x-app-layout>
    <x-slot name="title"> @lang('Users list') </x-slot>
    <h4 class="mb-5">Liste des utilisateurs du site</h4>
    <div class="table-responsive">
    <table class="table table-dark table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Création</th>
                <th>Modification</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($users as $user)
                <?php
                $role = '';
                switch ($user->role) {
                    case 1:
                        $role = 'Editeur';
                        break;

                    case 2:
                        $role = 'Administrateur';
                        break;

                    default:
                        $role = 'Lecteur';
                        break;
                }
                ?>
                <tr>
                    <td><b>{{ $user->id }}</b></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $role }} <?php if ($user->role == 2) {
                        echo '🥇';
                    } elseif ($user->role == 1) {
                        echo '🥈';
                    } else {
                        echo '🥉';
                    } ?></td>
                    <td>le {{ $user->created_at->format('d/m/Y') }} à {{ $user->created_at->format('H:i:s') }}</td>
                    <td>le {{ $user->updated_at->format('d/m/Y') }} à {{ $user->updated_at->format('H:i:s') }}</td>
                    <td>
                        <?php if(Auth::user()->role == 2 || $user->id == Auth::user()->id) { ?>
                        <a class="btn btn-dark" href="{{ route('edit', ['id' => $user->id]) }}"><i
                                class="fa-solid fa-pencil"></i></a>
                        <form id="delete{{ $user->id }}" action="{{ route('delete', ['user' => $user]) }}"
                            method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="btn btn-danger"
                            onclick="event.preventDefault(); document.getElementById('delete{{ $user->id }}').submit();"><i
                                class="fa-solid fa-trash"></i></a>
                        <?php } ?>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</x-app-layout>
@if (session()->has('message'))
    <x-notification title="Suppression de profil" color="is-danger">{{ session('message') }}</x-notification>
@endif
