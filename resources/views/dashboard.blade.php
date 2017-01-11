@extends('layout.base')

@section('title')
    Painel de Controle
@endsection

@section('page_icon')
    <i class="fa fa-home"></i>
@endsection

@section('description')
    Bem vindo {{ Auth::user()->nome }}
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-12 text-center'>
            <h3 class="text-center">
                @if($data['hours'] > -1 && $data['hours'] < 12)
                    Bom dia
                @elseif($data['hours'] > 11 && $data['hours'] < 18)
                    Boa tarde
                @else
                    Boa noite
                @endif
                {{ Session::get("nome") }}, hoje é {{ $data['weekday'] }}, {{ $data['mday'] }} de {{ $data['month'] }} de {{ $data['year'] }}.</h3>
            <br />
            @if(Auth::user()->isAdmin()) {{-- Widgets de administrador --}}

            @push('extra-js')
            <script src="{{ asset ('resources/assets/js/chartjs/Chart.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset ('resources/assets/js/chartjs/chartHelpers.js') }}" type="text/javascript"></script>
            <script>
                var PieData = [
                        @foreach($recUso as $recurso)
                    {
                        value: {{ $recurso->qtd }},
                        color: getRandomColor(),
                        highlight: "black",
                        label: "{!! $recurso->nome !!}"
                    },
                    @endforeach
                ];
                var pieOptions = getPieChartOptions();
                var pieChartCanvas = $("#recursos").get(0).getContext("2d");
                var pieChart = new Chart(pieChartCanvas);
                pieChart.Doughnut(PieData, pieOptions);

                var lineData = {
                    labels: [
                        @foreach($uso as $alocacao)
                            getMonthName({{$alocacao->mes - 1}}),
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: "Alocações",
                            fillColor: "rgba(210, 214, 222, 1)",
                            strokeColor: "#0073b7",
                            pointColor: "white",
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: [
                                @foreach($uso as $alocacao)
                                {{ $alocacao->qtd }},
                                @endforeach
                            ]
                        }
                    ]
                };

                var lineChartOptions = getLineChartOptions();
                lineChartOptions.datasetFill = false;
                var lineChartCanvas = $("#canvas").get(0).getContext("2d");
                var lineChart = new Chart(lineChartCanvas);
                lineChart.Line(lineData, lineChartOptions);
            </script>
            @endpush

            <div class="col-md-3">
                <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>Usuários Frequentes nesse mês</b></span>
                        <!-- The progress section is optional -->
                        @foreach($usuariosAtual as $usuario)
                            <span class="progress-description text-left">
                      {{$usuario->nome}}: {{$usuario->qtd}} reservas
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
                        @foreach($usuariosAnterior as $usuario)
                            <span class="progress-description text-left">
                      {{$usuario->nome}}: {{$usuario->qtd}} reservas
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
                        @foreach($recursosAtual as $recurso)
                            <span class="progress-description text-left">
                      {{$recurso->nome}}: {{$recurso->qtd}} reservas
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
                        @foreach($recursosAnterior as $recurso)
                            <span class="progress-description text-left">
                      {{$recurso->nome}}: {{$recurso->qtd}} reservas
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
                        <canvas id="canvas" class="estatistica"></canvas>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Uso dos recursos nos últimos 6 meses</h3>
                        </div>
                        <canvas id="recursos" class="estatistica"></canvas>
                    </div>
                </div>
            </div>


            @else {{-- widgets de usuario comum --}}

            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-yellow">
                        <span class="info-box-icon"><i class="fa fa-star-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Recurso favorito no mês</span>
                            <br />
                            <span class="info-box-number">
                      @if(isset($recursoAtual))
                                    {{$recursoAtual->nome}}
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
                      @if(isset($recursoAnterior))
                                    {{$recursoAnterior->nome}}
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
                            <span class="info-box-text">Quantidade de reservas feitas</span>
                            <br />
                            <span class="info-box-number">
                      @if(isset($reservasAtual))
                                    {{$reservasAtual->qtd}} RESERVAS NESSE MÊS
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
                            <span class="info-box-text">Quantidade de reservas feitas</span>
                            <br />
                            <span class="info-box-number">
                      @if(isset($reservasAnterior))
                                    {{$reservasAnterior->qtd}} RESERVAS NO MÊS ANTERIOR
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
                            @if(count($proximas))
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
                                        @foreach($proximas as $reserva)
                                            <tr>
                                                <td>{{$reserva->data}}</td>
                                                <td>{{$reserva->nome}}</td>
                                                <td>{{$reserva->aula[0] . '&ordm;'}}
                                                    @if($reserva->aula[1] == 'm')
                                                        Matutino
                                                    @elseif($reserva->aula[1] == 'v')
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
                            @if(count($frequentes))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th>Recurso</th>
                                            <th>Horário</th>
                                            <th>Frequência</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($frequentes as $reserva)
                                            <tr>
                                                <td>{{$reserva->equipamentoNOME}}</td>
                                                <td>{{$reserva->aula[0] . '&ordm;'}}
                                                    @if($reserva->aula[1] == 'm')
                                                        Matutino
                                                    @elseif($reserva->aula[1] == 'v')
                                                        Vespertino
                                                    @else
                                                        Noturno
                                                    @endif
                                                </td>
                                                <td>{{$reserva->qtd}}</td>
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
