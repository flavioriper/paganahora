<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
		<link rel="stylesheet" href="/js/jquery.arcticmodal-0.3.css" type="text/css">
    <title>@yield('title')</title>
	<!-- Developer www.agencianaweb.com.br -->
	<meta http-equiv="Content-Language" content="pt-br">
	<meta name="document-classification" content="Site Institucional">
	<meta name="REVISIT-AGENCIANAWEB" content="1 days">
	<meta name="LANGUAGE" content="Portuguese">
	<meta name="COPYRIGHT" content="www.agencianaweb.com.br">
	<meta name="robots" content="all"/>
	<meta name="googlebot" content="all"/>
	<meta name="audience" content="all">
	<meta name="copyright" content="Copyright (c) AgÃªncia na Web. Todos os Direitos Reservados.">
    <meta name="description" content="Jogo da Raspadinha é um jogo de loteria online instantânea que você pode ganhar dinheiro real, é bem simples, você deve abrir 3 cartas idênticas. Comece a ganhar com Jogo da Raspadinha agora mesmo!" />
    <link href="/css/app.css?id=4870563c1f14bcdb1ca7" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<script type="text/javascript" src="/js/socket.io-1.4.5.js"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery-1.11.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.arcticmodal-0.3.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.animateNumber.min.js') }}"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
	<script>
		@php
		$settings = \DB::table('settings')->where('id', 1)->first(); 
		@endphp
        var min_bet = {{$settings->min_bet}};
        var is_pix = {{ isset(Auth::user()->pix)?1:0 }}
        var is_cpf = {{ isset(Auth::user()->pix)?1:0 }}
    </script>
    <meta name="theme-color" content="#ffffff">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Raspadinha Premiada">
    <meta property="og:url" content="/">
    <meta property="og:image" content="/android-chrome-256x256.png">
    <meta property="business:contact_data:country_name" content="Brazil">
    <base href="/">
</head>
<body>
<header class="header">
    <div class="container">
        <div class="header__wrapper">
            <div class="header__element header__element_static">
                <div data-modal="h-menu" class="visible-xs modal-activate header__menu-button">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
            </div>

            <div class="header__element header__element_static">
                <a href="/" class="header__logo-link">
                    <img src="/storage/img/logo_big.png" alt="" class="header__logo header__logo_big">
                    <img src="/storage/img/logo_big.png" alt="" class="header__logo header__logo_small">
                </a>
            </div>

            <div class="header__element">
                <nav>
                    <ul class="header__nav-line">
                        <li class="header__nav-link">
                            <a href="/">Home</a>
                        </li>
                        <li class="header__nav-link">
							@if(Auth::guest())
							<a data-modal="reg" class="modal-activate">Bônus</a>
							@else
							<a data-modal="promo" class="modal-activate">Bônus</a>
							@endif
						</li>
                        <li class="header__nav-link">
                            <a href="/help">FAQ</a>
                        </li>
						<li class="header__nav-link">
						@if(Auth::guest())
							<a data-modal="reg" class="modal-activate">Backoffice</a>
						@else
							<a href="/profile/partner">Backoffice</a>
						@endif
						</li>
                    </ul>
                </nav>
            </div>
			@if(Auth::guest())
				<div class="header__element header__element_static">
					<button data-modal="reg" class="modal-activate button-round"><i class="visible-xs fa fa-sign-in" aria-hidden="true"></i><span class="hidden-xs">Entrar / Cadastre-se</span></button>
				</div>
			@else
			<div class="header__element header__element_static">
                <div class="header__user-block">
                    <a href="/profile" class="hidden-xs header__user-profile-link">Backoffice</a>
                    <div class="header__user-balance">
<span class="rouble">R$ </span><span class="header__user-balance-value" data-value="{{Auth::user()->money}}" id="balance">{{Auth::user()->money}}</span>

                        
                    </div>
                    <div class="header__user-cash">
                        <div data-modal="payin" class="modal-activate header__user-cash-button header__user-cash-button_in"><i class="fa fa-plus-circle" aria-hidden="true"></i>Depositar</div>
                        <div id="sacar" data-modal="payout" class="modal-activate header__user-cash-button header__user-cash-button_out"><i class="fa fa-minus-circle" aria-hidden="true"></i>Sacar</div>
                    </div>
                    <div class="header__user-ava-wrapper">
                        <a href="/profile" class="header__user-ava">
                            <img src="{{Auth::user()->avatar}}" alt="" class="header__user-ava-img">
                        </a>
                    </div>
                </div>
            </div>
			@endif
                    </div>
    </div>
</header><main>
@yield('content')     
</main>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                <div class="footer__block">
                    <div class="footer__block-header">Raspadinha Premiada</div>
                    <div class="footer__block-text">Bem-vindo à Raspadinha Premiada!</div>
                    <div class="footer__block-text">Você está em uma loteria instantânea onde pode tentar a sorte e comprar bilhetes raspe e ganhe. Não perca sua chance!</div>
                    <div class="footer__block-text footer__block-text_link">
<a href="/terms">Termos de Uso</a>  |  <a href="/policy">Política de Privacidade</a>
                    </div>
                    <div class="footer__block-text">Copyright © 2023. Todos os direitos reservados</div>
                </div>
            </div>
            <div class="col-xs-5 col-sm-2 col-md-3 col-lg-3">
                <div class="footer__block">
                    <div class="footer__block-header">Links Rápidos</div>
                    <div class="footer__nav-block">
                        <div class="footer__nav-link">
                            <a href="/">Página Inicial</a>
                        </div>
                        <div class="footer__nav-link">
						@if(Auth::guest())
							<a data-modal="reg" class="modal-activate">Bônus de Cadastro</a>
						@else
							<a data-modal="promo" class="modal-activate">Bônus de Cadastro</a>
						@endif
						</div>
                        <div class="footer__nav-link">
                            <a href="/help">Perguntas Frequentes</a>
                        </div>
                        <div class="footer__nav-link">
						@if(Auth::guest())
							<a data-modal="reg" class="modal-activate">Backoffice</a>
						@else
							<a href="/profile/partner">Backoffice</a>
						@endif
						</div>
                    </div>
                </div>
            </div>
            <div class="col-xs-7 col-sm-5 col-md-3 col-lg-3">
                <div class="footer__block">
                    <div class="footer__block-header">Formas de Pagamentos</div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="footer__ps-logo">
                                <img src="/storage/img/pix.svg" alt="" class="footer__ps-logo-img">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="footer__ps-logo">
                                <img src="/storage/img/visa_footer.svg" alt="" class="footer__ps-logo-img">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="footer__ps-logo">
                                <img src="/storage/img/mc_footer.svg" alt="" class="footer__ps-logo-img">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="footer__ps-logo">
                                <img src="/storage/img/qiwi_footer.svg" alt="" class="footer__ps-logo-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<a href="https://wa.me/5581996563726?text=Olá"
    style="position:fixed;width:60px;height:60px;bottom:40px;right:40px;background-color:#25d366;color:#FFF;border-radius:50px;text-align:center;font-size:30px;box-shadow: 1px 1px 2px #fff;z-index:1000;" target="_blank">
    <i style="margin-top:16px" class="fa fa-whatsapp"></i>
</a>
<noindex>
    
    <div id="h-menu" class="modal">
    <div class="modal__wrapper modal__wrapper_top">
        <div data-modal="h-menu" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__h-menu">
            <div data-modal="h-menu" class="modal-disactivate modal__h-menu-close">
                <img src="/storage/img/cross_y.png" alt="" class="">
            </div>
            <ul class="modal__h-menu-line">
                <li class="modal__h-menu-link">
                    <a href="/">
                        <span class="modal__h-menu-link-line"></span>
                        <span class="modal__h-menu-link-value">Home</span>
                        <span class="modal__h-menu-link-line"></span>
                    </a>
                </li>
                <li class="modal__h-menu-link">
						@if(Auth::guest())
						<a href="#" data-modal="reg" class="modal-activate">
                            <span class="modal__h-menu-link-line"></span>
                            <span class="modal__h-menu-link-value">Bônus</span>
                            <span class="modal__h-menu-link-line"></span>
                        </a>
						@else
						<a data-modal="promo" class="modal-activate">
                            <span class="modal__h-menu-link-line"></span>
                            <span class="modal__h-menu-link-value">Bônus</span>
                            <span class="modal__h-menu-link-line"></span>
                        </a>
						@endif
				</li>
                <li class="modal__h-menu-link">
                    <a href="/help">
                        <span class="modal__h-menu-link-line"></span>
                        <span class="modal__h-menu-link-value">FAQ</span>
                        <span class="modal__h-menu-link-line"></span>
                    </a>
                </li>
                <li class="modal__h-menu-link">
						@if(Auth::guest())
						<a data-modal="reg" class="modal-activate">
                            <span class="modal__h-menu-link-line"></span>
                            <span class="modal__h-menu-link-value">Backoffice</span>
                            <span class="modal__h-menu-link-line"></span>
                        </a>
						@else
						<a href="/profile/partner">
                            <span class="modal__h-menu-link-line"></span>
                            <span class="modal__h-menu-link-value">Backoffice</span>
                            <span class="modal__h-menu-link-line"></span>
                        </a>
						@endif
				</li>
            </ul>
        </div>
    </div>
</div>    
<div id="dialog" class="modal">
    <div class="modal__wrapper">
        <div data-modal="dialog" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_no-pad-bot">
            <div class="modal__window-wrapper">
                <div class="modal__header"></div>
                <div class="modal__info-block">
                    <div class="modal__info-text-block">
                        <div class="modal__info-text"></div>
                    </div>
                    <div class="button-line button-line_center">
                        <button class="button-round button-round_ib button-yes"></button>
                        <button class="button-round button-round_trans-dark button-round_ib button-no"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
<div id="info" class="modal">
    <div class="modal__wrapper">
        <div data-modal="info" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_no-pad-bot">
            <div class="modal__window-wrapper">
                <div data-modal="info" class="modal-disactivate modal__close-button">
                    <img src="/storage/img/cross_d.png" alt="" class="modal__close-button-img modal__close-button-img_main">
                    <img src="/storage/img/cross_y.png" alt="" class="modal__close-button-img modal__close-button-img_hover">
                </div>
                <div class="modal__header"><span></span></div>
                <div class="modal__info-block">
                    <div class="modal__info-text-block">
                        <div class="modal__info-text"></div>
                    </div>
                    <div class="button-line button-line_center">
                        <button data-modal="info" class="modal-disactivate button-round button-round_ib">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
        
<div id="promo" class="modal">
    <div class="modal__wrapper">
        <div data-modal="promo" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_no-pad-bot">
            <div class="modal__window-wrapper">
                <div data-modal="promo" class="modal-disactivate modal__close-button">
                    <img src="/storage/img/cross_d.png" alt="" class="modal__close-button-img modal__close-button-img_main">
                    <img src="/storage/img/cross_y.png" alt="" class="modal__close-button-img modal__close-button-img_hover">
                </div>
                <div class="modal__header">Código Promocional</div>
                <div class="modal__info-block">
                    <div class="modal__info-text-block">
                        <div class="modal__info-text modal__info-text_center">
                            <span class="gray">O código promocional pode ser inserido <span class="yellow">apenas uma vez</span></span>
                        </div>
                    </div>
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input type="text" class="input-block__input" placeholder="Insira o código promocional" id="promocode-input" value="">
                        </div>
                    </div>
                    <div class="button-line button-line_center">
                        <button class="button-round button-round_ib" id="btn-promocode">Resgatar Código</button>
                    </div>
                </div>
                <div class="hidden modal__info-block">
                    <div class="modal__info-text-block">
                        <div class="modal__info-text modal__info-text_center">Você já resgatou o código promocional, <span class="yellow">não é possível resgatar novamente</span></div>
                    </div>
                    <div class="button-line button-line_center">
                        <button class="button-round button-round_ib">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>        
<div id="payin" class="modal">
    <div class="modal__wrapper">
        <div data-modal="payin" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_no-pad-bot">
            <div class="modal__window-wrapper">
                <div data-modal="payin" class="modal-disactivate modal__close-button">
                    <img src="/storage/img/cross_d.png" alt="" class="modal__close-button-img modal__close-button-img_main">
                    <img src="/storage/img/cross_y.png" alt="" class="modal__close-button-img modal__close-button-img_hover">
                </div>
                <div class="modal__header">Depositar Dinheiro na Carteira</div>
                <div class="modal__pay">
                    <div class="modal__pay-ps">
                        <div class="modal__ps-wrapper">
                            <div data-modal="payin" class="modal__pay_next modal__ps-block modal__ps-block_active" data-currency="94" data-provider="0">
                                <div class="modal__ps-block-arrow"></div>
                                <div class="modal__ps-name">PIX</div>
                                <img src="/storage/img/pix.png" alt="" class="modal__ps-img">
                            </div>
 <!-- Exemplo para outros gateways                         
                            <div data-modal="payin" class="modal__pay_next modal__ps-block" data-currency="84" data-provider="3">
                                <div class="modal__ps-block-arrow"></div>
                                <div class="modal__ps-name">Boleto Bancario</div>
                                <img src="/storage/img/mts_color.png" alt="" class="modal__ps-img">
                            </div>
                            <div data-modal="payin" class="modal__pay_next modal__ps-block" data-currency="83" data-provider="3">
                                <div class="modal__ps-block-arrow"></div>
                                <div class="modal__ps-name">Cartão de Credito</div>
                                <img src="/storage/img/beeline_color.png" alt="" class="modal__ps-img">
                            </div>
 Exemplo para outros gateways    --->
                        </div>
                    </div>
                    <div class="modal__pay-info">
                        <div class="modal__pay-header">
                            <span data-modal="payin" class="modal__pay_prev modal__ps-toggle-button visible-xs-inline-block">
                                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                <span class="modal__pay-header-value">PIX</span>
                            </span>
                            <span class="hidden-xs modal__pay-header-value">PIX</span>
                        </div>
                        <div id="payin-val" class="modal__pay-input-wrapper input-block">
                            <div data-input="payin-val-input" class="input-block__down-button input-block__button input-block__button_left"><i class="fa fa-minus" aria-hidden="true"></i></div>
                            <div data-input="payin-val-input" class="input-block__up-button input-block__button input-block__button_right"><i class="fa fa-plus" aria-hidden="true"></i></div>
                            <div class="input-block__input-wrapper">

                                <input   data-input="payin-val" class="input-block__input"  name="vol" type="number"  placeholder="0"  min="5" max="1000" id="payin-val-input">
                            </div>
  
                        </div>
                        <div class="modal__pay-text-block">
                            <div class="modal__pay-text">
                                Valor Mínimo<span class="modal__pay-text_unstable"> para depósito</span>:
                                <span data-input="payin-val-input" class="modal__pay-pattern-minmax input-block__pattern-block input-block__pattern">
                                <span class="rouble">R$</span><span class="input-block__pattern-value">5</span>
                            </span>
                            </div>
                            <div class="modal__pay-text">
                                Valor Máximo<span class="modal__pay-text_unstable"> para depósito</span>:
                                <span data-input="payin-val-input" class="modal__pay-pattern-minmax input-block__pattern-block input-block__pattern">
                                <span class="rouble">R$</span><span class="input-block__pattern-value">1000</span>
                            </span>
                            </div>
                        </div>
                        <div class="button-line button-line_center">
                            <button class="button-round button-round_ib" id="payment-start" data-currency="" data-provider="3">
                                Continuar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<button style="display:none;" data-modal="recovery_password" class="modal-activate button-round" id="btn-recovery-password"></button>
<div id="recovery_password" class="modal">
    <div class="modal__wrapper">
        <div data-modal="recovery_password" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_active">
            <div class="modal__window-wrapper">
                <div data-modal="recovery_password" class="modal-disactivate modal__close-button">
                    <img src="/storage/img/cross_d.png" alt="" class="modal__close-button-img modal__close-button-img_main">
                    <img src="/storage/img/cross_y.png" alt="" class="modal__close-button-img modal__close-button-img_hover">
                </div>
                <div class="modal__header">Recuperação de senha</div>
                <div class="modal__info-block">
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="new-password" type="password" class="input-block__input" placeholder="Nova senha" value="">
                        </div>
                    </div>
                    <div class="modal__info-text-block" id="new-password-error-message-block" style="display: none;">
                        <div class="modal__info-text modal__info-text_center">
                            <span id="new-password-error-message">Enviamos um email para recuperação de senha</span>
                        </div>
                    </div>
                    <div style="display: flex;justify-content: space-around;">
                        <div class="button-line button-line_center">
                            <button class="button-round button-round_ib" onclick="updatePassword()" id="btn-update-pwd">Atualizar senha</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="forgot_password" class="modal">
    <div class="modal__wrapper">
        <div data-modal="forgot_password" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_active">
            <div class="modal__window-wrapper">
                <div data-modal="forgot_password" class="modal-disactivate modal__close-button">
                    <img src="/storage/img/cross_d.png" alt="" class="modal__close-button-img modal__close-button-img_main">
                    <img src="/storage/img/cross_y.png" alt="" class="modal__close-button-img modal__close-button-img_hover">
                </div>
                <div class="modal__header">Recuperação de senha</div>
                <div class="modal__info-block">
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="forget-email" type="text" class="input-block__input" placeholder="Digite seu Email de cadastro" value="">
                        </div>
                    </div>
                    <div class="modal__info-text-block" id="password-recovery-error-message-block" style="display: none;">
                        <div class="modal__info-text modal__info-text_center">
                            <span id="recovery-error-message">Enviamos um email para recuperação de senha</span>
                        </div>
                    </div>
                    <div style="display: flex;justify-content: space-around;">
                        <div class="button-line button-line_center">
                            <button class="button-round button-round_ib" onclick="recovery()" id="btn-recovery">Recuperar Senha</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="reg" class="modal">
    <div class="modal__wrapper">
        <div data-modal="reg" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_active">
            <div class="modal__window-wrapper">
                <div data-modal="reg" class="modal-disactivate modal__close-button">
                    <img src="/storage/img/cross_d.png" alt="" class="modal__close-button-img modal__close-button-img_main">
                    <img src="/storage/img/cross_y.png" alt="" class="modal__close-button-img modal__close-button-img_hover">
                </div>
                <div class="modal__header">Login</div>
                <div class="modal__info-block">
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="login-username" type="text" class="input-block__input" placeholder="Usuário" value="">
                        </div>
                    </div>
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="login-password" type="password" class="input-block__input" placeholder="Senha" value="">
                        </div>
                    </div>
                    <div class="modal__info-text-block" id="login-error-message-block" style="display: none;">
                        <div class="modal__info-text modal__info-text_center">
                            <span style="color: red;" id="login-error-message">Usuário e/ou senha incorretos</span>
                        </div>
                    </div>
                    <div class="modal__info-text-block">
                        <div class="modal__info-text modal__info-text_center modal-activate" data-modal="forgot_password">
                            <span style="color: #fb6c6c;cursor:pointer;" data-modal="reg" class="modal-disactivate">Esqueceu sua senha?</span>
                        </div>
                    </div>
                    <div style="display: flex;justify-content: space-around;">
                        <div class="button-line button-line_center">
                            <button class="button-round button-round_ib" onclick="login()" id="btn-login">Login</button>
                        </div>
                        <div class="button-line button-line_center modal-activate" data-modal="register">
                            <button class="button-round button-round_ib modal-disactivate" data-modal="reg" id="btn-goto-register">Cadastrar-se</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="register" class="modal">
    <div class="modal__wrapper">
        <div data-modal="register" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_active">
            <div class="modal__window-wrapper">
                <div data-modal="register" class="modal-disactivate modal__close-button">
                    <img src="/storage/img/cross_d.png" alt="" class="modal__close-button-img modal__close-button-img_main">
                    <img src="/storage/img/cross_y.png" alt="" class="modal__close-button-img modal__close-button-img_hover">
                </div>
                <div class="modal__header">Cadastro</div>
                <div class="modal__info-block">
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="register-name" type="text" class="input-block__input" placeholder="Nome Completo" value="">
                        </div>
                    </div>
                    {{-- <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="register-cpf" type="text" class="input-block__input cpf" placeholder="Digite seu CPF" value="">
                        </div>
                    </div>
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="register-pix" type="text" class="input-block__input" placeholder="Digite seu PIX" value="">
                            <span style="text-align: center;color: #fff;display: block;margin-top: 8px;margin-bottom: -8px;font-size: small;">
                                confira se a chave pix está correto antes de cadastrar
                            </span>
                        </div>
                    </div> --}}
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="register-email" type="text" class="input-block__input" placeholder="Digite seu Email" value="">
                        </div>
                    </div>
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="register-username" type="text" class="input-block__input" placeholder="Usuário para Acesso" value="">
                        </div>
                    </div>
                    <div class="modal__pay-input-wrapper input-block">
                        <div class="input-block__input-wrapper">
                            <input id="register-password" type="password" class="input-block__input" placeholder="Senha de Acesso" value="">
                        </div>
                    </div>
                    <div class="modal__info-text-block" id="register-error-message-block" style="display: none;">
                        <div class="modal__info-text modal__info-text_center">
                            <span style="color: red;" id="register-error-message"></span>
                        </div>
                    </div>
                    <div class="button-line button-line_center">
                        <button class="button-round button-round_ib" onclick="register()" id="btn-register">Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tefway" class="modal">
    <div class="modal__wrapper">
        <div data-modal="tefway" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_active">
            <div class="modal__window-wrapper">
                <div data-modal="tefway" class="modal-disactivate modal__close-button">
                    <img src="/storage/img/cross_d.png" alt="" class="modal__close-button-img modal__close-button-img_main">
                    <img src="/storage/img/cross_y.png" alt="" class="modal__close-button-img modal__close-button-img_hover">
                </div>
                <div class="modal__header">Pagamento com PIX</div>
                <div class="modal__info-block">
                    <img id="img-pix" style="margin-left: 70px;margin-top: 25px;">
                    <input type="hidden" id="pix-code">
                    <div class="button-line button-line_center">
                        <button class="button-round button-round_ib" onclick="window.location = 'profile/pays'">Pagamento efetuado</button>
                    </div>
                    <div class="button-line button-line_center">
                        <button class="button-round button-round_ib" onclick="copyPIX()">Copiar PIX</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <div id="payout" class="modal">
    <div class="modal__wrapper">
        <div data-modal="payout" class="modal-disactivate modal__close-layout"></div>
        <div class="modal__window modal__window_no-pad-bot">
            <div class="modal__window-wrapper">
                <div data-modal="payout" class="modal-disactivate modal__close-button">
                    <img src="/storage/img/cross_d.png" alt="" class="modal__close-button-img modal__close-button-img_main">
                    <img src="/storage/img/cross_y.png" alt="" class="modal__close-button-img modal__close-button-img_hover">
                </div>
                <div class="modal__header">Solicitações de Saque</div>
                <div class="modal__pay">
                    <div class="modal__pay-ps">
                        <div class="modal__ps-wrapper">
                            {{-- <div data-modal="payout" class="modal__pay_next modal__ps-block modal__ps-block_active" data-currency="1" data-provider="3" data-purse="">
                                <div class="modal__ps-block-arrow"></div>
                                <div class="modal__ps-name">Depósito Bancário</div>
                                <img src="/storage/img/deposito-agencianaweb.png" alt="" class="modal__ps-img">
                            </div> --}}
                            <div data-modal="payout" class="modal__pay_next modal__ps-block" data-currency="4" data-provider="3" data-purse="">
                                <div class="modal__ps-block-arrow"></div>
                                <div class="modal__ps-name">PIX</div>
                                <img src="/storage/img/pix.png" alt="" class="modal__ps-img">
                            </div>
                            {{-- <div data-modal="payout" class="modal__pay_next modal__ps-block" data-currency="5" data-provider="3" data-purse="">
                                <div class="modal__ps-block-arrow"></div>
                                <div class="modal__ps-name">Depósito Yandex</div>
                                <img src="/storage/img/ym_color.png" alt="" class="modal__ps-img">
                            </div> --}}
                        </div>
						
                    </div>
                    <div class="modal__pay-info">
                        <div class="modal__pay-header">
                            <span data-modal="payout" class="modal__pay_prev modal__ps-toggle-button visible-xs-inline-block">
                                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                <span class="modal__pay-header-value">Agencia e Digito</span>
                            </span>
                            <span class="hidden-xs modal__pay-header-value">Conta e Digito</span>
                        </div>
                        <div id="payout-val" class="modal__pay-input-wrapper input-block">
                            <div data-input="payout-val-input" class="input-block__down-button input-block__button input-block__button_left"><i class="fa fa-minus" aria-hidden="true"></i></div>
                            <div data-input="payout-val-input" class="input-block__up-button input-block__button input-block__button_right"><i class="fa fa-plus" aria-hidden="true"></i></div>
                            <div class="input-block__input-wrapper">
                                <input data-input="payout-val" id="payout-val-input" type="text" class="input-block__input" placeholder="20" value="20">
                            </div>
                            <div class="input-block__pattern-line">
                                <div data-input="payout-val-input" class="input-block__pattern-block input-block__pattern">
<span class="rouble">R$</span><span class="input-block__pattern-value">100</span>
                                </div>
                                <div data-input="payout-val-input" class="input-block__pattern-block input-block__pattern">
<span class="rouble">R$</span><span class="input-block__pattern-value">500</span>
                                </div>
                                <div data-input="payout-val-input" class="input-block__pattern-block input-block__pattern">
<span class="rouble">R$</span><span class="input-block__pattern-value">1000</span>
                                </div>
                                <div data-input="payout-val-input" class="input-block__pattern-block input-block__pattern">
<span class="rouble">R$</span><span class="input-block__pattern-value">5000</span>
                                </div>
                                <div data-input="payout-val-input" class="input-block__pattern-block input-block__pattern">
<span class="rouble">R$</span><span class="input-block__pattern-value">15000</span>
                                </div>
                            </div>
                        </div>
                        <div id="payout-valet" class="modal__pay-input-wrapper input-block">
                            <div class="input-block__input-wrapper input-block__input-wrapper_no-buttons">

                                <input data-input="payout-valet" id="payout-valet-input" type="text" class="input-block__input input-block__input_left-text" placeholder="Digite Seu pix" />

                            </div>
                        </div>
                        <div class="modal__pay-text-block">
                            <div class="modal__pay-text">
Valor Minímo<span class="modal__pay-text_unstable"> para Saque</span>:
                                <span data-input="payout-val-input" class="modal__pay-pattern-minmax input-block__pattern-block input-block__pattern">
<span class="rouble">R$</span><span class="input-block__pattern-value">{{$settings->min_with}}</span>
                                </span>
                            </div>
                            <div class="modal__pay-text">
Valor Máximo<span class="modal__pay-text_unstable"> para Saque</span>:
                                <span data-input="payout-val-input" class="modal__pay-pattern-minmax input-block__pattern-block input-block__pattern">
<span class="rouble">R$</span><span class="input-block__pattern-value">15000</span>
                                </span>
                            </div>
                        </div>
                        <div class="button-line button-line_center">
                            <button class="button-round button-round_ib" id="payout-start" data-currency="1" data-provider="3" data-purse="">Solicitar Saque</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
</noindex>

<div id="hid" style="display:none;"><a href="//www.free-kassa.ru/" target="_blank"><img src="//www.free-kassa.ru/img/fk_btn/6.png" width="95">
                    </a></div>


<input type="hidden" id="flash_status" value="" />

<script src="/js/app.js?{{ time() }}"></script>
<script src="/js/jquery.mask.js"></script>

<script>
    $(function() {
            $('.cpf').mask('000.000.000-00', {reverse: true});
        });
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-176316023-1');

    $(document).ready(() => {
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        if(params.recovery == 1 && params.hash) {
            $("#btn-recovery-password").click();
        }
    })

    function copyPIX() {
        navigator.clipboard.writeText($("#pix-code").val())
        .then(() => {
            alert("PIX copiado");
        })
        .catch(() => {
            alert("Opps... Algo deu errado");
        });
    }

    function updatePassword() {
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        $("#btn-update-pwd").html("Carregando...");
        $("#btn-update-pwd").attr("disabled", true);
        $("#new-password-error-message-block").hide();

        if(!$("#new-password").val()) {
            $("#new-password-error-message-block").show();
            $("#new-password-error-message").html("A nova senha é obrigatória");
            $("#btn-update-pwd").html("Atualizar senha");
            $("#btn-update-pwd").attr("disabled", false);
            return;
        }

        let n = document.head.querySelector('meta[name="csrf-token"]');
        let url = window.location.origin + "/password-recovery-update";
        let settings = {
            "url": url,
            "method": "POST",
            "timeout": 0,
            "headers": {
                "X-CSRF-TOKEN": n.content,
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "password": $("#new-password").val(),
                "hash": params.hash
            }),
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            if(response.statusCode != 200) {
                $("#new-password-error-message-block").show();
                $("#new-password-error-message").html(response.message);
                $("#btn-update-pwd").attr("disabled", false);
            } else {
                window.location.href = window.location.origin;
            }
        });
    }

    function recovery() {
        $("#btn-recovery").html("Carregando...");
        $("#btn-recovery").attr("disabled", true);
        $("#password-recovery-error-message-block").hide();

        if(!$("#forget-email").val()) {
            $("#password-recovery-error-message-block").show();
            $("#recovery-error-message").html("O email é obrigatório");
            $("#btn-recovery").html("Recuperar");
            $("#btn-recovery").attr("disabled", false);
            return;
        }

        let n = document.head.querySelector('meta[name="csrf-token"]');
        let url = window.location.origin + "/password-recovery";
        let settings = {
            "url": url,
            "method": "POST",
            "timeout": 0,
            "headers": {
                "X-CSRF-TOKEN": n.content,
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "email": $("#forget-email").val()
            }),
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            if(response.statusCode != 200) {
                $("#password-recovery-error-message-block").show();
                $("#recovery-error-message").html(response.message);
                $("#btn-recovery").attr("disabled", false);
            } else {
                $("#password-recovery-error-message-block").show();
                $("#recovery-error-message").html("Enviamos um email para recuperação de senha");
                $("#btn-recovery").attr("disabled", false);
            }
            $("#btn-recovery").html("Recuperar");
        });
    }

    function login() {
        $("#btn-login").html("Carregando...");
        $("#btn-login").attr("disabled", true);
        $("#btn-goto-register").attr("disabled", true);
        $("#login-error-message-block").hide();

        if(!$("#login-username").val() || !$("#login-password").val()) {
            $("#login-error-message-block").show();
            $("#login-error-message").html("Login e senha são obrigatórios");
            $("#btn-login").html("Login");
            $("#btn-login").attr("disabled", false);
            return;
        }

        let n = document.head.querySelector('meta[name="csrf-token"]');
        let url = window.location.origin + "/login";
        let settings = {
            "url": url,
            "method": "POST",
            "timeout": 0,
            "headers": {
                "X-CSRF-TOKEN": n.content,
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "username": $("#login-username").val(),
                "password": $("#login-password").val()
            }),
        };

        $.ajax(settings).done(function (response) {
            if(response.statusCode != 200) {
                $("#login-error-message-block").show();
                $("#login-error-message").html(response.message);
                $("#btn-login").attr("disabled", false);
                $("#btn-goto-register").attr("disabled", false);
            } else {
                window.location.reload();
            }
            $("#btn-login").html("Login");
        });
    }

    function register() {
        $("#btn-register").html("Carregando...");
        $("#btn-register").attr("disabled", true);
        $("#register-error-message-block").hide();

        //if(!$("#register-name").val() || !$("#register-cpf").val() || !$("#register-pix").val() || !$("#register-username").val() || !$("#register-password").val() || !$("#register-email").val()) {
        if(!$("#register-name").val() || !$("#register-username").val() || !$("#register-password").val() || !$("#register-email").val()) {
            $("#register-error-message-block").show();
            $("#register-error-message").html("Todos os campos são obrigatórios para cadastro");
            $("#btn-register").html("Cadastrar");
            $("#btn-register").attr("disabled", false);
            return;
        }

        let n = document.head.querySelector('meta[name="csrf-token"]');
        let url = window.location.origin + "/register";
        let settings = {
            "url": url,
            "method": "POST",
            "timeout": 0,
            "headers": {
                "X-CSRF-TOKEN": n.content,
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "name": $("#register-name").val(),
                //"cpf": $("#register-cpf").val(),
                //"pix": $("#register-pix").val(),
                "username": $("#register-username").val(),
                "password": $("#register-password").val(),
                "email": $("#register-email").val()
            }),
        };

        $.ajax(settings).done(function (response) {
            if(response.statusCode != 200) {
                $("#register-error-message-block").show();
                $("#register-error-message").html(response.message);
                $("#btn-register").attr("disabled", false);
            } else {
                window.location.reload();
            }
            $("#btn-register").html("Cadastrar");
        });
    }
    $('#sacar').on('click', function(){
        if(is_pix == 0){
            window.location.href = '/profile/settings';
        }
    });
</script>

<!-- Schema.org -->
<script type="application/ld+json">
{
    "@context" : "http://schema.org",
    "@type" : "AdultEntertainment",
    "name":"SkyCard",
    "url":"/",
    "aggregateRating":{
        "@type":"AggregateRating",
        "ratingValue":"5",
        "reviewCount":"5"
    },
    "priceRange":"5"
}
</script>
</body>
</html>