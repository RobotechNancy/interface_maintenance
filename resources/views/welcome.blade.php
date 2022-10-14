<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Interface de maintenance du projet Robotech Nancy">
        <meta name="author" content="Robotech Nancy">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="color-scheme" content="dark">
        <link rel="icon" href="img/logo_court_couleur.jpg">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Laravel</title>

        <link href="{{ asset('css/bulma.min.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('css/bulma-prefers-dark.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('css/bulma-timeline.min.css') }}" type="text/css" rel="stylesheet">
    </head>
    <body>
        <section class="hero is-link">
          <div class="hero-body">
            <p class="title">
              Bienvenue !
            </p>
            <p class="subtitle">
              Tout fonctionne correctement :)
            </p>
          </div>
        </section>

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/font-awesome.min.js') }}"></script>
    </body>
</html>
