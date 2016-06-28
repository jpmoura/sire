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
            <form class="form" action="{{url('/usuarios/editar')}}" accept-charset="UTF-8" method="post">
              {{ csrf_field() }}

              <input type="hidden" name="id" value="{{$usuario->id}}">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                <input class="form-control" type="text" placeholder="ID {{$usuario->id}}" disabled data-toggle="tooltip" data-placement="right" title="ID do usuário">
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" value="{{$usuario->nome}}" name="nome" required maxlength="50" data-toggle="tooltip" data-placement="right" title="Nome. Máximo de 50 caracteres.">
              </div>

              <div class="input-group @if(Session::get('mensagem') == 'O login já existe!') has-error @endif">
                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                <input type="text" class="form-control" @if(Session::get('mensagem') == 'O login já existe!') value="" autofocus @else value="{{$usuario->login}}" @endif name="login" @if(Session::get('mensagem') == 'Login já existe!') autofocus @endif required maxlength="20" data-toggle="tooltip" data-placement="right" title="Login. Máximo de 20 caracteres.">
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="Senha" value="{{ $usuario->senha }}" name="senha" required maxlength="40" data-toggle="tooltip" data-placement="right" title="Senha. Máximo de 40 caracteres.">
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control" value="{{$usuario->email}}" name="email" required maxlength="50" data-toggle="tooltip" data-placement="right" title="E-mail. Máximo de 50 caracteres.">
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control" value="{{$usuario->telefone}}" name="telefone" required maxlength="15" data-toggle="tooltip" data-placement="right" title="Telefone fixo. Máximo de 15 Caracteres.">
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                <input type="text" class="form-control" value="{{$usuario->celular}}" name="celular" required maxlength="15" data-toggle="tooltip" data-placement="right" title="Telefone móvel. Máximo de 15 caracteres.">
              </div>

              @if(Session::get("nivel") == 2)
                <input class="form-control" type="hidden" name="nivel" placeholder="ID {{$usuario->nivel}}">
              @else
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                  <select class="form-control" name="nivel" required data-toggle="tooltip" data-placement="right" title="Nível de privilégio do usuário.">
                    <option value="">Selecione</option>
                    <option value="1" @if($usuario->nivel == 1) selected @endif>Administrador</option>
                    <option value="2" @if($usuario->nivel == 2) selected @endif>Professor</option>
                  </select>
                </div>
              @endif
              <br />
              <div class="text-center">
                <button type="reset" class="btn btn-warning">Limpar <i class='fa fa-eraser'></i></button>
                <button type="button" class="btn btn-danger" onClick="history.back()">Cancelar <i class='fa fa-times'></i></button>
                <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
              </div>
            </form>
          </div>
        </div>
      </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
