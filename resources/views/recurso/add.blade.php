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
                    <form class="form" action="{{ route('storeAsset') }}" accept-charset="UTF-8" method="post">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                            <select class="form-control" name="tipo" required data-toggle="tooltip" data-placement="right" title="Tipo do recurso.">
                                <option value="">Selecione</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{!! $tipo->nome !!}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                            <input type="text" class="form-control" placeholder="Nome. Máximo de 50 caracteres." autofocus name="nome" required maxlength="50" data-toggle="tooltip" data-placement="right" title="Nome. Máximo de 50 caracteres.">
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-info"></i></span>
                            <textarea class="form-control" name="descricao" rows="4" cols="40" placeholder="Descrição. Máximo de 100 caracteres." required maxlength="100" data-toggle="tooltip" data-placement="right" title="Descrição. Máximo de 100 caracteres."></textarea>
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-plug"></i></span>
                            <select class="form-control" name="status" required data-toggle="tooltip" data-placement="right" title="Status do recurso.">
                                <option value="">Selecione</option>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
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