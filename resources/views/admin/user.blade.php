@extends('admin.layout')

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="wraper container">
                <div class="row">
                    <div class="col-md-4 col-lg-3">
                        <div class="profile-detail card-box">
                            <div>
                                <img src="/{{$user->avatar}}" class="img-circle" alt="profile-image">

                                <h4>{{$user->username}}</h4>

                                <ul class="list-inline status-list m-t-20">
                                    <li>
                                        <h3 class="text-primary m-b-5">{{$user->countGames}}</h3>
                                        <p class="text-muted">Número de Apostas</p>
                                    </li>

                                    <li>
                                        <h3 class="text-success m-b-5">R$ {{$user->winGames}}</h3>
                                        <p class="text-muted">Ganhos em Apostas</p>
                                    </li>
                                </ul>
								
                                <a href="/user/{{$user->id}}" target="_blank">
                                    <button type="button" class="btn btn-success btn-custom btn-rounded waves-effect waves-light" style="margin-bottom: 1em;">
                                        Perfil do Apostador
                                    </button>
                                </a>
                                <a href="/admin/user/{{$user->id}}/password" class="btn btn-pink btn-custom btn-rounded waves-effect waves-light">
                                    Alterar Senha
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-9 col-md-8">
                        <div class="card-box">
                            <form class="form-horizontal group-border-dashed" action="/admin/saveUser" novalidate="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Nome de usuário</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="" value="{{$user->username}}" name="username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">CPF</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control cpf" required="" value="{{$user->cpf}}" name="cpf">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">PIX</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="" value="{{$user->pix}}" name="pix">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Avatar do usuário</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="" value="{{$user->avatar}}" name="avatar" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Email de  cadastro</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="" value="{{$user->email}}" name="email" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Saldo em carteira</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="" value="{{$user->money}}" name="money">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Código de Afiliado</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" value="{{$user->ref_code}}" name="ref_code">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Código de Bônus usado</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" value="{{$user->ref_use}}" name="ref_use">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Administrador</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2" required name="is_admin">
                                            @if($user->is_admin == 1)
                                                <option value="0">Não</option>
                                                <option value="1" selected>Sim</option>
											@elseif($user->is_admin == 0)
												<option value="0" selected>Não</option>
												<option value="1">Sim</option>
											@endif
                                        </select>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3 control-label">Apostador</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2" required name="is_yt">
											@if($user->is_yt == 1)
                                                <option value="0">Não</option>
                                                <option value="1" selected>Sim</option>
											@elseif($user->is_yt == 0)
												<option value="0" selected>Não</option>
												<option value="1">Sim</option>
											@endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Registrado</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" disabled value="{{$user->created_at}}">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9 m-t-15">
                                        <button type="submit" class="btn btn-primary">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script src="/js/jquery.mask.js"></script>
<script>
    $(function() {
        $('.cpf').mask('000.000.000-00', {reverse: true});
    });
</script>
@endpush