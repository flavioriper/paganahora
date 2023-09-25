@extends('layout')

@section('title')
Raspadinha Premiada - Loteria online instantânea com retirada de dinheiro em PIX
@stop

<style>
    .game-jackpot__card {
        border-radius: 10px;
        background-color: rgba(12,11,35,.8);
        height: 200px;
        width: 100%;
        font-size: 22px;
        display: flex;
        flex-direction: column;
        color: white;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }
</style>

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
            $('#game-jackpot-prize-1').text(pot_1.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#game-jackpot-prize-2').text(pot_2.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#game-jackpot-prize-3').text(pot_3.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        });
    }, 5000);
</script>

@section('content')
<div class="game-jackpot">
    <div class="container container_full-width">
        <div class="game-jackpot__row row py-2">
            <div class="col-md-4 col-lg-4">
                <div class="game-jackpot__card">
                    <p>R$ <span id="game-jackpot-prize-1">{{number_format(Cache::get('pot_1'), 2, ',', '.')}}</span></p>
                    <p>POTE 1</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="game-jackpot__card">
                    <p>R$ <span id="game-jackpot-prize-2">{{number_format(Cache::get('pot_2'), 2, ',', '.')}}</span></p>
                    <p>POTE 2</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="game-jackpot__card">
                    <p>R$ <span id="game-jackpot-prize-3">{{number_format(Cache::get('pot_3'), 2, ',', '.')}}</span></p>
                    <p>POTE 3</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="game">
        <div class="container container_full-width">
            <div class="game__wrapper">
                <div class="game__row row">
                    <div class="col-md-8 col-lg-7">
                        <div class="game__start-block visible" id="screen-start">
    <div class="game__start-layout">
        <div class="game__loader-bg-wrapper">
            <img src="/storage/img/loader-bg.png" alt="" class="game__loader-bg">
        </div>
        <div class="game__start-window-wrapper">
            <div class="game__start-window-block">
                <div id="game__start-ufo" class="game__ufo"></div>
                <p align="center">
                <img border="0" src="/storage/img/raspadinha.png">
                </p>
                <div class="game__start-window">
                    <div class="game__start-window-tabs">
                        <div class="game__start-window-tab game__start-window-tab_left game__start-window-tab_active">Jogar</div>
                        <div class="game__start-window-tab game__start-window-tab_right">&nbsp;&nbsp;&nbsp;&nbsp;Demonstrativo&nbsp;&nbsp;&nbsp;</div>
                    </div>
                    <div class="game__start-window-tabs-wrapper game__start-window-tabs-wrapper_left">
                        <div class="game__start-window-tabs-block" data-type="1">
    <div class="game__start-window-text game__start-window-text_mid">Valor da Aposta</div>
    <div id="demo-rate" class="game__start-window-input input-block">
        <div data-input="inp-balance" class="input-block__down-button input-block__button input-block__button_left"><i class="fa fa-minus" aria-hidden="true"></i></div>
        <div data-input="inp-balance" class="input-block__up-button input-block__button input-block__button_right"><i class="fa fa-plus" aria-hidden="true"></i></div>
        <div class="input-block__input-wrapper">
            <input data-input="inp-balance" id="inp-balance" type="text" class="bet-input input-block__input" placeholder="2" value="2">
        </div>
        <div class="input-block__pattern-line">
            <div data-input="inp-balance" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">2</span>
            </div>
            <div data-input="inp-balance" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">3</span>
            </div>
            <div data-input="inp-balance" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">4</span>
            </div>
            <div data-input="inp-balance" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">5</span>
            </div>
            <div data-input="inp-balance" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">10</span>
            </div>
        </div>
    </div>
    <div class="game__start-window-text game__start-window-text_mid">Prêmiação: <span><span class="rate-min">4</span> até <span class="rate-max">20</span></div>
    <div class="game__start-window-text game__start-window-text_mid">Prêmio Garantido: <span><span class="rate-gar">0</span></span></div>
    <div class="game__start-window-button-line button-line button-line_center">
	@if(Auth::guest())
	<div class="game__start-window-button button-round button-round_ib modal-activate" data-modal="reg">Comece o Jogo<img src="/storage/img/icon__comet_d.png" srcset="/storage/img/icon__comet_d@2x.png 2x, /storage/img/icon__comet_d@3x.png 3x" class="game__start-window-button-icon"></div>
	@else
	<div class="game__start-window-button button-round button-round_ib btn-game-start">Jogar Agora<img src="/storage/img/icon__comet_d.png" srcset="/storage/img/icon__comet_d@2x.png 2x, /storage/img/icon__comet_d@3x.png 3x" class="game__start-window-button-icon"></div>
	@endif
	</div>
</div>                        <div class="game__start-window-tabs-block" data-type="2">
    <div class="game__start-window-text game__start-window-text_mid">Jogar Agora</div>
    <div id="demo-rate" class="game__start-window-input input-block">
        <div data-input="inp-bonus" class="input-block__down-button input-block__button input-block__button_left"><i class="fa fa-minus" aria-hidden="true"></i></div>
        <div data-input="inp-bonus" class="input-block__up-button input-block__button input-block__button_right"><i class="fa fa-plus" aria-hidden="true"></i></div>
        <div class="input-block__input-wrapper">
            <input data-input="inp-bonus" id="inp-bonus" type="text" class="bet-input input-block__input" placeholder="10" value="10">
        </div>
        <div class="input-block__pattern-line">
            <div data-input="inp-bonus" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">2</span>
            </div>
            <div data-input="inp-bonus" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">3</span>
            </div>
            <div data-input="inp-bonus" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">4</span>
            </div>
            <div data-input="inp-bonus" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">5</span>
            </div>
            <div data-input="inp-bonus" class="input-block__pattern-block input-block__pattern">
                <span class="input-block__pattern-value">10</span>
            </div>
        </div>
    </div>
    <div class="game__start-window-text game__start-window-text_mid">Prêmiação: <span><span class="rate-min">200</span> até <span class="rate-max">1000<span></span></div>
    <div class="game__start-window-text game__start-window-text_mid">Prêmio Garantido: <span><span class="rate-gar">10</span></span></div>
    <div class="game__start-window-button-line button-line button-line_center">
	@if(Auth::guest())
	<div class="game__start-window-button button-round button-round_ib modal-activate" data-modal="reg">Comece o Jogo<img src="/storage/img/icon__comet_d.png" srcset="/storage/img/icon__comet_d@2x.png 2x, /storage/img/icon__comet_d@3x.png 3x" class="game__start-window-button-icon"></div>
	@else
	<div class="game__start-window-button button-round button-round_ib btn-game-start">Jogar Agora<img src="/storage/img/icon__comet_d.png" srcset="/storage/img/icon__comet_d@2x.png 2x, /storage/img/icon__comet_d@3x.png 3x" class="game__start-window-button-icon"></div>
	@endif
	</div>
</div>                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                        <div class="game__start-block" id="screen-suspense">
    <div class="game__start-layout">
        <div class="game__loader-bg-wrapper">
            <img src="/storage/img/loader-bg.png" alt="" class="game__loader-bg">
        </div>
        <div class="game__start-window-wrapper">
            <div class="game__start-window-block">
                <div id="game__hmm-ufo" class="game__ufo"></div>
                <div class="game__start-window">
                    <div class="game__start-window-header">Você acertou <br>2 de 3 cartas</div>
                    <div class="game__start-window-button-line button-line button-line_center">
                        <div class="game__start-window-button button-round button-round_ib" id="btn-suspense-continue">Raspe + 1 carta por <span class="val">5</span></div>
                        <div class="game__start-window-button button-round button-round_trans-dark button-round_ib" id="btn-suspense-end">Finalize e ganhe <span class="val">1</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                        <div class="game__start-block" id="screen-lose">
    <div class="game__start-layout">
        <div class="game__start-window-wrapper">
            <div class="game__start-window-block">
                <div id="game__loose-ufo" class="game__ufo"></div>
                <div class="game__start-window">
                    <div class="game__start-window-header">Infelizmente, você não acertou.</div>
                    <div class="game__start-window-text">Prêmio Garantido de <span class="val">20</span><br>foi creditado em sua carteira</div>
                    <div class="game__start-window-button-line button-line button-line_center">
                        <div class="game__start-window-button button-round button-round_ib">Jogar de Novo<img src="/storage/img/icon__refresh_d.png" srcset="/storage/img/icon__refresh_d@2x.png 2x, /storage/img/icon__refresh_d@3x.png 3x" class="game__start-window-button-icon"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                        <div class="game__start-block" id="screen-win">
    <div class="game__start-layout">
        <div class="game__start-bg-wrapper">
            <img src="/storage/img/start-bg.png" alt="" class="game__start-bg">
        </div>
        <div class="game__start-window-wrapper">
            <div class="game__start-window-block">
                <div id="game__win-ufo" class="game__ufo"></div>
                <div class="game__start-window">
                    <div class="game__start-window-header">Parabéns</div>
                    <div class="game__start-window-text game__start-window-text_big">Você Ganhou <span class="val">5000</span></div>
                    <div class="game__start-window-text">Seu Prêmio foi creditado em sua carteira</div>
                    <div class="game__start-window-button-line button-line button-line_center">
                        <div class="game__start-window-button button-round button-round_ib">Jogar de Novo<img src="/storage/img/icon__comet_d.png" srcset="/storage/img/icon__comet_d@2x.png 2x, /storage/img/icon__comet_d@3x.png 3x" class="game__start-window-button-icon"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                        <div class="game__containers-wrapper game__containers-wrapper_blur">
                            <div class="game__containers row">
                                                                <div class="game__block-col col-xs-4">
                                    <div class="game__block-wrapper">
                                        <div class="game__block">
                                            <div class="game__win-block">
                                                <div class="game__win-value-wrapper">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="game__block-col col-xs-4">
                                    <div class="game__block-wrapper">
                                        <div class="game__block">
                                            <div class="game__win-block">
                                                <div class="game__win-value-wrapper">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="game__block-col col-xs-4">
                                    <div class="game__block-wrapper">
                                        <div class="game__block">
                                            <div class="game__win-block">
                                                <div class="game__win-value-wrapper">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="game__block-col col-xs-4">
                                    <div class="game__block-wrapper">
                                        <div class="game__block">
                                            <div class="game__win-block">
                                                <div class="game__win-value-wrapper">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="game__block-col col-xs-4">
                                    <div class="game__block-wrapper">
                                        <div class="game__block">
                                            <div class="game__win-block">
                                                <div class="game__win-value-wrapper">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="game__block-col col-xs-4">
                                    <div class="game__block-wrapper">
                                        <div class="game__block">
                                            <div class="game__win-block">
                                                <div class="game__win-value-wrapper">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="game__block-col col-xs-4">
                                    <div class="game__block-wrapper">
                                        <div class="game__block">
                                            <div class="game__win-block">
                                                <div class="game__win-value-wrapper">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="game__block-col col-xs-4">
                                    <div class="game__block-wrapper">
                                        <div class="game__block">
                                            <div class="game__win-block">
                                                <div class="game__win-value-wrapper">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="game__block-col col-xs-4">
                                    <div class="game__block-wrapper">
                                        <div class="game__block">
                                            <div class="game__win-block">
                                                <div class="game__win-value-wrapper">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-5">
    <div class="game__info-block">
        <h1 class="game__header">Como jogar na Raspadinha Premiada?</h1>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                <div class="game__info-text">
                    <div class="game__info-icon-wrapper">
                        <img src="/storage/img/icon__comet.png" srcset="/storage/img/icon__comet@2x.png 2x, /storage/img/icon__comet@3x.png 3x" class="game__info-icon">
                    </div>
                    Defina o valor de sua aposta, pressione o botão &quot;Jogar Agora&quot;
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                <div class="game__info-text">
                    <div class="game__info-icon-wrapper">
                        <img src="/storage/img/icon__hand.png" srcset="/storage/img/icon__hand@2x.png 2x, /storage/img/icon__hand@3x.png 3x" class="game__info-icon">
                    </div>
                    Raspe a camada protetora em 3 cartões com seu mouse ou dedo
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                <div class="game__info-text">
                    <div class="game__info-icon-wrapper">
                        <img src="/storage/img/raspadinha-agencianaweb.com.br.png" srcset="/storage/img/raspadinha-agencianaweb.com.br@2x.png 2x, /storage/img/raspadinha-agencianaweb.com.br@3x.png" class="game__info-icon">
                    </div>
                    <span>Encontrou 3 cartões iguais</span>
                    Ganhe um prêmio conforme o valor estipulado de sua apostas
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                <div class="game__info-text">
                    <div class="game__info-icon-wrapper">
                        <img src="/storage/img/icon__refresh.png" srcset="/storage/img/icon__refresh@2x.png 2x, /storage/img/icon__refresh@3x.png 3x" class="game__info-icon">
                    </div>
                    <span>Encontrou 2 cartões iguais</span>
                    Raspe a 4ª carta ou pegue o prêmio garantido
                </div>
            </div>
			
			            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                <div class="game__info-text">
                    <div class="game__info-icon-wrapper">
                        <img src="/storage/img/icon__sunrub.png" srcset="/storage/img/icon__sunrub@2x.png 2x, /storage/img/icon__sunrub@3x.png 3x" class="game__info-icon">
                    </div>
                    O que importa aqui é se divertir... e nada mal se ganhar uns troquinhos né ?
                </div>
            </div>
			
        </div>
    </div>
</div>        <audio src="sound/start.mp3" id="sound-start"></audio>
                    <audio src="sound/win.mp3" id="sound-win"></audio>
                    <audio src="sound/lose.mp3" id="sound-lose"></audio>
                    <audio src="sound/suspense.mp3" id="sound-suspense"></audio>
                    <audio src="sound/open.mp3" id="sound-open"></audio>
                </div>
            </div>
        </div>
    </div>
    <div class="howit">
    <div class="container">
        <div class="howit__header-block">
            <div class="howit__header-line"></div>
            <h2 class="howit__header-text">Como jogar na <span>Raspadinha Premiada?</span></h2>
            <div class="howit__header-line"></div>
        </div>
		<br><br>
        <div class="howit__card-line">
            <div class="howit__card-wrapper">
                <i class="howit__card-chevron howit__card-chevron_right fa fa-chevron-right" aria-hidden="true"></i>
                <i class="howit__card-chevron howit__card-chevron_bottom fa fa-chevron-down" aria-hidden="true"></i>
                <div class="howit__card">
                    <div class="howit__card-icon-line">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                    </div>
                    <h3 class="howit__card-header">Faça um Depósito</h3>
                    <div class="howit__card-text">Vários métodos para você add crédito em sua carteira</div>
                </div>
            </div>
            <div class="howit__card-wrapper">
                <i class="howit__card-chevron howit__card-chevron_right fa fa-chevron-right" aria-hidden="true"></i>
                <i class="howit__card-chevron howit__card-chevron_bottom fa fa-chevron-down" aria-hidden="true"></i>
                <div class="howit__card">
                    <div class="howit__card-icon-line">
                        <i class="fa fa-ticket" aria-hidden="true"></i>
                    </div>
                    <h3 class="howit__card-header">Defina o Valor da Aposta</h3>
                    <div class="howit__card-text">Você está no controle! Defina o valor que deseja apostar</div>
                </div>
            </div>
            <div class="howit__card-wrapper">
                <i class="howit__card-chevron howit__card-chevron_right fa fa-chevron-right" aria-hidden="true"></i>
                <i class="howit__card-chevron howit__card-chevron_bottom fa fa-chevron-down" aria-hidden="true"></i>
                <div class="howit__card">
                    <div class="howit__card-icon-line">
                        <i class="fa fa-rocket" aria-hidden="true"></i>
                    </div>
                    <h3 class="howit__card-header">Comece a Jogar</h3>
                    <div class="howit__card-text">Raspe 3 cartas idênticas para ganhar a aposta</div>
                </div>
            </div>
            <div class="howit__card-wrapper">
                <div class="howit__card">
                    <div class="howit__card-icon-line">
                        <i class="fa fa-rub" aria-hidden="true"></i>
                    </div>
                    <h3 class="howit__card-header">Programa de Afiliados</h3>
                    <div class="howit__card-text">Convide amigos com seu código de afiliado e ganhe mais!</div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop