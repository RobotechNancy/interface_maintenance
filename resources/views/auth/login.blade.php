<x-app-layout>
    <x-slot name="title"> @lang('Log in') </x-slot>

    <h4 class="mb-5 p-3">Formulaire de connexion</h4>

    <form method="POST" action="{{ route('login') }}" class="p-3">
        @csrf

        <div class="input-group mb-4">
            <span class="input-group-text" id="envelope"><i class="fas fa-envelope"></i></span>

            <div class="form-floating <?php if (!empty($errors->get('email'))) {
                echo 'is-invalid';
            } ?>">
                <input class="form-control bg-dark text-white <?php if(!empty($errors->get('email'))) echo "is-invalid" ?>" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="alex@example.com" aria-describedby="envelope" required autofocus>

                <label for="email" class="form-label">{{  __('Email') }}</label>
            </div>
            <x-input-error :messages="$errors->get('email')" />

        </div>

        <div class="input-group mb-4">
            <span class="input-group-text" id="lock"><i class="fas fa-lock"></i></span>

            <div class="form-floating <?php if (!empty($errors->get('email'))) {
                echo 'is-invalid';
            } ?>">
                <input class="form-control bg-dark text-white <?php if(!empty($errors->get('password'))) echo "is-invalid" ?>" type="password" id="password" name="password" autocomplete="current-password" placeholder="*********" aria-describedby="lock" required>

                <label for="password" class="form-label">{{  __('Password') }}</label>
            </div>
            <x-input-error :messages="$errors->get('password')" />

        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="checkbox" checked>
            <label class="form-check-label" for="checkbox">
                {{  __('Remember me') }}
            </label>
        </div>

        <div class="btn-group" role="group">
            <button type="submit" class="btn btn-primary">{{  __('Log in') }}</button>
            <a class="btn btn-outline-light" href="{{ route('register') }}">{{ __('Not already registered?') }}</a>
        </div>
    </form>


    @if (session()->has('warning'))
        <x-notification title="Connexion impossible" color="text-bg-warning">{{ session('warning') }}</x-notification>
    @endif
</x-app-layout>
