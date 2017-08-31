@extends('layout.base')

@section('title')
    Cadastrar Recurso
@endsection

@section('page_icon')
    <i class="fa fa-plus-circle"></i>
@endsection

@section('description')
    Complete o formulário para cadastrar um novo recurso.
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="form" action="{{ route('recurso.store') }}" accept-charset="UTF-8" method="post">
                        @include('recurso.form')

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
