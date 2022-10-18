<x-app-layout>
    <x-slot name="title"> @lang('Profile edition') </x-slot>
    <form class="box" method="POST" action="{{ route('update', ['user' => $user]) }}">
        @csrf
        <div class="field">
            <label class="label">{{  __('Name') }}</label>
            <div class="control has-icons-left">
              <input class="input <?php if(!empty($errors->get('name'))) echo "is-danger" ?>" type="text" id="name" name="name" value="{{ $user->name }}" placeholder="Alex" required autofocus>
              <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
              </span>
            </div>
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="field">
          <label class="label">{{  __('Email') }}</label>
          <div class="control has-icons-left">
            <input class="input <?php if(!empty($errors->get('email'))) echo "is-danger" ?>" type="email" id="email" name="email" value="{{ $user->email }}" placeholder="alex@example.com" required>
            <span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
            </span>
          </div>
          <x-input-error :messages="$errors->get('email')" />
        </div>

        <?php if(Auth::user()->role == 2 && $user->role != 2) { ?>
        <div class="field">
            <label class="label">{{  __('Rôle') }}</label>
            <div class="control has-icons-left">
                <div class="select <?php if(!empty($errors->get('role'))) echo "is-danger" ?>">
                  <select id="role" name="role" required>
                    <option value=0 <?php if($user->role == 0) echo "selected" ?>>Lecteur</option>
                    <option value=1 <?php if($user->role == 1) echo "selected" ?>>Editeur</option>
                    <option value=2 <?php if($user->role == 2) echo "selected" ?>>Administrateur</option>
                  </select>
                </div>
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-ranking-star"></i>
                </span>
            <x-input-error :messages="$errors->get('role')" />
            </div>
        </div>
        <?php } ?>

        <div class="field">
          <label class="label">{{  __('Password') }}</label>
          <div class="control has-icons-left">
            <input class="input <?php if(!empty($errors->get('password'))) echo "is-danger" ?>" id="password" type="password" name="password" autocomplete="current-password" placeholder="********">
            <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
            </span>
          </div>
          <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="field">
            <label class="label">{{  __('Confirm Password') }}</label>
            <div class="control has-icons-left">
              <input class="input <?php if(!empty($errors->get('password_confirmation'))) echo "is-danger" ?>" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="********">
              <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
              </span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="field is-grouped mt-5">
            <div class="control">
                <button class="button is-link">{{  __('Edit profile') }}</button>
            </div>
        </div>
      </form>
      <p class="help is-link">Dernière modification de ce profil le {{ $user->updated_at->format("d/m/Y") }} à {{ $user->updated_at->format("H:m:s") }}.</p>
      <?php if(Auth::user()->role != 2 && Auth::user()->id != $user->id) { ?>
      <p class="help is-danger">Attention : il n'est pas possible de modifier le rôle de l'utilisateur car vous n'êtes pas administrateur.</p>
      <?php } ?>
      <?php if(Auth::user()->role != 2 && Auth::user()->id == $user->id) { ?>
        <p class="help is-danger">Attention : il n'est pas possible de modifier votre rôle car vous n'êtes pas administrateur.</p>
        <?php } ?>
      <?php if($user->role == 2 && Auth::user()->id != $user->id) { ?>
        <p class="help is-danger">Attention : il n'est pas possible de modifier le rôle de l'utilisateur car il s'agit d'un compte administrateur.</p>
      <?php } ?>
      <?php if($user->role == 2 && Auth::user()->id == $user->id) { ?>
        <p class="help is-danger">Attention : il n'est pas possible de modifier le rôle de votre compte car disposez déjà d'un compte administrateur.</p>
      <?php } ?>
</x-app-layout>
@if (session()->has('message'))
<x-notification title="Modification de profil">{{ session('message') }}</x-notification>
@endif
