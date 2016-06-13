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
              <form class="form" action="{{url('/usuarios/cadastrar')}}" accept-charset="UTF-8" method="post">
                {{ csrf_field() }}

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control" placeholder="Nome do usuário" value="{{Input::old('nome')}}" @if(Session::get("tipo") != "Erro") autofocus @endif name="nome" required maxlength="50" data-toggle="tooltip" data-placement="right" title="Máximo de 50 caracteres.">
                </div>

                <div class="input-group @if(Session::get('mensagem') == 'Login já existe!') has-error @endif">
                  <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                  <input type="text" class="form-control" @if(Session::get('mensagem') == 'Login já existe!') autofocus @endif placeholder="Login" name="login" required maxlength="20" data-toggle="tooltip" data-placement="right" title="Máximo de 20 caracteres.">
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="text" class="form-control" placeholder="Senha" value="{{Input::old('senha')}}" name="senha" required maxlength="40" data-toggle="tooltip" data-placement="right" title="Máximo de 40 caracteres.">
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                  <input type="email" class="form-control" placeholder="E-mail" value="{{Input::old('email')}}" name="email" required maxlength="50" data-toggle="tooltip" data-placement="right" title="Máximo de 50 caracteres.">
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                  <input type="text" class="form-control" placeholder="Telefone fixo" value="{{Input::old('telefone')}}" name="telefone" required maxlength="15" data-toggle="tooltip" data-placement="right" title="Máximo de 15 Caracteres.">
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                  <input type="text" class="form-control" placeholder="Telefone móvel" value="{{Input::old('celular')}}" name="celular" required maxlength="15" data-toggle="tooltip" data-placement="right" title="Máximo de 15 caracteres.">
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                  <select class="form-control" name="nivel" required data-toggle="tooltip" data-placement="right" title="Nível de privilégio do usuário.">
                    <option value="">Selecione</option>
                    <option value="1" @if(Input::old('nivel') == 1) selected @endif>Administrador</option>
                    <option value="2" @if(Input::old('nivel') == 2) selected @endif>Professor</option>
                  </select>
                </div>

                <br />

                <div class="text-center">
                  <button type="reset" class="btn btn-warning">Limpar <i class='fa fa-eraser'></i></button>
                  <button type="button" class="btn btn-danger" onClick="history.go(-1)">Cancelar <i class='fa fa-times'></i></button>
                  <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                </div>
              </form>
            </div>
          </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
