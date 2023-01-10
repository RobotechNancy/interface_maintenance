<div class="container tabs d-none" id="tab_connectivite">
    <div class="vstack gap-5">
        <div class="hstack gap-2">
            <span class="fs-5 fw-bold">
                Connectivité (CAN, XBee)
            </span>
            @if (Auth::user()->role != 0)
            <div class="vr"></div>
                <button role="button" type="button" id="btn_autotests" class="btn btn-warning btn_form"><span class="d-none d-md-inline">Autotests</span> <i class="fa-solid fa-wrench"></i></button>
            @endif
        </div>
        <div>
            <span class="badge bg-white text-dark fs-6">
                Bus CAN
            </span>
            <div class="row row-cols-1 row-cols-lg-2 row-cols-md-2 g-5 p-3">
                <div class="col">
                    <img src="{{ asset('img/carte_stm32.png') }}" height="70" /><br>
                    <span class="mt-3 mb-3 d-block">Base roulante</span>
                    @if (Auth::user()->role != 0)
                        <div class="hstack gap-2">
                            <x-button title="Tester l'inter-connectivité" icon="fa-solid fa-plug-circle-bolt" id="2" url="{{ route('log') }}"/>
                            <span id="result_test_br" class="badge" data-bs-toggle="tooltip" data-bs-placement="right"></span>
                        </div>

                        <p class="fs-6 mt-3 text-muted d-none" id="container_test_br_datetime"><small><i class="fa-solid fa-circle-info"></i> Dernier test le <span id="maj_test_br_datetime">XX/XX/XXXX à xx:xx:xx</span></small></p>
                    @endif
                </div>
                <div class="col">
                    <img src="{{ asset('img/carte_stm32.png') }}" height="70" /><br>
                    <span class="mt-3 mb-3 d-block">Odométrie</span>
                    @if (Auth::user()->role != 0)
                        <div class="hstack gap-2">
                            <x-button title="Tester l'inter-connectivité" icon="fa-solid fa-plug-circle-bolt" id="1" url="{{ route('log') }}"/>
                            <span id="result_test_odo" class="badge" data-bs-toggle="tooltip" data-bs-placement="right"></span>
                        </div>

                        <p class="fs-6 mt-3 text-muted d-none" id="container_test_odo_datetime"><small><i class="fa-solid fa-circle-info"></i> Dernier test le <span id="maj_test_odo_datetime">XX/XX/XXXX à xx:xx:xx</span></small></p>
                    @endif
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
                </div>
                <div class="col">
                    <img src="{{ asset('img/xbee.png') }}" width="130" /><br>
                    <span class="mt-3 mb-3 d-block">Robot 2 <i class="fa-solid fa-tower-cell"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
