{{ csrf_field() }}

<div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-tag"></i></span>
        <input type="text" name="nome" maxlength="20" class="form-control" placeholder="Nome do tipo do recurso"
               title="Nome do tipo do recurso" value="@if($errors->has('nome')){!! old('nome') !!}@elseif(Route::is('tiporecurso.edit')){!! $tipo->nome !!}@endif" required>
    </div>
    @if ($errors->has('nome'))
        <span class="help-block">
            <strong>{{ $errors->first('nome') }}</strong>
        </span>
    @endif
</div>