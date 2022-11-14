<x-app-layout>
    <x-slot name="title"> @lang('Register') </x-slot>

    <h4 class="mb-5">Formulaire de création de compte</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name" class="form-label">{{  __('Name') }}</label>

        <div class="input-group mb-4">
            <span class="input-group-text" id="user"><i class="fas fa-user"></i></span>
            <input class="form-control bg-dark text-white-50 <?php if(!empty($errors->get('name'))) echo "is-invalid" ?>" type="name" id="name" name="name" value="{{ old('name') }}" placeholder="Alex" aria-describedby="user" required autofocus>

            <x-input-error :messages="$errors->get('name')" />

        </div>

        <label for="email" class="form-label">{{  __('Email') }}</label>

        <div class="input-group mb-4">
            <span class="input-group-text" id="envelope"><i class="fas fa-envelope"></i></span>
            <input class="form-control bg-dark text-white-50 <?php if(!empty($errors->get('email'))) echo "is-invalid" ?>" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="alex@example.com" aria-describedby="envelope" required>

            <x-input-error :messages="$errors->get('email')" />

        </div>

        <div class="row">
            <div class="col">
                <label for="password" class="form-label">{{  __('Password') }}</label>

                <div class="input-group mb-4">
                    <span class="input-group-text" id="lock"><i class="fas fa-lock"></i></span>
                    <input class="form-control bg-dark text-white-50 <?php if(!empty($errors->get('password'))) echo "is-invalid" ?>" type="password" id="password" name="password" autocomplete="new-password" placeholder="*********" aria-describedby="lock" required>

                    <x-input-error :messages="$errors->get('password')" />

                </div>
            </div>

            <div class="col">
                <label for="password_confirmation" class="form-label">{{  __('Confirm Password') }}</label>

                <div class="input-group mb-5">
                    <span class="input-group-text" id="lock"><i class="fas fa-lock"></i></span>
                    <input class="form-control bg-dark text-white-50 <?php if(!empty($errors->get('password_confirmation'))) echo "is-invalid" ?>" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="*********" aria-describedby="lock" required>

                    <x-input-error :messages="$errors->get('password_confirmation')" />

                </div>
            </div>
        </div>

        <div class="btn-group" role="group">
            <button type="submit" class="btn btn-primary">{{  __('Register') }}</button>
            <a class="btn btn-light" href="{{ route('login') }}">{{ __('Already registered?') }}</a>
        </div>
    </form>
</x-app-layout>
