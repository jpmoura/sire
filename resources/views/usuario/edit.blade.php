@extends('layout.base')

@section('title')
    Editar usuário {!! $usuario->nome !!}
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
                    <form class="form" action="{{ route('usuario.update') }}" accept-charset="UTF-8" method="post">
                        <p class="text-info text-center">Para alterar a senha preencha os campos correspondentes. Caso contrário, deixe os campos em branco.</p>

                        @include('usuario.form')

                        <input type="hidden" name="id" value="{{ $usuario->id }}">

                        <br />

                        <div class="text-center">

                            {{-- Um administrador não pode se excluir enquanto logado no sistema --}}
                            @if($usuario->status != 0 && $usuario->id != auth()->id())
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

    @if($usuario->status != 0 && $usuario->id != auth()->id())
        <div class="modal modal-warning fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center"><i class="fa fa-warning"></i> Atenção</h4>
                    </div>
                    <form class="form text-center" action="{{ route('usuario.delete') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $usuario->id }}">
                        <div class="modal-body">
                            <p class="text-center">Você tem certeza que quer excluir o usuário {!! $usuario->nome !!}?</p>
                            <br />
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
