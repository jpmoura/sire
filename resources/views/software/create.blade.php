@extends('layout.base')

@section('title')
    Adicionar Software
@endsection

@section('page_icon')
    <i class="fa fa-plus-circle"></i>
@endsection

@section('description')
    Preencha os campos para cadastrar um novo fabricante de software.
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="form" action="{{ route('software.store') }}" accept-charset="UTF-8" method="post">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="nome" maxlength="255" class="form-control" placeholder="Nome do software" title="Nome do software" value="{{ old('nome') }}" required>
                            </div>
                            @if ($errors->has('nome'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nome') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('fabricante') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-wrench"></i></span>
                                <select class="form-control" name="fabricante" title="Fabricante do software" required>
                                    <option value="">Selecione o fabricante do software</option>
                                    @foreach($fabricantes as $fabricante)
                                        <option value="{{ $fabricante->id }}" {{ old('fabricante') == $fabricante->id ? 'selected' : '' }}>{!! $fabricante->nome !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('fabricante'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('fabricante') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('versao') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code-fork"></i></span>
                                <input type="text" name="versao" maxlength="255" class="form-control" placeholder="Versão do software" title="Versão do software" value="{{ old('versao') }}" required>
                            </div>
                            @if ($errors->has('versao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('versao') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                                <select name="status" class="form-control" title="Status do software" required>
                                    <option value="">Selecione o status do software</option>
                                    <option value="0" {{ 0 === old('status') ? 'selected' : ''}}>Não instalado</option>
                                    <option value="1" {{ 1 === old('status') ? 'selected' : ''}}>Instalado</option>
                                </select>
                            </div>
                            @if ($errors->has('status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status') }}</strong>
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
