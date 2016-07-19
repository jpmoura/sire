@extends('admin.admin_base')

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>

          @if(Session::has("tipo"))
            <div class="row">
              <div class="text-center alert alert-dismissible @if(Session::get('tipo') == 'Sucesso') alert-success @else alert-danger @endif" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{{Session::get("tipo")}}!</strong> {{Session::get("mensagem")}}
              </div>
            </div>
          @endif

          <div class="box box-primary-ufop">
            <div class="box-body">
              <form class="form" action="{{url('/regras/editar')}}" accept-charset="UTF-8" method="post">
                {{ csrf_field() }}

                <input type="hidden" name="id" class="form-control" value="{{$regras->id}}">

                {{-- Número e horário de início do turno matutino --}}
                <div class="form-group">
                  <p class="text-center"><i class="fa fa-sun-o"></i> Turno Matutino</p>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input class="form-control" type="number" min="0" max="6" value="{{ $regras->manha }}" placeholder="Quantidade de horários durante a manhã" required name="manha" data-toggle="tooltip" data-placement="right" title="Quantidade de horários disponíveis no turmo matutino">
                  </div>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></i></span>
                    <input type="text" max="5" min="5" name="inicioManha" class="form-control" value="{{ $regras->inicioManha }}"
                           placeholder="Horário de início do turno matutino no formato 24h. Ex.: 07:50"
                           required data-toggle="tooltip" data-placement="right" title="Horário de início do turno matutino no formato 24h. Ex.: 08:00">
                  </div>
                </div>

                <hr>

                {{-- Número e horário de início do turno vespertino --}}
                <div class="form-group">
                  <p class="text-center"><i class="fa fa-cloud"></i> Turno Vespertino</p>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="number" class="form-control" min="0" max="5" value="{{ $regras->tarde }}" placeholder="Quantidade de horários durante a tarde" name="tarde" required data-toggle="tooltip" data-placement="right" title="Quantidade de horários disponíveis no turmo verpertino">
                  </div>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></i></span>
                    <input type="text" name="inicioTarde" class="form-control"
                           placeholder="Horário de início do turno vespertino no formato 24h. Ex.: 14:20" value="{{ $regras->inicioTarde }}"
                           required data-toggle="tooltip" data-placement="right" title="Horário de início do turno vespertino no formato 24h. Ex.: 14:20">
                  </div>
                </div>

                <hr>

                {{-- Número e horário de início do turno noturno --}}
                <div class="form-group">
                  <p class="text-center"><i class="fa fa-moon-o"></i> Turno Noturno</p>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="number" class="form-control" min="0" max="4" value="{{ $regras->noite }}" placeholder="Quantidade de horários durante a noite" name="noite" required data-toggle="tooltip" data-placement="right" title="Quantidade de horários disponíveis no turmo noturno">
                  </div>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></i></span>
                    <input type="time" name="inicioNoite" class="form-control" placeholder="Horário de início do turno noturno no formato 24h. Ex.: 19:20" value="{{ $regras->inicioNoite }}"
                    required data-toggle="tooltip" data-placement="right" title="Horário de início do turno noturno no formato 24h. Ex.: 19:00">
                  </div>
                </div>

                <hr>

                {{-- Número de dias disponíveis para reserva --}}
                <div class="form-group">
                  <p class="text-center"><i class="fa fa-calendar"></i> Dias disponíveis para reserva</p>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar-plus-o"></i></span>
                    <input type="number" class="form-control" min="0" value="{{ $regras->dias }}" placeholder="Quantidade de dias disponíves para reserva." name="dias" required data-toggle="tooltip" data-placement="right" title="Quantidade de dias disponíves para reserva.">
                  </div>
                </div>


                <br />

                <div class="text-center">
                  <button type="button" class="btn btn-danger" onClick="history.back()">Cancelar <i class='fa fa-times'></i></button>
                  <button type="reset" class="btn btn-warning">Limpar <i class='fa fa-eraser'></i></button>
                  <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                </div>
              </form>
            </div>
          </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
