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
								
                                <a href="/admin/user/{{$user->id}}" class="btn btn-success btn-custom btn-rounded waves-effect waves-light" style="margin-bottom: 1em;">
                                    Voltar                                    
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-9 col-md-8">
                        <div class="card-box">
                            @if($errors->any())
                                <h4>{{$errors->first()}}</h4>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{session('success')}}
                                </div>
                            @endif
                            <form class="form-horizontal group-border-dashed" action="/admin/user/{{$user->id}}/password" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Senha</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" required name="password">
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