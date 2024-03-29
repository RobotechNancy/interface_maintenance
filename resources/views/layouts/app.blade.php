<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Interface de maintenance du projet Robotech Nancy">
    <meta name="author" content="Robotech Nancy">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="dark">
    <link rel="icon" href="/img/favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @if (isset($title))
        <title>Robotech Nancy | {{ $title }}</title>
    @else
        <title>Robotech Nancy | Interface de maintenance</title>
    @endif

    <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="/fontawesome/css/all.css" type="text/css" rel="stylesheet">

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/functions.js"></script>
    <script src="/js/main.js"></script>
    <script src="/fontawesome/js/all.js"></script>
</head>

<body class="bg-dark text-white">
    @auth
        <?php
            $expiresAt = date('Y-m-d H:i:s', strtotime("+5 min"));
            Cache::put('user-is-online-' . Auth::user()->email, true, $expiresAt);
        ?>
        @if ($_SERVER['REQUEST_URI'] == '/dashboard' ||
            $_SERVER['REQUEST_URI'] == '/index' ||
            substr($_SERVER['REQUEST_URI'], 0, 5) == '/edit')
            @include('components.sidebar')
        @endif

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
        $initiales = strtoupper(substr(Auth::user()->name, 0, 2));
        ?>
    @endauth

    @include('components.navbar')

    <div class="container-sm mt-5 ps-lg-5">
        {{ $slot }}
    </div>

</body>

</html>
