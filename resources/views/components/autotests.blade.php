<div class="container tabs d-none" id="tab_connectivite">
    <div class="vstack gap-5">
        <div class="hstack gap-2">
            <span class="fs-5 fw-bold">
                Connectivité (CAN, XBee)
            </span>
            <div class="vr"></div>
            <!--x-button title="Autotests" id="" url="{{ route('log') }}" icon="fa-solid fa-wrench" addons="btn-warning"/-->
        </div>    
        <div>
            <span class="badge bg-white text-dark fs-6">
                Bus CAN
            </span>
            <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 g-5 p-3">
                <div class="col">
                    <img src="{{ asset('img/carte_stm32.png') }}" height="70" /><br>
                    <span class="mt-3 mb-3 d-block">Base roulante</span>
                    <x-button title="Tester" id="2" url="{{ route('log') }}"/>
                </div>
                <div class="col">
                    <img src="{{ asset('img/carte_stm32.png') }}" height="70" /><br>
                    <span class="mt-3 mb-3 d-block">Odométrie</span>
                    <x-button title="Tester" id="1" url="{{ route('log') }}"/>
                </div>
                <div class="col">
                    <img src="{{ asset('img/carte_stm32.png') }}" height="70" /><br>
                    <span class="mt-3 mb-3 d-block">Actionneurs</span>
                    <button class="btn btn-primary disabled">Tester <span class="badge text-bg-light">A
                            venir</span></button>
                </div>
            </div>
        </div>
        <div>
            <span class="badge bg-white text-dark fs-6">
                Xbee
            </span>
            <div class="row row-cols-2 row-cols-lg-4 row-cols-md-2 g-4 p-3">
                <div class="col">
                    <img src="{{ asset('img/xbee.png') }}" style="transform:rotateY(180deg);" width="130" /><br>
                    <span class="mt-3 mb-3 d-block">Robot 1 <i class="fa-solid fa-tower-cell"></i></span>
                    <button class="btn btn-primary disabled">Tester <span class="badge text-bg-light">A
                            venir</span></button>
                </div>
                <div class="col">
                    <img src="{{ asset('img/xbee.png') }}" width="130" /><br>
                    <span class="mt-3 mb-3 d-block">Robot 2 <i class="fa-solid fa-tower-cell"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
