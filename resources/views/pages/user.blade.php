@extends('layout')

@section('title')
Jogo da Raspadinha - {{$user->username}}
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
            <h1 class="navigator-line__text"><span>Perfil de Usuário</span></h1>
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
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                    <div class="profile__content-wrapper">
                        <div class="profile__content-header">
                            <span class="profile__content-header-tab profile__content-header-tab_active">Histórico de Apostas</span>
                        </div>
                        <div class="profile__content-container">
                            <div class="profile__history-wrapper">
                                <div class="row">
									@foreach($drops as $d)
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
										<div class="profile__history-block">
											<img src="/storage/img/150/planet-{{$d->planet}}.png" alt="" class="profile__history-block-img">
											<div class="profile__history-value-wrapper">
												<span class="profile__history-value">{{$d->win}}</span>
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
</div>
@stop