<x-app-layout>
    <x-slot name="title"> @lang('Register') </x-slot>
    <form class="box" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field">
            <label class="label">{{  __('Name') }}</label>
            <div class="control has-icons-left">
              <input class="input <?php if(!empty($errors->get('name'))) echo "is-danger" ?>" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Alex" required autofocus>
              <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
              </span>
            </div>
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="field">
          <label class="label">{{  __('Email') }}</label>
          <div class="control has-icons-left">
            <input class="input <?php if(!empty($errors->get('email'))) echo "is-danger" ?>" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="alex@example.com" required>
            <span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
            </span>
          </div>
          <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="field">
          <label class="label">{{  __('Password') }}</label>
          <div class="control has-icons-left">
            <input class="input <?php if(!empty($errors->get('password'))) echo "is-danger" ?>" type="password" id="password" name="password" autocomplete="new-password" placeholder="********" required>
            <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
            </span>
          </div>
          <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="field">
            <label class="label">{{  __('Confirm Password') }}</label>
            <div class="control has-icons-left">
              <input class="input <?php if(!empty($errors->get('password_confirmation'))) echo "is-danger" ?>" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="********" required>
              <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
              </span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="field is-grouped mt-5">
            <div class="control">
                <button class="button is-link">{{  __('Register') }}</button>
            </div>
            <div class="control">
                <a class="button is-link is-outlined" href="{{ route('login') }}">{{ __('Already registered?') }}</a>
            </div>
        </div>
    </form>
</x-app-layout>
