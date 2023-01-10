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

        <span class="badge bg-white text-dark fs-6">
            Bus CAN
        </span>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                @include("components.autotests-item", ["title" => "Odométrie",
                                                    "btn_title" => "Test inter-connectivité",
                                                    "img" => "img/carte_stm32.png",
                                                    "carte_id" => 1])

                @include("components.autotests-item", ["title" => "Base roulante",
                                                    "btn_title" => "Test inter-connectivité",
                                                    "img" => "img/carte_stm32.png",
                                                    "carte_id" => 2])
        </div>
        <span class="badge bg-white text-dark fs-6">
            Xbee
        </span>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                @include("components.autotests-item", ["title" => "Robot actuel (n°1)",
                                                    "btn_title" => "Autotest du module",
                                                    "img" => "img/xbee.png",
                                                    "config" => true,
                                                    "carte_id" => 3])
        </div>
    </div>
</div>
