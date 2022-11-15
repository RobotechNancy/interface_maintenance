<x-app-layout>
    <x-slot name="title"> @lang('Users list') </x-slot>
    <h4 class="mb-5">Liste des utilisateurs du site</h4>

    <div class="row row-cols-1 row-cols-md-3 g-4">

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
                <div class="card text-bg-dark h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}
                            @if (Auth::user()->role == 2 || $user->id == Auth::user()->id)

                                <a class="btn btn-sm btn-primary" href="{{ route('edit', ['id' => $user->id]) }}"><i
                                        class="fa-solid fa-pencil"></i></a>

                                <form id="delete{{ $user->id }}" action="{{ route('delete', ['user' => $user]) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                </form>

                                <a class="btn btn-sm btn-danger"
                                    onclick="event.preventDefault(); document.getElementById('delete{{ $user->id }}').submit();"><i
                                    class="fa-solid fa-trash"></i></a>

                            @endif
                        </h5>
                        <p class="card-text mt-3">
                            <dl class="row">
                                <dt class="col-sm-3">ID</dt>
                                <dd class="col-sm-9">{{ $user->id }}</dd>

                                <hr>

                                <dt class="col-sm-3">@lang('Email')</dt>
                                <dd class="col-sm-9">{{ $user->email }}</dd>

                                <hr>

                                <dt class="col-sm-3">@lang('Role')</dt>
                                <dd class="col-sm-9">{{ $role }}</dd>
                            </dl>
                            <small class="text-muted">Dernière modification le {{ $user->updated_at->format('d/m/Y') }} à
                                {{ $user->updated_at->format('H:i:s') }}</small>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</x-app-layout>
@if (session()->has('message'))
    <x-notification title="Suppression de profil" color="bg-danger">{{ session('message') }}</x-notification>
@endif
