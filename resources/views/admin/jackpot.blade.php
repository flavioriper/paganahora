@extends('admin.layout')

<style>
    .game-jackpot__card {
        width: 100%;
        font-size: 22px;
        display: flex;
        gap: 6px;
        justify-content: space-between;
    }

    .game-jackpot__card > div {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 6px;
    }
</style>

@section('content')
    <div class="content-page">
        <div class="content">
                <div class="container">
                    <div class="">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Configurações do JACKPOT</h4>
                            </div>
                        </div>
                        <div class="row m-t-15">
                            <div class="col-md-4 col-lg-4">
                                <div class="card-box game-jackpot__card">
                                    <div>
                                        <p>R$ <span id="game-jackpot-prize-1">{{floor(Cache::get('pot_1'))}}</span></p>
                                        <p class="text-muted"><small>POTE 1</small></p>
                                    </div>
                                    <div>
                                        <button type="button" data-pot="1" class="btn btn-purple waves-effect waves-light liberar-premio">Liberar Prêmio</button>
                                        <button type="button" data-pot="1" data-fake="1" class="btn btn-purple waves-effect waves-light liberar-premio">Liberar Prêmio Fake</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="card-box game-jackpot__card">
                                    <div>
                                        <p>R$ <span id="game-jackpot-prize-2">{{floor(Cache::get('pot_2'))}}</span></p>
                                        <p class="text-muted"><small>POTE 2</small></p>
                                    </div>
                                    <div>
                                        <button type="button" data-pot="2" class="btn btn-purple waves-effect waves-light liberar-premio">Liberar Prêmio</button>
                                        <button type="button" data-pot="2" data-fake="1" class="btn btn-purple waves-effect waves-light liberar-premio">Liberar Prêmio Fake</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="card-box game-jackpot__card">
                                    <div>
                                        <p>R$ <span id="game-jackpot-prize-3">{{floor(Cache::get('pot_3'))}}</span></p>
                                        <p class="text-muted"><small>POTE 3</small></p>
                                    </div>
                                    <div>
                                        <button type="button" data-pot="3" class="btn btn-purple waves-effect waves-light liberar-premio">Liberar Prêmio</button>
                                        <button type="button" data-pot="3" data-fake="1" class="btn btn-purple waves-effect waves-light liberar-premio">Liberar Prêmio Fake</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    setInterval(() => {
        let n = document.head.querySelector('meta[name="csrf-token"]');
        let url = window.location.origin + "/api/get_jackpots";
        let settings = {
            "url": url,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "X-CSRF-TOKEN": n.content,
                "Content-Type": "application/json"
            },
        };

        $.ajax(settings).done(function (response) {
            const { pot_1, pot_2, pot_3 } = JSON.parse(response);
            $('#game-jackpot-prize-1').text(Math.floor(pot_1));
            $('#game-jackpot-prize-2').text(Math.floor(pot_2));
            $('#game-jackpot-prize-3').text(Math.floor(pot_3));
        });
    }, 5000);

    $('.liberar-premio').click(function() {
        const pot = $(this).attr('data-pot');
        const fake = $(this).attr('data-fake');

        const n = document.head.querySelector('meta[name="csrf-token"]');
        let settings = {
            "url": window.location.origin + "/admin/jackpot/start-prize",
            "method": "POST",
            "data": JSON.stringify({ pot, fake }),
            "timeout": 0,
            "headers": {
                "X-CSRF-TOKEN": n.content,
                "Content-Type": "application/json"
            },
        };
        $.ajax(settings).done(function (response) {
            const data = JSON.parse(response);
            alert('premio liberado');
        });
    });
</script>
@endpush