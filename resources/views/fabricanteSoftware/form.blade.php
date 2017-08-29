{{ csrf_field() }}

<div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-tag"></i></span>
        <input type="text" name="nome" maxlength="255" class="form-control" placeholder="Nome do fabricante" title="Nome do fabricante"
               value="@if($errors->has('nome')){{ old('nome') }}@elseif(Route::is('fabricante.edit')){{ $fabricante->nome  }}@endif" required>
    </div>
    @if ($errors->has('nome'))
        <span class="help-block">
            <strong>{{ $errors->first('nome') }}</strong>
        </span>
    @endif
</div>