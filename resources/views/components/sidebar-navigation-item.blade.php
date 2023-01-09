<li class="nav-item">
    <a role="button" id="btn_tab_{{ $id }}" class="btn_tabs nav-link text-white @if(isset($main) && $main) active @endif">

        @if (isset($icon))
            <i class="{{ $icon }} bi pe-none me-2" width="16" height="16"></i>
        @endif

        {{ $name }}
    </a>
</li>
<script>
    tabsManager("tab_{{ $id }}");
</script>
