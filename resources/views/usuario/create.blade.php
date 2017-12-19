@extends('layout.base')

@section('title')
    Cadastrar Usuário
@endsection

@section('page_icon')
    <i class='fa fa-user-plus'></i>
@endsection

@section('description')
    Preencha os campos para adicionar um novo usuário ao sistema.
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="form" action="{{ route('usuario.store') }}" accept-charset="UTF-8" method="post">
                        @include('usuario.form')

                        <br>

                        <div class="text-center">
                            <button type="button" class="btn btn-danger" onClick="history.go(-1)">Cancelar <i class='fa fa-times'></i></button>
                            <button type="reset" class="btn btn-warning">Limpar <i class='fa fa-eraser'></i></button>
                            <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
