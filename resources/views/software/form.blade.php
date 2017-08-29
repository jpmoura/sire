{{ csrf_field() }}

<div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-tag"></i></span>
        <input type="text" name="nome" maxlength="255" class="form-control" placeholder="Nome do software"
               title="Nome do software" value="@if($errors->has('nome')){!! old('nome') !!}@elseif(Route::is('software.edit')){!! $software->nome !!}@endif" required>
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
                <option value="{{ $fabricante->id }}" @if(old('$fabricante') == $fabricante->id || (Route::is('software.edit') && $software->fabricante_software_id == $fabricante->id)) selected @endif>{!! $fabricante->nome !!}</option>
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
        <input type="text" name="versao" maxlength="255" class="form-control" placeholder="Versão do software"
               title="Versão do software" value="@if($errors->has('versao')){!! old('versao') !!}@elseif(Route::is('software.edit')){!! $software->versao !!}@endif" required>
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
            <option value="0" @if(old('status') == 0 || (Route::is('software.edit') && $software->status == 0)) selected @endif>Não instalado</option>
            <option value="1" @if(old('status') == 1 || (Route::is('software.edit') && $software->status == 1)) selected @endif>Instalado</option>
        </select>
    </div>
    @if ($errors->has('status'))
        <span class="help-block">
            <strong>{{ $errors->first('status') }}</strong>
        </span>
    @endif
</div>