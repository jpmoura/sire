@if(Route::is('recurso.select.date'))
    <div class="form-group {{ $errors->has('data') ? 'has-error' : '' }}">
        <div class="input-group ">
            <span class="input-group-addon date"><i class="fa fa-calendar"></i></span>
            <input maxlength="8" minlength="8" type="text" id="data" name="data" class="form-control"
                   placeholder="Data no formato dd/mm/aaaa" required>
        </div>

        @if($errors->has('data'))
            <p class="help-block">{{ $errors->first('data') }}</p>
        @endif
    </div>
@endif

<div class="form-group {{ $errors->has('recurso') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-gear"></i></span>
        <select class="form-control" required name="recurso">
            <option value="">Selecione</option>
            @foreach($recursos as $recurso)
                <option value="{{ $recurso->id }}">{!! $recurso->nome !!}</option>
            @endforeach
        </select>

        @if($errors->has('recurso'))
            <p class="help-block">{{ $errors->first('recurso') }}</p>
        @endif
    </div>
</div>

<br />

<div class="text-center">
    <button type="button" class="btn btn-warning" onClick="history.back()"><i class='fa fa-arrow-left'></i> Voltar</button>
    <button type="submit" class="btn btn-primary"><i class='fa fa-search'></i> Visualizar</button>
</div>