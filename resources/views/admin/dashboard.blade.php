@extends('admin.admin_base')

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
          @if(Session::get('nivel') == 1) {{-- Widgets de administrador --}}
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

            <script src="{{ asset ('public/plugins/chartjs/Chart.min.js') }}" type="text/javascript"></script>
            <script>
            function getRandomColor() {
              var letters = '0123456789ABCDEF'.split('');
              var color = '#';
              for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
              }
              return color;
            }
            var dadosAloc = {
              labels: [
                @foreach($uso as $alocacao)
                "{{date("F", mktime(0, 0, 0, $alocacao->mes, 10))}}",
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
              ]};

              var pieChartCanvas = $("#recursos").get(0).getContext("2d");
              var pieChart = new Chart(pieChartCanvas);
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
              var pieOptions = {
                //Boolean - Whether we should show a stroke on each segment
                segmentShowStroke: true,
                //String - The colour of each segment stroke
                segmentStrokeColor: "#fff",
                //Number - The width of each segment stroke
                segmentStrokeWidth: 2,
                //Number - The percentage of the chart that we cut out of the middle
                percentageInnerCutout: 50, // This is 0 for Pie charts
                //Number - Amount of animation steps
                animationSteps: 100,
                //String - Animation easing effect
                animationEasing: "easeOutBounce",
                //Boolean - Whether we animate the rotation of the Doughnut
                animateRotate: true,
                //Boolean - Whether we animate scaling the Doughnut from the centre
                animateScale: false,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true,
                // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: true,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
              };
              //Create pie or douhnut chart
              // You can switch between pie and douhnut using the method below.
              pieChart.Doughnut(PieData, pieOptions);

              var chartOptions = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: true,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - If there is a stroke on each bar
                barShowStroke: true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth: 2,
                //Number - Spacing between each of the X value sets
                barValueSpacing: 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing: 1,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                //Boolean - whether to make the chart responsive
                responsive: true,
                maintainAspectRatio: true,
                title: {
                  display: true,
                  text: 'Custom Chart Title',
                  position: top
                }
              };

              var lineChartCanvas = $("#canvas").get(0).getContext("2d");
              var lineChart = new Chart(lineChartCanvas);
              var lineChartOptions = chartOptions;
              lineChartOptions.datasetFill = false;
              lineChart.Line(dadosAloc, lineChartOptions);

              // var lineChartCanvas2 = $("#alocacao").get(0).getContext("2d");
              // var lineChart2 = new Chart(lineChartCanvas2);
              // lineChart2.Line(aloc, lineChartOptions);
            </script>

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
