@extends('admin.layout')

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="/admin/saveSettings">
                            <div class="card-box">
                                <h4 class="m-t-0 header-title"><b>Configurações da Plataforma</b></h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-20">
                                            <h5><b>Chance de retorno do jogo para Casa</b></h5>
                                            <p class="text-muted m-b-15 font-13">
                                                Número positivo maior que 0, mas menor que 100
                                            </p>
<input type="number" value="{{$settings->yt_chance}}" class="form-control" maxlength="25" name="yt_chance">
                                        </div>
										<div class="p-20">
                                            <h5><b>Chance de Retorno para Apostador</b></h5>
                                            <p class="text-muted m-b-15 font-13">
												Número positivo maior que 0, mas menor que 100
                                            </p>
<input type="number" value="{{$settings->chance}}" class="form-control" maxlength="25" name="chance">
                                        </div>
                                        <div class="p-20">
                                            <h5><b>Valor de pagamento para referência de afiliado</b></h5>
                                            <p class="text-muted m-b-15 font-13">
                                                Quando o usuário ativar o código, ele receberá:
                                            </p>
                                            <input type="number" value="{{$settings->promo_sum}}" class="form-control" maxlength="25" name="promo_sum">
                                        </div>
										<div class="p-20">
                                            <h5><b>Porcentagem de ganho do afiliado por cada depósito de seu afiliado: </b></h5>
                                            <p class="text-muted m-b-15 font-13">
                                                Bônus do reabastecimento do usuário para seu indicado:
                                            </p>
                                            <input type="number" value="{{$settings->promo_percent}}" class="form-control" maxlength="25" name="promo_percent">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
										<div class="p-20">
                                            <h5><b>Valor mínimo para Saque</b></h5>
                                            <p class="text-muted m-b-15 font-13">
                                                Defina o valor minímo para pedido de Saque
                                            </p>
                                            <input type="number" value="{{$settings->min_with}}" class="form-control" maxlength="25" name="min_with">
                                        </div>
										<div class="p-20">
                                            <h5><b>Aposta mínima por jogo</b></h5>
                                            <p class="text-muted m-b-15 font-13">
                                                O valor mínimo abaixo do qual não será possível apostar
                                            </p>
                                            <input type="number" value="{{$settings->min_bet}}" class="form-control" maxlength="25" name="min_bet">
                                    </div>

                                    <button type="submit" class="btn btn-purple waves-effect waves-light">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection