<x-app-layout>
    <x-slot name="title"> @lang('Profile edition') </x-slot>
    <form class="box" method="POST" action="{{ route('edit', Auth::user()->id) }}">
        @csrf
        @method('put')
        <div class="field">
            <label class="label">{{  __('Name') }}</label>
            <div class="control has-icons-left">
              <input class="input <?php if(!empty($errors->get('name'))) echo "is-danger" ?>" type="text" id="name" name="name" value="{{ $user->name }}" placeholder="Alex" required autofocus>
              <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
              </span>
            </div>
            <x-input-error :messages="$errors->get('nale')" />
        </div>

        <div class="field">
          <label class="label">{{  __('Email') }}</label>
          <div class="control has-icons-left">
            <input class="input <?php if(!empty($errors->get('email'))) echo "is-danger" ?>" type="email" id="email" name="email" value="{{ $user->email }}" placeholder="alex@example.com" required autofocus>
            <span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
            </span>
          </div>
          <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="field">
            <label class="label">{{  __('Rôle') }}</label>
            <div class="control has-icons-left">
                <div class="select <?php if(!empty($errors->get('role'))) echo "is-danger" ?>">
                  <select id="role" name="role" required>
                    <option value="0" <?php if($user->role == 0) echo "selected" ?>>Lecteur</option>
                    <option value="l" <?php if($user->role == 1) echo "selected" ?>>Editeur</option>
                    <option value="2" <?php if($user->role == 2) echo "selected" ?>>Administrateur</option>
                  </select>
                </div>
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-ranking-star"></i>
                </span>
            <x-input-error :messages="$errors->get('role')" />
            </div>
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

        <div class="field is-grouped mt-5">
            <div class="control">
                <button class="button is-link">{{  __('Edit profile') }}</button>
            </div>
        </div>
      </form>
</x-app-layout>
