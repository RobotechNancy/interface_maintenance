<li class="nav-item">
    <a role="button" id="btn_tab_{{ $id }}" class="btn_tabs btn @if (isset($main) && $main) btn-light @else btn-outline-light @endif w-100 position-relative">

        @if (isset($icon))
            <i class="{{ $icon }}"></i>
        @endif

        {{ $name }}

        @if (isset($beta) && $beta)
            <span class="position-absolute top-0 start-100 translate-middle p-1 text-warning bg-dark badge rounded-pill"
                style="font-size: 15px;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </span>
        @endif
    </a>
</li>
<script>
    tabs_manager("tab_{{ $id }}");
</script>
