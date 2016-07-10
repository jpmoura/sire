@extends('admin.admin_base')

@section('content')
  <div class='row'>
      <div class='col-md-8 col-md-offset-2'>

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

              <input type="hidden" name="cpf" value="{{$usuario->cpf}}">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                <input disabled class="form-control" type="text" placeholder="{{$usuario->cpf}}" data-toggle="tooltip" data-placement="right" title="CPF do usuário">
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input disabled type="text" class="form-control" value="{{$usuario->nome}}" data-toggle="tooltip" data-placement="right" title="Nome do usuário">
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input disabled type="email" class="form-control" value="{{$usuario->email}}" name="email" data-toggle="tooltip" data-placement="right" title="E-mail do usuário">
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                <select class="form-control" name="nivel" required data-toggle="tooltip" data-placement="right" title="Nível de privilégio do usuário.">
                  <option value="">Selecione</option>
                  <option value="1" @if($usuario->nivel == 1) selected @endif>Administrador</option>
                  <option value="2" @if($usuario->nivel == 2) selected @endif>Professor / Administrativo</option>
                  <option value="3" @if($usuario->nivel == 3) selected @endif>Usuário Especial</option>
                </select>
              </div>
              <br />
              <div class="text-center">
                <a class="btn btn-danger" style="color: white" data-toggle="modal" data-target="#deleteModal" href="#">Excluir <i class="fa fa-trash"></i></a>
                <button type="button" class="btn btn-warning" onClick="history.back()">Cancelar <i class='fa fa-times'></i></button>
                <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
              </div>
            </form>
          </div>
        </div>
      </div><!-- /.col -->
  </div><!-- /.row -->

  <div class="modal modal-warning fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title text-center"><i class="fa fa-warning"></i> Atenção</h4>
        </div>
        <div class="modal-body">
          <p class="text-center">Você tem certeza que quer excluir o usuário {{$usuario->nome}}?</p>
          <br />
          <form class="form text-center" action="{{(url('/usuarios/deletar'))}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="cpf" value="{{$usuario->cpf}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar <i class='fa fa-times'></i></button>
            <button type="submit" class="btn btn-success pull-right">Confirmar <i class='fa fa-check'></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
