<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Interface de maintenance du projet Robotech Nancy">
        <meta name="author" content="Robotech Nancy">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="color-scheme" content="dark">
        <link rel="icon" href="{{ asset('img/favicon.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        @if (isset($title))
            <title>Robotech Nancy | {{ $title }}</title>
        @else
            <title>Robotech Nancy | Interface de maintenance</title>
        @endif

        <link href="{{ asset('css/bulma.min.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('css/bulma-switch.min.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('css/bulma-pageloader.min.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('fontawesome/css/all.css') }}" type="text/css" rel="stylesheet">

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/manage-notifications.js') }}"></script>
        <script src="{{ asset('js/send-data.js') }}"></script>
        <script src="{{ asset('fontawesome/js/all.js') }}"></script>
    </head>
    <body>
        @include('layouts.navbar')
        @if (isset($addons))           
            <div>
                {{ $slot }}
            </div>
        @else             
            <div class="mt-6 ml-6 mr-6">
                {{ $slot }}
            </div>
        @endif
    </body>
</html>
