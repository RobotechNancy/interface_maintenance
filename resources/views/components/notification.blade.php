<div class="notification @if (isset($color)) {{ $color }} @else is-link @endif" style="position: absolute; bottom: 0; right : 0">
    <button class="delete"></button>
    @if (isset($title)) <strong>{{ $title }}</strong><br>@endif {{ $slot }}
</div>
