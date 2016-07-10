@extends('admin.admin_base')

@section('content')
    <div class='row'>
        <div class='col-md-6 col-md-offset-3'>

          @if(Session::has("tipo"))
            <div class="row">
              <div class="text-center alert alert-dismissible @if(Session::get('tipo') == 'Sucesso') alert-success @else alert-danger @endif" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{{Session::get("tipo")}}!</strong> {{Session::get("mensagem")}}
              </div>
            </div>
          @endif

          <div class="box box-primary-ufop">
            <div class="box-body">
              <form class="form" action="{{url('/ldap/editar')}}" accept-charset="UTF-8" method="post">
                {{ csrf_field() }}

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-server"></i></span>
                  <input type="text" class="form-control" value="{{$ldap->server}}" placeholder="IP do Servidor" name="server" required maxlength="45" data-toggle="tooltip" data-placement="right" title="IP do Servidor" autofocus>
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control" value="{{$ldap->user}}" placeholder="Usuário" name="user" required maxlength="45" data-toggle="tooltip" data-placement="right" title="Usuário">
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                  <input type="text" class="form-control" value="{{$ldap->domain}}" placeholder="Domínio" name="domain" required maxlength="45" data-toggle="tooltip" data-placement="right" title="Domínio">
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" class="form-control" value="{{$ldap->password}}" placeholder="Senha" name="password" required maxlength="45" data-toggle="tooltip" data-placement="right" title="Senha">
                </div>

                <br />

                <div class="text-center">
                  <button type="button" class="btn btn-danger" onClick="history.back()">Cancelar <i class='fa fa-times'></i></button>
                  <button type="reset" class="btn btn-primary">Resetar <i class='fa fa-refresh'></i></button>
                  <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                </div>
              </form>
            </div>
          </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
