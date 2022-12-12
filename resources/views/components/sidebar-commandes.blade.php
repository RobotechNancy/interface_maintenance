<li class="nav-header mt-2 badge text-bg-secondary">
    <span>COMMANDES</span>
</li>

<div class="vstack gap-3">
    <x-button title="Test connectivité" id="1" icon="fa-solid fa-tower-cell"
        url="{{ route('log') }}" addons="w-100" />

    <x-button title="Position du robot" id="3" icon="fa-solid fa-crosshairs"
        url="{{ route('log') }}" addons="w-100" />
</div>
