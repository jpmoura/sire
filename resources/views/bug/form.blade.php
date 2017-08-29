{{ csrf_field() }}

<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-tag"></i></span>
        <input type="text" name="title" maxlength="100" class="form-control" placeholder="Título" data-toggle="tooltip"
               data-placement="right" title="Título para o bug encontrado." required>
    </div>
    @if ($errors->has('nome'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-th-list"></i></span>
        <textarea name="description" maxlength="850" rows="6" style="resize: none" class="form-control"
                  placeholder="Informe o máximo de detalhes que conseguir (Ex.: navegador, ação que estava realizando, se era navagação privada ou não, se era em um dispositivo móvel ou desktop, etc.)"
                  data-toggle="tooltip" data-placement="right" title="Descrição detalhada do bug encontrado por você."
                  required></textarea>
    </div>
    @if ($errors->has('nome'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>

