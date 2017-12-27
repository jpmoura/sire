@extends('dashboard.layout')

@section('widgets')
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-star-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Recurso favorito nesse mês</span>
                <br />
                <span class="info-box-number">
                @if(!empty($topRecursoMesAtual))
                        {!! $topRecursoMesAtual->recurso->nome !!}
                    @else
                        NENHUMA RESERVA FEITA
                    @endif
            </span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-star-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Recurso favorito no mês passado</span>
                <br />
                <span class="info-box-number">
                @if(!empty($topRecurssoMesPassado))
                        {!! $topRecursoMesPassado->recurso->nome !!}
                    @else
                        NENHUMA RESERVA FEITA
                    @endif
            </span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-calendar-check-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Reservas neste mês</span>
                <br />
                <span class="info-box-number">
                @if(!empty($reservasMesAtual))
                        {!! $reservasMesAtual !!} RESERVAS NESSE MÊS
                    @else
                        NENHUMA RESERVA FEITA
                    @endif
            </span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-calendar-check-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Reservas no mês passado</span>
                <br />
                <span class="info-box-number">
                @if(!empty($reservasMesPassado))
                        {!! $reservasMesPassado !!} RESERVAS NO MÊS ANTERIOR
                    @else
                        NENHUMA RESERVA FEITA
                    @endif
            </span>
            </div>
        </div>
    </div>
@endsection

@section('info')
    <div class="col-md-6">
        <div class="box box-primary-ufop">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-calendar-check-o"></i> Minhas próximas reservas</h3>
            </div>
            <div class="box-body">
                @if(count($proximasReservas))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center">
                            <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Recurso</th>
                                <th>Horário</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($proximasReservas as $reserva)
                                <tr>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $reserva->data)->format('d/m/Y') }}</td>
                                    <td>{!! $reserva->recurso->nome !!}</td>
                                    <td>{!! $reserva->horario . '&ordm;' !!}
                                        @if($reserva->turno == 'm')
                                            Matutino
                                        @elseif($reserva->turno == 'v')
                                            Vespertino
                                        @else
                                            Noturno
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    Você não tem nenhuma reserva agendada.
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary-ufop">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-arrow-up"></i> Minhas reservas frequentes</h3>
            </div>
            <div class="box-body">
                @if(count($reservasFrequentes))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center">
                            <thead>
                            <tr>
                                <th>Recurso</th>
                                <th>Frequência</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservasFrequentes->keys() as $recurso)
                                <tr>
                                    <td>{!! $recurso !!}</td>
                                    <td>{!! $reservasFrequentes[$recurso]->count() !!}</td>
                                    <td>
                                        <a href="{{ route('reserva.show', $reservasFrequentes[$recurso][0]->recurso) }}" class="btn btn-ufop" role="button"><i class="fa fa-calendar-check-o"></i> Reservar</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    Você não tem nenhuma reserva frequente.
                @endif
            </div>
        </div>
@endsection
