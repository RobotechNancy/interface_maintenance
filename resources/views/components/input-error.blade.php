@props(['messages'])

@if ($messages)
    <div class="block">
        @foreach ((array) $messages as $message)
            <p class="help is-danger">{{ $message }}</p>
        @endforeach
    </div>
@endif
