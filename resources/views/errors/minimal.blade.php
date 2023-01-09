<x-app-layout>
    <x-slot name="title">Erreur @yield('code')</x-slot>


    <section class="section is-small ms-lg-5 ps-lg-5">
        <div class="alert alert-danger fs-5" role="alert">Erreur @yield('code') (code erreur : {{ $exception->getCode() }}) :
            @yield('title')</div>
        <h5 class="mt-3 p-3 fs-5">

            <div class="alert alert-primary" role="alert">@yield('message')</div><br>

            @if(!empty($exception->getMessage()))
            <div class="alert alert-info" role="alert">Description : <span
                    class="badge text-bg-warning text-wrap text-start">{{ $exception->getMessage() }}</span></div>
            @endif

            @if(!empty($exception->getFile()))
            <div class="alert alert-info" role="alert">Fichier : <span
                    class="badge text-bg-primary text-wrap text-start">{{ $exception->getFile() }}</span>, ligne <span
                    class="badge text-bg-secondary">{{ $exception->getLine() }}</span></div><br>
            @endif

            @auth
                <button type="button" class="btn btn-light"><a style='text-decoration:none;' href="{{ url('dashboard') }}" class="text-dark">Retour au tableau de bord</a></button>
            @else
                <br>Pour continuer votre navigation, vous pouvez <strong><a style="text-decoration: none"
                        href="{{ route('register') }}">créer un compte</a></strong>, ou <strong><a
                        style="text-decoration: none" href="{{ route('login') }}">vous connecter</a></strong>.
            @endauth

        </h5>
    </section>
</x-app-layout>
