@auth
<?php
$role = '';
switch (Auth::user()->role) {
    case 1:
        $role = 'ÉDITEUR';
        break;

    case 2:
        $role = 'ADMINISTRATEUR';
        break;

    default:
        $role = 'LECTEUR';
        break;
}
?>
<div class="modal fade" id="modalUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modalUserLabel" aria-hidden="true" style="z-index:5000;">

    <div class="modal-dialog modal-dialog-sm-centered modal-dialog-scrollable modal-lg">

        <div class="bg-dark text-white modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalUserLabel">
                    <span class="ms-lg-2">{{ Auth::user()->name }}</span>
                    <span class="ms-2 badge rounded-pill text-bg-warning">{{ $role }}</span>
                </h1>
                <button type="button" class="bg-secondary btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <small class="text-secondary">Dernière modification le
                    {{ Auth::user()->updated_at->format('d/m/Y') }} à
                    {{ Auth::user()->updated_at->format('H:i:s') }}.</small>

                <form method="POST" action="{{ route('update', ['user' => Auth::user()]) }}" class="p-3">
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
                                    } ?>" type="name"
                                        id="name" name="name" value="{{ Auth::user()->name }}"
                                        placeholder="Alex" aria-describedby="user" autofocus>

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
                                    } ?>" type="email"
                                        id="email" name="email" value="{{ Auth::user()->email }}"
                                        placeholder="alex@example.com" aria-describedby="envelope">

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
                            } ?>" id="role"
                                name="role" @if (!(Auth::user()->role == 2 && Auth::user()->role != 2)) disabled=true @endif>

                                <option value=0 @if (Auth::user()->role == 0) selected @endif>Lecteur</option>
                                <option value=1 @if (Auth::user()->role == 1) selected @endif>Editeur</option>
                                <option value=2 @if (Auth::user()->role == 2) selected @endif>Administrateur
                                </option>
                            </select>

                            <label for="role" class="label">{{ __('Rôle') }}</label>
                        </div>
                        <x-input-error :messages="$errors->get('role')" />

                        @if (Auth::user()->role != 2 && Auth::user()->id != Auth::user()->id)
                            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de
                                    l'utilisateur car
                                    vous n'êtes pas administrateur.</small></p>
                        @elseif (Auth::user()->role != 2 && Auth::user()->id == Auth::user()->id)
                            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de votre
                                    compte car vous
                                    n'êtes pas administrateur.</small></p>
                        @elseif (Auth::user()->role == 2 && Auth::user()->id != Auth::user()->id)
                            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de
                                    l'utilisateur car il
                                    s'agit d'un compte administrateur.</small></p>
                        @elseif (Auth::user()->role == 2 && Auth::user()->id == Auth::user()->id)
                            <p class="mt-2 text-warning"><small>Il n'est pas possible de modifier le rôle de votre
                                    compte car vous
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
                                        id="password" name="password" autocomplete="new-password"
                                        placeholder="*********" aria-describedby="lock">

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
                                        id="password_confirmation" name="password_confirmation"
                                        autocomplete="new-password" placeholder="*********" aria-describedby="lock">

                                    <label for="password_confirmation"
                                        class="form-label">{{ __('Confirm Password') }}</label>

                                </div>

                                <x-input-error :messages="$errors->get('password_confirmation')" />

                            </div>
                        </div>
                    </div>

                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-primary">{{ __('Edit my profile') }}</button>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a role="button" class="btn btn-warning"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            @lang('Logout')
                        </a>
                    </form>

                    <form method="POST" action="{{ route('delete', ['user' => Auth::user()]) }}">
                        @csrf
                        <a role="button" class="btn btn-danger"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            @lang('Delete my profile')
                        </a>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
@endauth
