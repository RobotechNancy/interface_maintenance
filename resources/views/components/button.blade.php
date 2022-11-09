<form method="POST" id="form_{{ $id }}">
    @csrf
    <button class="button is-link btn_form" id="btn_{{ $id }}" type="submit">
        <span>{{ $title }}</span>
        <span class="icon">
            <i class="{{ $icon }}"></i>
        </span>
    </button>
</form>

<script>
    $(document).ready(function () {
        url = "{{ $url }}";
        id = "{{ $id }}";

        sendData(url, id);
    });
</script>
