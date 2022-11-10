<form method="POST" id="form_{{ $id }}">
    @csrf
    <button class="button is-link btn_form @if (isset($addons)) {{ $addons }} @endif" id="btn_{{ $id }}" type="submit">
    @if (isset($title))
        <span>{{ $title }}</span>
    @endif
    @if (isset($icon))
        <span class="icon">
            <i class="{{ $icon }}" @if (isset($icon_style)) style="{{ $icon_style }}" @endif></i>
        </span>
    @endif
    </button>
</form>

<script>
    $(document).ready(function () {
        url = "{{ $url }}";
        id = "{{ $id }}";

        sendData(url, id);
    });
</script>
