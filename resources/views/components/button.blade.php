<form method="POST" id="form_{{ $id }}">
    @csrf
    <button class="button @if (isset($color)) {{ $color }} @else is-link @endif btn_form @if (isset($addons)) {{ $addons }} @endif"
        id="btn_{{ $id }}" type="submit">
        @if (isset($title))
            <span>{{ $title }}</span>
        @endif
        @if (isset($icon))
            <span class="icon">
                <i class="{{ $icon }}" @if (isset($iconstyle)) style="{{ $iconstyle }}" @endif></i>
            </span>
        @endif
    </button>
</form>

<script>
    $(document).ready(function() {
        url = "{{ $url }}";
        id = "{{ $id }}";

        sendData(url, id);
    });
</script>
