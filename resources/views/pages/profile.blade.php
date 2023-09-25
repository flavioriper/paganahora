@extends('layout')

@section('title')
Jogo da Raspadinha - História do Jogo
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
							<img src="{{$user->avatar}}" alt="" class="profile__ava-img">
						</div>
					</div>
					<div class="profile__ava-name">{{$user->username}}</div>
					<div class="profile__ava-balance">
						<i class="fa fa-money" aria-hidden="true"></i>
<span class="profile__ava-balance-value">{{$user->money}}</span>
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
					<form action="/logout" method="GET">
						<input type="hidden" name="_token" value="S5AjEKYMjbntHqbtursX5z13FmUyABSTSeiCs1jS">
						<button type="submit" class="button-round button-round_long button-round_m-top button-round_trans-dark">
						<i class="button-round__icon button-round__icon_f-left fa fa-sign-out" aria-hidden="true"></i>
						Sair
						<i class="button-round__icon button-round__icon_f-right fa fa-chevron-right" aria-hidden="true"></i>
						</button>
					</form>
				</div>
			</div>
			<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
				<div class="profile__content-wrapper">
					<div class="profile__content-header">
<span class="profile__content-header-tab profile__content-header-tab_active">Histórico de Apostas</span>
<a class="profile__content-header-tab" href="/profile/pays">Depósitos</a>
<a class="profile__content-header-tab" href="/profile/withdraws">Saques</a>
<a class="profile__content-header-tab" href="/profile/partner">Programa de Afiliados</a>
<a class="profile__content-header-tab" href="/profile/settings">Configurações</a>
					</div>
					<div class="profile__content-container">
						<div class="profile__history-wrapper">
							<div class="row">
								@foreach($drops as $drop)
								<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
									<div class="profile__history-block">
										<img src="/storage/img/150/planet-{{$drop->planet}}.png" alt="" class="profile__history-block-img">
										<div class="profile__history-value-wrapper">
<span class="profile__history-value">{{$drop->win}}</span>
										</div>
									</div>
								</div>
								@endforeach
							</div>
							@if(count($drops) == 12)
							<div class="button-line button-line_center button-line_m-top">
								<button class="button-round button-round_ib" id="profile-private-more" data-user-id="{{$user->id}}">Carregar Mais</button>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop