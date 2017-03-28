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
                    <form class="form" action="{{ route('software.update', $software->id) }}" accept-charset="UTF-8" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        <div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="nome" maxlength="255" class="form-control" placeholder="Nome do software" title="Nome do software" value="{{ old('nome') ? old('nome') : $software->nome }}" required>
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
                                        <option value="{{ $fabricante->id }}" @if(($errors->has('fabricante') && old('fabricante') == $fabricante->id) || (!$errors->has('fabricante') && $software->fabricante_software_id == $fabricante->id)) selected @endif>{!! $fabricante->nome !!}</option>
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
                                <input type="text" name="versao" maxlength="255" class="form-control" placeholder="Versão do software" title="Versão do software" value="{{ old('versao') ? old('versao') : $software->versao }}" required>
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
                                    <option value="0" @if(($errors->has('status') && old('status') == 0) || (!$errors->has('status') && $software->status == 0)) selected @endif>Não instalado</option>
                                    <option value="1" @if(($errors->has('status') && old('status') == 1) || (!$errors->has('status') && $software->status == 1)) selected @endif>Instalado</option>
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
