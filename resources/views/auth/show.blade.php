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
    <div class="box">
        <h1 class="title is-3">Mon profil</h1>
        <p><strong>Id :</strong> {{ $user->id }} </p>
        <p><strong>Nom :</strong> {{ $user->name }} </p>
        <p><strong>Email :</strong> {{ $user->email }} </p> 
        <p><strong>Rôle :</strong> {{ $role }} </p>
        <p><strong>Date de création du compte :</strong> {{ $user->created_at->format('d/m/Y H:m:s') }} </p>
        <p><strong>Dernière modification du compte :</strong> {{ $user->updated_at->format('d/m/Y H:m:s') }} </p>
    </div>
</x-app-layout>
