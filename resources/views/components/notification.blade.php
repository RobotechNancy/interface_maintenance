<div class="toast-container position-fixed bottom-0 end-0 p-3" aria-live="assertive" aria-atomic="true">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div
            class="toast-header @if (isset($color)) {{ $color }} @else bg-primary @endif text-white">
            @if (isset($title))
                <strong class="me-auto">{{ $title }}</strong>
            @endif
            <small><?= date('H:i:s') ?></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bg-dark text-white">
            {{ $slot }}
        </div>
    </div>
</div>

<script>
    const toastLiveExample = document.getElementById('liveToast')
    const toast = new bootstrap.Toast(toastLiveExample)

    toast.show()
</script>
