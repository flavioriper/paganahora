@extends('admin.layout')

@section('content')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".knob").knob();
        });
    </script>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Estatisticas da Plataforma</h4>
                        <p class="text-muted page-title-alt">Bem-vindo ao PAINEL DE ADMINISTRAÇÃO!</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="widget-bg-color-icon card-box">
                            <div class="bg-icon bg-icon-info pull-left">
                                <i class="md md-attach-money text-info"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="text-dark"><b class="counter">{{$all_win}}</b></h3>
                                <p class="text-muted">Movimentação de Apostas</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="widget-bg-color-icon card-box">
                            <div class="bg-icon bg-icon-info pull-left">
                                <i class="md md-attach-money text-info"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="text-dark"><b class="counter">{{$all_games}}</b></h3>
                                <p class="text-muted">Total de Apostas Jogadas</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="widget-bg-color-icon card-box">
                            <div class="bg-icon bg-icon-info pull-left">
                                <i class="md md-attach-money text-info"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="text-dark"><b class="counter">{{$all_payed}}</b></h3>
                                <p class="text-muted">Depósito de Apostadores</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="widget-bg-color-icon card-box">
                            <div class="bg-icon bg-icon-info pull-left">
                                <i class="md md-attach-money text-info"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="text-dark"><b class="counter">{{$all_with}}</b></h3>
                                <p class="text-muted">Saque de Apostadores</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card-box">
                            <h4 class="text-dark header-title m-t-0 m-b-30">Resumo de Depósitos</h4>

                            <div class="widget-chart text-center">
                                <input class="knob" data-width="150" data-height="150" data-linecap=round
                                       data-fgColor="#34d3eb" value="{{ (int)$pay_today }}" data-skin="tron" data-angleOffset="180"
                                       data-readOnly=true data-thickness=".15"/>
                                <h5 class="text-muted m-t-20">Depósitos de Hoje</h5>
                                <h2 class="font-600">R$ {{$pay_today}}</h2>
                                <ul class="list-inline m-t-15">
                                    <li>
                                        <h5 class="text-muted m-t-20">Depósitos na Semana</h5>
                                        <h4 class="m-b-0">R$ {{$pay_week}}</h4>
                                    </li>
                                    <li>
                                        <h5 class="text-muted m-t-20">Depósitos no Mês</h5>
                                        <h4 class="m-b-0">R$ {{$pay_month}}</h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card-box">
                            <a href="/admin/lastOpen" class="pull-right btn btn-default btn-sm waves-effect waves-light">Ver Mais</a>
                            <h4 class="text-dark header-title m-t-0">Últimas Apostas na Plataforma</h4>
                            <p class="text-muted m-b-30 font-13">
                                Últimas 7 Apostas
                            </p>

                            <div class="table-responsive" style="min-height: 300px; max-height: 300px;  overflow:  hidden; ">
                                <table class="table table-actions-bar">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                         <th>Aposta</th>
                                         <th>Usuário</th>
                                         <th>Ganho/Perda</th>
                                         <th>Lucro da Casa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!--No1-->
									@foreach($last_games as $l)
										<tr>
											<td>{{$l->id}}</td>
											<td>{{$l->bet}}</td>
											<td><a href="/admin/user/{{$l->user_id}}" target="blank">{{$l->user->username}}</a></td>
											<td>R$ {{$l->win}}</td>
											<td>R$ {{ $l->bet - $l->win }}</td>
										</tr>
									@endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->


                <div class="row">

                    <div class="col-lg-4">
                        <div class="card-box">
                            <a href="/admin/lastOrders" class="pull-right btn btn-default btn-sm waves-effect waves-light">Ver Mais</a>
                            <h4 class="m-t-0 m-b-20 header-title"><b>Últimos Depósitos</b></h4>
                            <div class="nicescroll mx-box" style="overflow: hidden; outline: none; min-height: 345px; max-height: 345px;" tabindex="5000">
                                <ul class="list-unstyled transaction-list m-r-5">
									@foreach($last_pays as $lp)
                                    <li>
                                        <i class="ti-download text-success"></i>
                                        <a href="/admin/user/{{$lp->user->id}}" target="blank">
                                            <span class="tran-text">{{$lp->user->username}}</span>
                                        </a>
                                        <span class="pull-right text-success tran-price">R$ +{{$lp->amount}}</span>
                                        <span class="pull-right text-muted">{{$lp->created_at}}</span>
                                        <span class="clearfix"></span>
                                    </li>
									@endforeach
                                </ul>
                            </div>
                        </div>

                    </div>

                    <!-- col -->

                    <div class="col-lg-8">
                        <div class="card-box">
                            <a href="#" class="pull-right btn btn-default btn-sm waves-effect waves-light">Ver Mais</a>
                            <h4 class="text-dark header-title m-t-0">Solicitações recentes de Saque</h4>
                            <p class="text-muted m-b-30 font-13">
                                Últimos 7 pedidos de Saque
                            </p>

                            <div class="table-responsive">
                                <table class="table table-actions-bar">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                         <th>Usuário</th>
                                         <th>Pagamento</th>
                                         <th>Carteira<th>
                                         <th>Valor</th>
                                         <th>Ação</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									@foreach($last_withs as $lw)
                                    <tr>
                                        <td>{{$lw->id}}</td>
                                        <td><a href="/admin/user/{{$lw->user_id}}" target="blank">{{$lw->user->username}}</a></td>
                                        <td>@if($lw->system == 4) QIWI @elseif($lw->system == 1) PIX @elseif($lw->system == 5) Depósito Bancário @endif</td>
                                        <td>{{$lw->wallet}}</td>
                                        <td>{{$lw->amount}}</td>
                                        <td>
                                            <a href="/admin/acceptWithdraw/" class="table-action-btn">Pagar</a>
                                            <span> | </span>
                                            <a href="/admin/declineWithdraw/" class="table-action-btn">Recusar</a>
                                        </td>
                                    </tr>
									@endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->


            </div> <!-- container -->

        </div> <!-- content -->
        <footer class="footer text-right">
            © 2023. All rights reserved. by AG
        </footer>

    </div>
@endsection