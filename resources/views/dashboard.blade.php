@extends('layout.base')

@section('title')
    Painel de Controle
@endsection

@section('page_icon')
    <i class="fa fa-home"></i>
@endsection

@section('description')
    Bem vindo {{ auth()->user()->nome }}
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-12 text-center'>
            <h3 class="text-center">
                @if(date("G") > -1 && date("G") < 12)
                    Bom dia
                @elseif(date("G") > 11 && date("G") < 18)
                    Boa tarde
                @else
                    Boa noite
                @endif
                <?php setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf8", "portuguese"); ?>
                {{ auth()->user()->nome }}, hoje é {!! ucfirst(strftime("%A", \Carbon\Carbon::now()->timestamp)) !!}, {{ date("d") }} de {!! ucfirst(strftime("%B", \Carbon\Carbon::now()->timestamp)) !!} de {{ date("Y") }}.</h3>
            <br />
            @if(auth()->user()->isAdmin()) {{-- Widgets de administrador --}}
        
            <script src="{{ asset ('public/js/plugins/chartjs/Chart.bundle.min.js') }}" type="text/javascript"></script>

            <div class="col-md-3">
                <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>Usuários Frequentes nesse mês</b></span>
                        <!-- The progress section is optional -->
                        @foreach(array_keys($topUsuariosMesAtual) as $usuario)
                            <span class="progress-description text-left">
                                {!! $usuario !!}: {{ $topUsuariosMesAtual[$usuario] }} reservas
                            </span>
                        @endforeach
                    </div><!-- /.info-box-content -->
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>Usuários Frequentes mês passado</b></span>
                        <!-- The progress section is optional -->
                        @foreach(array_keys($topUsuariosMesPassado) as $usuario)
                            <span class="progress-description text-left">
                                {!! $usuario !!}: {{ $topUsuariosMesPassado[$usuario] }} reservas
                            </span>
                        @endforeach
                    </div><!-- /.info-box-content -->
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-cog"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>Recursos Frequentes do mês</b></span>
                        <!-- The progress section is optional -->
                        @foreach(array_keys($topRecursosMesAtual) as $recurso)
                            <span class="progress-description text-left">
                                {!! $recurso !!}: {{ $topRecursosMesAtual[$recurso] }} reservas
                            </span>
                        @endforeach
                    </div><!-- /.info-box-content -->
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon"><i class="fa fa-cog"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>Recurso mais usado mês passado</b></span>
                        <!-- The progress section is optional -->
                        @foreach(array_keys($topRecursosMesPassado) as $recurso)
                            <span class="progress-description text-left">
                                {!! $recurso !!}: {{ $topRecursosMesPassado[$recurso] }} reservas
                            </span>
                        @endforeach
                    </div><!-- /.info-box-content -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Reservas nos últimos 6 meses</h3>
                        </div>
                        <div class="box-body">
                            {!! $graficos['reservas']->render() !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Uso dos recursos nos últimos 6 meses</h3>
                        </div>
                        <div class="box-body estatistica">
                            {!! $graficos['recursos']->render() !!}
                        </div>
                    </div>
                </div>
            </div>


            @else {{-- widgets de usuario comum --}}

                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-star-o"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Recurso favorito nesse mês</span>
                                <br />
                                <span class="info-box-number">
                                    @if(!empty($topRecursoMesAtual))
                                        {!! $topRecursoMesAtual !!}
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
                                        {!! $topRecursoMesPassado !!}
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
                </div>

                <div class="row">
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
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($reservasFrequentes->keys() as $recurso)
                                                <tr>
                                                    <td>{!! $recurso !!}</td>
                                                    <td>{!! $reservasFrequentes[$recurso]->count() !!}</td>
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
                    </div>
                </div>
            @endif
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection