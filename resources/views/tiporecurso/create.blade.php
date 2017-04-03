@extends('layout.base')

@section('title')
    Adicionar Tipo de Recurso
@endsection

@section('page_icon')
    <i class="fa fa-gear"></i>
@endsection

@section('description')
    Preencha os campos para cadastrar um novo tipo de recuso.
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="form" action="{{ route('tiporecurso.store') }}" accept-charset="UTF-8" method="post">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="nome" maxlength="20" class="form-control" placeholder="Nome do tipo do recurso" title="Nome do tipo do recurso" value="{{ old('nome') }}" required>
                            </div>
                            @if ($errors->has('nome'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nome') }}</strong>
                                </span>
                            @endif
                        </div>

                        <br />

                        <div class="text-center">
                            <button type="button" class="btn btn-danger" onClick="history.back()"><i class='fa fa-times'></i> Cancelar</button>
                            <button type="reset" class="btn btn-warning"><i class='fa fa-eraser'></i> Limpar</button>
                            <button type="submit" class="btn btn-success"><i class='fa fa-check'></i> Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
