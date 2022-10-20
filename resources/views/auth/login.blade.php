<x-app-layout>
    <x-slot name="title"> @lang('Log in') </x-slot>
    <form class="box" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
          <label class="label">{{  __('Email') }}</label>
          <div class="control has-icons-left">
            <input class="input <?php if(!empty($errors->get('email'))) echo "is-danger" ?>" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="alex@example.com" required autofocus>
            <span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
            </span>
          </div>
          <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="field">
          <label class="label">{{  __('Password') }}</label>
          <div class="control has-icons-left">
            <input class="input <?php if(!empty($errors->get('password'))) echo "is-danger" ?>" id="password" type="password" name="password" autocomplete="current-password" placeholder="********" required>
            <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
            </span>
          </div>
          <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="field">
            <p class="control">
                <div class="b-checkbox is-default is-circular">
                    <input id="checkbox" class="switch is-rounded is-link" name="remember" checked type="checkbox">
                    <label for="checkbox">
                        {{  __('Remember me') }}
                    </label>
                </div>
            </p>
        </div>

        <div class="field is-grouped mt-5">
            <div class="control">
                <button class="button is-link">{{  __('Log in') }}</button>
            </div>
            <div class="control">
                <a class="button is-link is-outlined" href="{{ route('register') }}">{{ __('Not already registered?') }}</a>
            </div>
        </div>
      </form>
</x-app-layout>
