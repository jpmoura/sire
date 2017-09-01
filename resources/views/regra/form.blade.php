{{ csrf_field() }}

{{-- Número e horário de início do turno matutino --}}
<div class="form-group">
    <p class="text-center"><i class="fa fa-sun-o"></i> Turno Matutino</p>
    <div class="input-group {{ $errors->has('quantidade_horarios_matutino') ? 'has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input class="form-control" type="number" min="0" max="6" value="{{ $regras->quantidade_horarios_matutino }}"
               placeholder="Quantidade de horários durante a manhã" required name="quantidade_horarios_matutino" data-toggle="tooltip"
               data-placement="right" title="Quantidade de horários disponíveis no turmo matutino"
        @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('quantidade_horarios_matutino'))
        <span class="help-block">
            <strong>{{ $errors->first('quantidade_horarios_matutino') }}</strong>
        </span>
    @endif
    <div class="input-group {{ $errors->has('horario_inicio_matutino') ? 'has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
        <input type="text" max="5" min="5" name="horario_inicio_matutino" class="form-control" value="{{ $regras->horario_inicio_matutino }}"
               placeholder="Horário de início do turno matutino no formato 24h. Ex.: 07:50"
               required data-toggle="tooltip" data-placement="right"
               title="Horário de início do turno matutino no formato 24h. Ex.: 08:00" @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('horario_inicio_matutino'))
        <span class="help-block">
            <strong>{{ $errors->first('horario_inicio_matutino') }}</strong>
        </span>
    @endif
</div>

<hr>

{{-- Número e horário de início do turno vespertino --}}
<div class="form-group">
    <p class="text-center"><i class="fa fa-cloud"></i> Turno Vespertino</p>
    <div class="input-group {{ $errors->has('quantidade_horarios_vespertino') ? 'has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="number" class="form-control" min="0" max="5" value="{{ $regras->quantidade_horarios_vespertino }}"
               placeholder="Quantidade de horários durante a tarde" name="quantidade_horarios_vespertino" required data-toggle="tooltip"
               data-placement="right" title="Quantidade de horários disponíveis no turmo verpertino" @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('quantidade_horarios_vespertino'))
        <span class="help-block">
            <strong>{{ $errors->first('quantidade_horarios_vespertino') }}</strong>
        </span>
    @endif
    <div class="input-group {{ $errors->has('horario_inicio_vespertino') ? 'has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
        <input type="text" name="horario_inicio_vespertino" class="form-control"
               placeholder="Horário de início do turno vespertino no formato 24h. Ex.: 14:20" value="{{ $regras->horario_inicio_vespertino }}"
               required data-toggle="tooltip" data-placement="right"
               title="Horário de início do turno vespertino no formato 24h. Ex.: 14:20" @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('horario_inicio_vespertino'))
        <span class="help-block">
            <strong>{{ $errors->first('horario_inicio_vespertino') }}</strong>
        </span>
    @endif
</div>

<hr>

{{-- Número e horário de início do turno noturno --}}
<div class="form-group">
    <p class="text-center"><i class="fa fa-moon-o"></i> Turno Noturno</p>
    <div class="input-group {{ $errors->has('quantidade_horarios_noturno') ? 'has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="number" class="form-control" min="0" max="4" value="{{ $regras->quantidade_horarios_noturno }}"
               placeholder="Quantidade de horários durante a noite" name="quantidade_horarios_noturno" required data-toggle="tooltip"
               data-placement="right" title="Quantidade de horários disponíveis no turmo noturno"
               @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('quantidade_horarios_noturno'))
        <span class="help-block">
            <strong>{{ $errors->first('quantidade_horarios_noturno') }}</strong>
        </span>
    @endif
    <div class="input-group {{ $errors->has('horario_inicio_noturno') ? 'has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
        <input type="text" name="horario_inicio_noturno" class="form-control"
               placeholder="Horário de início do turno noturno no formato 24h. Ex.: 19:20" value="{{ $regras->horario_inicio_noturno }}"
               required data-toggle="tooltip" data-placement="right" title="Horário de início do turno noturno no formato 24h. Ex.: 19:00"
               @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('horario_inicio_noturno'))
        <span class="help-block">
            <strong>{{ $errors->first('horario_inicio_noturno') }}</strong>
        </span>
    @endif
</div>

<hr>

{{-- Número de dias disponíveis para reserva --}}
<div class="form-group {{ $errors->has('quantidade_dias_reservaveis') ? 'has-error' : '' }}">
    <p class="text-center"><i class="fa fa-calendar-plus-o"></i> Dias disponíveis para reserva</p>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-calendar-plus-o"></i></span>
        <input type="number" class="form-control" min="1" value="{{ $regras->quantidade_dias_reservaveis }}"
               placeholder="Quantidade de dias disponíves para reserva." name="quantidade_dias_reservaveis" required data-toggle="tooltip"
               data-placement="right" title="Quantidade de dias disponíves para reserva."
               @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('quantidade_dias_reservaveis'))
        <span class="help-block">
            <strong>{{ $errors->first('quantidade_dias_reservaveis') }}</strong>
        </span>
    @endif
</div>

<hr>

{{-- Número de dias disponíveis para reserva --}}
<div class="form-group {{ $errors->has('quantidade_horarios_seguidos') ? 'has-error' : '' }}">
    <p class="text-center"><i class="fa fa-history"></i> Quantidade de horários seguidos</p>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-history"></i></span>
        <input type="number" class="form-control" min="1" value="{{ $regras->quantidade_horarios_seguidos }}"
               placeholder="Quantidade de dias disponíves para reserva." name="quantidade_horarios_seguidos" required data-toggle="tooltip"
               data-placement="right" title="Quantidade de horários que acontecem sem intervalo entre eles."
               @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('quantidade_horarios_seguidos'))
        <span class="help-block">
            <strong>{{ $errors->first('quantidade_horarios_seguidos') }}</strong>
        </span>
    @endif
</div>

<hr>

{{-- Número de dias disponíveis para reserva --}}
<div class="form-group {{ $errors->has('tempo_duracao_horario') ? 'has-error' : '' }}">
    <p class="text-center"><i class="fa fa-clock-o"></i> Tempo de duração de um horário</p>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
        <input type="text" class="form-control" minlength="8" maxlength="8" value="{{ $regras->tempo_duracao_horario }}"
               placeholder="Tempo de duração de um horário, que será a unidade mínima de tempo que um recurso pode ser reservado, no fomato HH:MM:SS"
               name="tempo_duracao_horario" required data-toggle="tooltip"
               data-placement="right" title="Tempo de duração de um horário, que será a unidade mínima de tempo que um recurso pode ser reservado no formato HH:MM:SS"
               @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('tempo_duracao_horario'))
        <span class="help-block">
            <strong>{{ $errors->first('tempo_duracao_horario') }}</strong>
        </span>
    @endif
</div>

<hr>

{{-- Número de dias disponíveis para reserva --}}
<div class="form-group {{ $errors->has('intervalo_entre_horarios_seguidos') ? 'has-error' : '' }}">
    <p class="text-center"><i class="fa fa-step-forward"></i> Intervalo entre horários seguidos</p>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-step-forward"></i></span>
        <input type="text" class="form-control" minlength="8" maxlength="8" value="{{ $regras->intervalo_entre_horarios_seguidos }}"
               placeholder="Tempo entre horários seguidos o qual não será possível usar para reserva no formato HH:MM:SS"
               name="intervalo_entre_horarios_seguidos" required data-toggle="tooltip" data-placement="right"
               title="Tempo de espera entre horários seguidos que não será passível de reserva no formato HH:MM:SS"
               @if(Route::is('regra.index')) disabled @endif>
    </div>
    @if ($errors->has('intervalo_entre_horarios_seguidos'))
        <span class="help-block">
            <strong>{{ $errors->first('intervalo_entre_horarios_seguidos') }}</strong>
        </span>
    @endif
</div>