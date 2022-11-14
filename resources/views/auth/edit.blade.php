<x-app-layout>
    <x-slot name="title"> @lang('Profile edition') </x-slot>

    <h4 class="mb-5">Formulaire de modification de compte</h4>

    <form method="POST" action="{{ route('update', ['user' => $user]) }}">
        @csrf

        <div class="row">
            <div class="col">

                <div class="input-group mb-4">
                    <span class="input-group-text" id="user"><i class="fas fa-user"></i></span>

                    <div class="form-floating <?php if (!empty($errors->get('name'))) {
                        echo 'is-invalid';
                    } ?>">

                        <input class="form-control bg-dark text-white-50 <?php if (!empty($errors->get('name'))) {
                            echo 'is-invalid';
                        } ?>" type="name" id="name"
                            name="name" value="{{ Auth::user()->name }}" placeholder="Alex" aria-describedby="user"
                            required autofocus>

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
                        <input class="form-control bg-dark text-white-50 <?php if (!empty($errors->get('email'))) {
                            echo 'is-invalid';
                        } ?>" type="email" id="email"
                            name="email" value="{{ Auth::user()->email }}" placeholder="alex@example.com"
                            aria-describedby="envelope" required>

                        <label for="email" class="form-label">{{ __('Email') }}</label>
                    </div>
                    <x-input-error :messages="$errors->get('email')" />

                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="form-floating">
                <select class="form-select bg-dark text-white-50 <?php if (!empty($errors->get('role'))) {
                    echo 'is-invalid';
                } ?>" id="role" name="role" required
                    <?php if (Auth::user()->role == 2 && $user->role != 2) {
                        echo 'disabled=false';
                    } else {
                        echo 'disabled=true';
                    } ?>>
                    <option value=0 <?php if ($user->role == 0) {
                        echo 'selected';
                    } ?>>Lecteur</option>
                    <option value=1 <?php if ($user->role == 1) {
                        echo 'selected';
                    } ?>>Editeur</option>
                    <option value=2 <?php if ($user->role == 2) {
                        echo 'selected';
                    } ?>>Administrateur</option>
                </select>

                <label for="role" class="label">{{ __('Rôle') }}</label>
            </div>
            <x-input-error :messages="$errors->get('role')" />
            <?php if(Auth::user()->role != 2 && Auth::user()->id != $user->id) { ?>
            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de l'utilisateur car
                vous n'êtes pas administrateur.</small></p>
            <?php } else if(Auth::user()->role != 2 && Auth::user()->id == $user->id) { ?>
            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de votre compte car vous
                n'êtes pas administrateur.</small></p>
            <?php } else if($user->role == 2 && Auth::user()->id != $user->id) { ?>
            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de l'utilisateur car il
                s'agit d'un compte administrateur.</small></p>
            <?php } else if($user->role == 2 && Auth::user()->id == $user->id) { ?>
            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de votre compte car vous
                disposez déjà d'un compte administrateur.</small></p>
            <?php } ?>
        </div>

        <div class="row">
            <div class="col">

                <div class="input-group mb-4">
                    <span class="input-group-text" id="lock"><i class="fas fa-lock"></i></span>

                    <div class="form-floating <?php if (!empty($errors->get('password'))) {
                        echo 'is-invalid';
                    } ?>">
                        <input class="form-control bg-dark text-white-50 <?php if (!empty($errors->get('password'))) {
                            echo 'is-invalid';
                        } ?>" type="password"
                            id="password" name="password" autocomplete="new-password" placeholder="*********"
                            aria-describedby="lock" required>

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
                        <input class="form-control bg-dark text-white-50 <?php if (!empty($errors->get('password_confirmation'))) {
                            echo 'is-invalid';
                        } ?>" type="password"
                            id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                            placeholder="*********" aria-describedby="lock" required>

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

</x-app-layout>
@if (session()->has('success'))
    <x-notification title="Modification du profil" color="is-success">{{ session('success') }}</x-notification>
@endif
@if (session()->has('warning'))
    <x-notification title="Modification du profil" color="is-warning">{{ session('warning') }}</x-notification>
@endif
