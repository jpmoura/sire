@extends('layout.base')

@section('title')
    Editar usuário {{ $usuario->nome }}
@endsection

@section('page_icon')
    <i class="fa fa-pencil-square-o"></i>
@endsection

@section('description')
    Altere os capos para editar as informações sobre o usuário.
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="form" action="{{ route('editUser') }}" accept-charset="UTF-8" method="post">
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

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-power-off"></i></span>
                            <select class="form-control" name="status" required data-toggle="tooltip" data-placement="right" title="Status do usuário.">
                                <option value="">Selecione</option>
                                <option value="0" @if($usuario->status == 0) selected @endif>Inativo</option>
                                <option value="1" @if($usuario->status == 1) selected @endif>Ativo</option>
                            </select>
                        </div>
                        <br />
                        <div class="text-center">
                            @if($usuario->status != 0)
                                <a class="btn btn-danger" style="color: white" data-toggle="modal" data-target="#deleteModal" href="#">Excluir <i class="fa fa-trash"></i></a>
                            @endif
                            <button type="button" class="btn btn-warning" onClick="history.back()">Cancelar <i class='fa fa-times'></i></button>
                            <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->

    @if($usuario->status != 0)
        <div class="modal modal-warning fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center"><i class="fa fa-warning"></i> Atenção</h4>
                    </div>
                    <form class="form text-center" action="{{ route('deleteUser') }}" method="post">
                        <div class="modal-body">
                            <p class="text-center">Você tem certeza que quer excluir o usuário {{$usuario->nome}}?</p>
                            <br />

                                {{ csrf_field() }}
                                <input type="hidden" name="cpf" value="{{$usuario->cpf}}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar <i class='fa fa-times'></i></button>
                            <button type="submit" class="btn btn-success pull-right">Confirmar <i class='fa fa-check'></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
