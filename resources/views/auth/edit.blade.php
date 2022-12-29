<x-app-layout>
    <x-slot name="title"> @lang('Profile edition') </x-slot>

    <h4 class="mb-2 ms-3">Formulaire de modification du compte "{{ $user->name }}"</h4>

    <p class="ps-3 text-muted"><small><i class="fa-solid fa-circle-info"></i> Dernière modification de ce profil le {{ $user->updated_at->format('d/m/Y') }} à
        {{ $user->updated_at->format('H:i:s') }}.</small></p>

    <form method="POST" action="{{ route('update', ['user' => $user]) }}" class="p-3">
        @csrf

        <div class="row">
            <div class="col">

                <div class="input-group mb-4">
                    <span class="input-group-text" id="user"><i class="fas fa-user"></i></span>

                    <div class="form-floating <?php if (!empty($errors->get('name'))) {
                        echo 'is-invalid';
                    } ?>">

                        <input class="form-control bg-dark text-white <?php if (!empty($errors->get('name'))) {
                            echo 'is-invalid';
                        } ?>" type="name" id="name"
                            name="name" value="{{ $user->name }}" placeholder="Alex" aria-describedby="user"
                         autofocus>

                        <label for="name" class="form-label">{{ __('Name') }}</label>

                    </div>

                    <x-input-error :messages="$errors->get('name')" />

                </div>
            </div>

            <div class="w-100 d-sm-none"></div>

            <div class="col">

                <div class="input-group mb-4">
                    <span class="input-group-text" id="envelope"><i class="fas fa-envelope"></i></span>
                    <div class="form-floating <?php if (!empty($errors->get('email'))) {
                        echo 'is-invalid';
                    } ?>">
                        <input class="form-control bg-dark text-white <?php if (!empty($errors->get('email'))) {
                            echo 'is-invalid';
                        } ?>" type="email" id="email"
                            name="email" value="{{ $user->email }}" placeholder="alex@example.com"
                            aria-describedby="envelope">

                        <label for="email" class="form-label">{{ __('Email') }}</label>
                    </div>
                    <x-input-error :messages="$errors->get('email')" />

                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="form-floating">
                <select class="form-select bg-dark text-white <?php if (!empty($errors->get('role'))) {
                    echo 'is-invalid';
                } ?>" id="role" name="role"

                    @if (!(Auth::user()->role == 2 && $user->role != 2)) disabled=true @endif>

                    <option value=0 @if ($user->role == 0) selected @endif>Lecteur</option>
                    <option value=1 @if ($user->role == 1) selected @endif>Editeur</option>
                    <option value=2 @if ($user->role == 2) selected @endif disabled>Administrateur</option>
                </select>

                <label for="role" class="label">{{ __('Rôle') }}</label>
            </div>
            <x-input-error :messages="$errors->get('role')" />

            @if (Auth::user()->role != 2 && Auth::user()->id != $user->id)

            <p class="mt-2 text-warning"><small><i class="fa-solid fa-triangle-exclamation"></i> Il n'est pas possible de modifier le rôle de l'utilisateur car
                    vous n'êtes pas administrateur.</small></p>

            @elseif (Auth::user()->role != 2 && Auth::user()->id == $user->id)

            <p class="mt-2 text-warning"><small><i class="fa-solid fa-triangle-exclamation"></i> Il n'est pas possible de modifier le rôle de votre compte car vous
                    n'êtes pas administrateur.</small></p>

            @elseif ($user->role == 2 && Auth::user()->id != $user->id)

            <p class="mt-2 text-warning"><small><i class="fa-solid fa-triangle-exclamation"></i> Il n'est pas possible de modifier le rôle de l'utilisateur car il
                    s'agit d'un compte administrateur.</small></p>

            @elseif ($user->role == 2 && Auth::user()->id == $user->id)

            <p class="mt-2 text-warning"><small><i class="fa-solid fa-triangle-exclamation"></i> Il n'est pas possible de modifier le rôle de votre compte car vous
                    disposez déjà d'un compte administrateur.</small></p>
            @endif
        </div>

        <div class="row">
            <div class="col">

                <div class="input-group mb-4">
                    <span class="input-group-text" id="lock"><i class="fas fa-lock"></i></span>

                    <div class="form-floating <?php if (!empty($errors->get('password'))) {
                        echo 'is-invalid';
                    } ?>">
                        <input class="form-control bg-dark text-white <?php if (!empty($errors->get('password'))) {
                            echo 'is-invalid';
                        } ?>" type="password"
                            id="password" name="password" autocomplete="new-password" placeholder="*********"
                            aria-describedby="lock">

                        <label for="password" class="form-label">{{ __('Password') }}</label>

                    </div>
                    <x-input-error :messages="$errors->get('password')" />

                </div>
            </div>

            <div class="w-100 d-sm-none"></div>

            <div class="col">

                <div class="input-group mb-5">
                    <span class="input-group-text" id="lock"><i class="fas fa-lock"></i></span>

                    <div class="form-floating <?php if (!empty($errors->get('password_confirmation'))) {
                        echo 'is-invalid';
                    } ?>">
                        <input class="form-control bg-dark text-white <?php if (!empty($errors->get('password_confirmation'))) {
                            echo 'is-invalid';
                        } ?>" type="password"
                            id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                            placeholder="*********" aria-describedby="lock">

                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>

                    </div>

                    <x-input-error :messages="$errors->get('password_confirmation')" />

                </div>
            </div>
        </div>

        <div class="btn-group" role="group">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications <i class="fa-solid fa-floppy-disk"></i></button>
        </div>
    </form>


    <form method="POST" action="{{ route('delete', ['user' => $user]) }}" class="d-none" id="form_delete">
        @csrf
    </form>

    <a role="button" class="btn btn-danger ms-3"
    onclick="event.preventDefault(); $('#form_delete').submit();">
        Supprimer l'utilisateur <i class="fa-solid fa-trash-can"></i>
    </a>

    @if (session()->has('success'))
        <x-notification title="Modification du profil" color="text-bg-success">{{ session('success') }}</x-notification>
    @endif
    @if (session()->has('warning'))
        <x-notification title="Modification du profil" color="text-bg-warning">{{ session('warning') }}</x-notification>
    @endif
</x-app-layout>
