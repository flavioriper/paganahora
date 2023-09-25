@extends('layout')

@section('title')
Raspadinha Premiada - Programa de Afiliados
@stop

@section('content')
<script src="/js/upload.js?id=a225aa49814ad48f61ae"></script>
<div class="navigator-line">
	<div class="container">
		<div class="navigator-line__wrapper">
			<button onclick="window.location.href = '/'" class="button-round button-round_trans-dark">
				<i class="button-round__icon button-round__icon_f-left fa fa-chevron-left" aria-hidden="true"></i>
				Voltar
			</button>
			<h1 class="navigator-line__text">Backoffice</h1>
		</div>
	</div>
</div>
<div class="profile">
        <div class="container container_full-width">
            <div class="profile__wrapper">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
    <div class="profile__ava-block-wrapper">
    <input id="upload-image" style="display:none;" type="file" onchange="uploadImage(this)">
					<div class="profile__ava-block" style="cursor: pointer;" onclick="$('#upload-image').click()">
            <div class="profile__ava">
                <img src="{{Auth::user()->avatar}}" alt="" class="profile__ava-img">
            </div>
        </div>
        <div class="profile__ava-name">{{Auth::user()->username}}</div>
        <div class="profile__ava-balance">
            <i class="fa fa-money" aria-hidden="true"></i>
            <span class="profile__ava-balance-value">{{Auth::user()->money}}</span>
        </div>
        
    </div>
    <div class="button-line button-line_m-top">
					<!--button-round_disable-->
@if(!Auth::guest() && Auth::user()->is_admin === 1)
                    <button type="admin" class="button-round button-round_long button-round_m-top button-round_trans-dark">
<a target="_blank" href="admin"><font color="#FFFFFF">Painel <span class="hidden-sm hidden-md">Administrativo</span></font></a>
					<i class="button-round__icon button-round__icon_f-right fa fa-chevron-right" aria-hidden="false"></i>
					</button>
@endif
					<button data-modal="payin" class="modal-activate button-round button-round_long button-round_m-top">
					<i class="button-round__icon button-round__icon_f-left fa fa-credit-card" aria-hidden="true"></i>
					Fazer Depósito
            <i class="button-round__icon button-round__icon_f-right fa fa-chevron-right" aria-hidden="true"></i>
        </button>
        <button data-modal="payout" class="modal-activate button-round button-round_long button-round_m-top button-round_dark">
            <i class="button-round__icon button-round__icon_f-left fa fa-money" aria-hidden="true"></i>
            Solicitar Saque
            <i class="button-round__icon button-round__icon_f-right fa fa-chevron-right" aria-hidden="true"></i>
        </button>
        <button data-modal="promo" class="modal-activate button-round button-round_long button-round_m-top button-round_trans">
            <i class="button-round__icon button-round__icon_f-left fa fa-gift" aria-hidden="true"></i>
            Código <span class="hidden-sm hidden-md">Promocional</span>
            <i class="button-round__icon button-round__icon_f-right fa fa-chevron-right" aria-hidden="true"></i>
        </button>
        <form action="/logout" method="post">
            <input type="hidden" name="_token" value="g86Qd8FqAnxGVop8apubq8wv8UKQ3wnYoLK5RnRd">
            <button type="submit" class="button-round button-round_long button-round_m-top button-round_trans-dark">
                <i class="button-round__icon button-round__icon_f-left fa fa-sign-out" aria-hidden="true"></i>
                Sair
                <i class="button-round__icon button-round__icon_f-right fa fa-chevron-right" aria-hidden="true"></i>
            </button>
        </form>
    </div>
</div>                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                        <div class="profile__content-wrapper">
                            <div class="profile__content-header">
<a class="profile__content-header-tab" href="/profile">Histórico de Apostas</a>
<a class="profile__content-header-tab" href="/profile/pays">Depósitos</a>
<a class="profile__content-header-tab" href="/profile/withdraws">Saques</a>
<span class="profile__content-header-tab profile__content-header-tab_active">Programa de Afiliados</span>
<a class="profile__content-header-tab" href="/profile/settings">Configurações</a>
                            </div>
                            <div class="profile__content-container">
                                <div class="profile__refprogram">
                                    <div class="profile__refprogram-text">
									@php
									$settings = \DB::table('settings')->where('id', 1)->first();
									@endphp
<p>Convide seus amigos e receba {{$settings->promo_percent}}% de todos os depósitos que seus amigos fizerem!</p><br>
<p>Tudo funciona de maneira muito simples: envie a eles o link do site para eles fazerem seu cadastro em nossa plataforma.</p><br>
<p>Após seu indicado fazer o registro e inserir seu código de afiliado abaixo ele receberá R$ {{$settings->promo_sum}} !<br>
Você receberá {{$settings->promo_percent}}% de cada depósito que seu afiliado fizer.</p><br>
<p>O dinheiro ganho através do programa de afiliados fica imediatamente disponível para retirada ou uso na plataforma!</p>
</div>
<div class="profile__refprogram-code-block">
Seu código de afiliados é:  <span class="profile__refprogram-code">{{Auth::user()->ref_code}}</span>
</div>
<div class="profile__refprogram-text">
Passe o código acima para seu afiliado poder resgatar seu BÔNUS e se tornar um afiliado seu e você passará a ganhar {{$settings->promo_percent}}% de cada depósito que ele fizer.</p>
</div>
                                    <div class="profile__refprogram-text profile__refprogram-text_center profile__refprogram-text_gray">
É proibido: registrar mais de 1 conta e inserir seu próprio código promocional para enganar o programa de afiliados e enviar spam. Estas violações terão como consequencias o bloqueio de sua conta.
                                    </div>
                                    <br>
                                    <h2>Seus Afiliados:</h2>
                                    <div class="table">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th class="table__th">Afiliado</th>
                                                <th class="table__th">Data</th>
                                            </tr>
                                            </thead>
                                            <tbody>
											@if(count($vvod) > 0)
											@foreach($vvod as $v)
												<tr>
													<td class="table__td">{{$v->user->username}}</td>
													<td class="table__td">{{$v->created_at}}</td>
												</tr>
											@endforeach
											@endif
											</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop