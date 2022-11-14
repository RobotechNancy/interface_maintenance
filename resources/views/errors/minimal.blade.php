<x-app-layout>
    <x-slot name="title">Erreur @yield("code")</x-slot>
    <section class="section is-small">
        <h3>Erreur @yield("code") : @yield("title")</h3>
        <h5>

          @yield("message")<br>

          @auth
          <strong><a href="{{ url('dashboard') }}">Retour au tableau de bord</a></strong>.
          @else
          <br>Pour continuer votre navigation, vous pouvez <strong><a href="{{ route('register') }}">créer un compte</a></strong>, ou <strong><a href="{{ route('login') }}">vous connecter</a></strong>.
          @endauth

        </h5>
    </section>
</x-app-layout>
