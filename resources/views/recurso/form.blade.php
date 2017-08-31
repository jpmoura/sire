{{ csrf_field() }}

<div class="form-group {{ $errors->has('tipo') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
        <select class="form-control" name="tipo" required data-toggle="tooltip" data-placement="right"
                title="Tipo do recurso.">
            <option value="">Selecione</option>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}" @if(Route::is('recurso.edit') && $recurso->tipo_recurso_id == $tipo->id) selected @endif>{!! $tipo->nome !!}</option>
            @endforeach
        </select>
    </div>
    @if ($errors->has('tipo'))
        <span class="help-block">
            <strong>{{ $errors->first('tipo') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-tag"></i></span>
        <input type="text" class="form-control" placeholder="Nome. Máximo de 50 caracteres." autofocus name="nome"
               required maxlength="50" data-toggle="tooltip" data-placement="right" title="Nome. Máximo de 50 caracteres."
               value="@if($errors->has('nome')){{ old('nome') }}@elseif(Route::is('recurso.edit')){{ $recurso->nome }}@endif">
    </div>
    @if ($errors->has('nome'))
        <span class="help-block">
            <strong>{{ $errors->first('nome') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('descricao') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-info"></i></span>
        <textarea class="form-control" name="descricao" rows="4" cols="40" placeholder="Descrição. Máximo de 100 caracteres."
                  required maxlength="100" data-toggle="tooltip" data-placement="right"
                  title="Descrição. Máximo de 100 caracteres.">@if($errors->has('descricao')){!! old('descricao') !!}@elseif(Route::is('recurso.edit')){!! $recurso->descricao !!}@endif</textarea>
    </div>
    @if ($errors->has('descricao'))
        <span class="help-block">
            <strong>{{ $errors->first('descricao') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-exchange fa-rotate-90"></i></span>
        <select class="form-control" name="status" required data-toggle="tooltip" data-placement="right" title="Status do recurso.">
            <option value="">Selecione</option>
            <option value="1" @if(($errors->has('status') && old('status') == 1) || (Route::is('recurso.edit') ) && $recurso->status == 1) selected @endif>Ativo</option>
            <option value="0" @if(($errors->has('status') && old('status') == 0) || (Route::is('recurso.edit') ) && $recurso->status == 0) selected @endif>Inativo</option>
        </select>
    </div>
    @if ($errors->has('status'))
        <span class="help-block">
            <strong>{{ $errors->first('status') }}</strong>
        </span>
    @endif
</div>