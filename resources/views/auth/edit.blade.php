<x-app-layout>
    <x-slot name="title"> @lang('Profile edition') </x-slot>

    <h4 class="mb-5"><x-button-back />Formulaire de modification du compte "{{ $user->name }}"</h4>

    <form method="POST" action="{{ route('update', ['user' => $user]) }}">
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
                    <option value=2 @if ($user->role == 2) selected @endif>Administrateur</option>
                </select>

                <label for="role" class="label">{{ __('Rôle') }}</label>
            </div>
            <x-input-error :messages="$errors->get('role')" />

            @if (Auth::user()->role != 2 && Auth::user()->id != $user->id)

            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de l'utilisateur car
                    vous n'êtes pas administrateur.</small></p>

            @elseif (Auth::user()->role != 2 && Auth::user()->id == $user->id)

            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de votre compte car vous
                    n'êtes pas administrateur.</small></p>

            @elseif ($user->role == 2 && Auth::user()->id != $user->id)

            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de l'utilisateur car il
                    s'agit d'un compte administrateur.</small></p>

            @elseif ($user->role == 2 && Auth::user()->id == $user->id)

            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de votre compte car vous
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
            <button type="submit" class="btn btn-primary">{{ __('Edit profile') }}</button>
        </div>
    </form>

    <p class="mt-5"><small>Dernière modification de ce profil le {{ $user->updated_at->format('d/m/Y') }} à
            {{ $user->updated_at->format('H:i:s') }}.</small></p>

    @if (session()->has('success'))
        <x-notification title="Modification du profil" color="bg-success">{{ session('success') }}</x-notification>
    @endif
    @if (session()->has('warning'))
        <x-notification title="Modification du profil" color="bg-warning">{{ session('warning') }}</x-notification>
    @endif
</x-app-layout>
