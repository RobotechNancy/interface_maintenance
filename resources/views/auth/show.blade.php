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
        <h1 class="title is-3">Mon profil</h1>
        <ul>
            <li><strong>Id :</strong> {{ $user->id }} </li>
            <li><strong>Nom :</strong> {{ $user->name }} </li>
            <li><strong>Email :</strong> {{ $user->email }} </li>
            <li><strong>Rôle :</strong> {{ $role }} </li>
            <li><strong>Date de création du compte :</strong> le {{ $user->created_at->format("d/m/Y") }} à {{ $user->created_at->format("H:m:s") }} </li>
            <li><strong>Dernière modification du compte :</strong> le {{ $user->updated_at->format("d/m/Y") }} à {{ $user->updated_at->format("H:m:s") }} </li>
        </ul>
    </div>
</x-app-layout>
