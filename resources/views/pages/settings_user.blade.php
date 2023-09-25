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
						<span class="profile__content-header-tab">Histórico de Apostas</span>
						<a class="profile__content-header-tab" href="/profile/pays">Depósitos</a>
						<a class="profile__content-header-tab" href="/profile/withdraws">Saques</a>
						<a class="profile__content-header-tab" href="/profile/partner">Programa de Afiliados</a>
						<a class="profile__content-header-tab profile__content-header-tab_active" href="/profile/settings">Configurações</a>
					</div>	
					<div class="profile__content-container">
						@if(!isset($user->cpf) && !isset($user->pix))
							@if($errors->any())
	                            <h4>{{$errors->first()}}</h4>
	                        @endif
	                        @if(session('success'))
	                            <div class="alert alert-success">
	                                {{session('success')}}
	                            </div>
	                        @endif
							
							<form action="/profile/settings" method="post">
								{{ csrf_field() }}
								<div class="modal__info-block">
									<div class="modal__pay-input-wrapper input-block">
										<div class="input-block__input-wrapper">
			                            	<input name="cpf" type="text" class="input-block__input cpf" placeholder="Insira o CPF" required>
			                        	</div>
			                        </div>
			                        <div class="modal__pay-input-wrapper input-block">
			                        	<div class="input-block__input-wrapper">
			                            	<input name="pix" type="text" class="input-block__input" placeholder="Insira o PIX" required>
			                        	</div>	
		                        	</div>					 
								    <div class="button-line button-line_center" style="margin-top: 0.5rem;">
			                        	<button class="button-round button-round_ib" type="submit">Salvar</button>
			                       </div>
			                   </div>
							</form>
						@else
							<p><b>CPF:</b> <span class="cpf">{{ $user->cpf }}</span></p>
							<p><b>PIX:</b> <span class="">{{ $user->pix }}</span></p>
						@endif
					</div>				
				</div>
			</div>
		</div>
	</div>
</div>
@stop