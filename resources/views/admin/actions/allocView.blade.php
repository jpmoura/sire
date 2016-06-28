@extends('admin.admin_base')

@section('content')
  <div class='row'>
    <div class='col-md-8 col-md-offset-2 text-center'>

      @if(Session::has("tipo"))
        <div class="row">
          <div class="text-center alert alert-dismissible @if(Session::get('tipo') == 'Sucesso') alert-success @else alert-danger @endif" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{Session::get("tipo")}}!</strong> {{Session::get("mensagem")}}
          </div>
        </div>
      @endif

      <h2>Reservas para {{$recursoNome}}</h2>
      <form class="form" action="{{url('/alocar')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$recursoID}}" />
        @for($i=0; $i < 3; ++$i)
          <div class="box box-primary-ufop collapsed-box">
            <div class="box-header with-border">
              <h3 class="text-center">
                <a href="#" style="color: black;" data-widget="collapse">
                  @if($i == 0)
                    <i class="fa fa-sun-o"></i> Turno Matutino
                    <?php $qtdAulas = $regras->manha; $turno = 'm'; $inicio = $regras->inicioManha; ?>
                  @elseif($i == 1)
                    <i class="fa fa-cloud"></i> Turno Vespertino
                    <?php $qtdAulas = $regras->tarde; $turno = 'v'; $inicio = $regras->inicioTarde; ?>
                  @else
                    <i class="fa fa-moon-o"></i> Turno Noturno
                    <?php $qtdAulas = $regras->noite; $turno = 'n'; $inicio = $regras->inicioNoite;?>
                  @endif
                </a>
              </h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
              </div><!-- /.box-tools -->
            </div>

            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                  <tr>
                    <th>Horário</th>
                    @for($d=0; $d < count($dias); $d++)
                      <th><?php setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf8", "portuguese") ?>{{ucfirst(strftime("%A", DateTime::createFromFormat('d/m/y', $dias[$d])->getTimestamp()))}} ({{$dias[$d] }})</th>
                    @endfor
                  </tr>
                  {{-- Para cada dia da semana --}}

                  {{-- Inicialização das variáveis para definição de horário --}}
                  <?php
                    $intervalo = 0;
                    $addTime = 0;
                    $initTime = strtotime($inicio);
                  ?>

                  @for($j=1; $j <= $qtdAulas; ++$j)
                    <tr>
                      <?php
                        $endTime = strtotime("+50 minutes", $initTime); // Adicionar o addTime ao tempo de inicio
                      ?>

                      <td>{{date('H:i', $initTime)}} - {{date('H:i', $endTime)}}</td>

                      <?php
                        $initTime = $endTime;
                        ++$intervalo;

                        // Adicionar 20 minutos de intervalo a cada duas aulas
                        // exceto para o horário entre o intervalo de 1h do turno vespertino e noturno
                        if(($intervalo % 2) == 0) {
                          $initTime = strtotime("+20 minutes", $initTime);
                        }
                        if($intervalo == 4 && $turno == 'v') {
                          $initTime = strtotime("-15 minutes", $initTime);
                        }
                      ?>
                      @for($k=0; $k < $regras->diasQtd; ++$k)
                        <?php $status = false; ?>
                        {{-- Olhar se alguma alocacao pertence aquele horario daquele turno  --}}
                        <td>
                          @foreach($alocacoes as $alocacao)
                            @if($alocacao->aula == ($j . $turno) && $alocacao->data == $dias[$k]) {{-- Se for igual então está reservado --}}
                              <a target="_blank" href="mailto:{{$alocacao->autorEMAIL}}?subject=[UFOP-ICEA] Alocação do recurso {{$recursoNome}}">{{$alocacao->autorNOME}}</a>
                              @if(Session::get("nivel") == 1 || $alocacao->autorID == Session::get("id"))
                                <br />
                                <a class="btn btn-warning btn-xs" style="color: white" href="{{url('/desalocar' . "/" . $alocacao->reservaID)}}"><i class="fa fa-times"></i> Desalocar</a>
                              @endif
                              <?php $status = true; ?>
                              @break
                            @endif
                          @endforeach
                          @if(!$status)
                            <input type="checkbox" name="{{$j . $turno}}.{{$dias[$k]}}" value="{{$j . $turno}}.{{$dias[$k]}}"> Alocar
                          @endif
                        </td>
                      @endfor
                    </tr>
                  @endfor
                </table>
              </div>
            </div>
          </div>
        @endfor
        <div class="text-center">
          <button type="reset" class="btn btn-warning">Limpar <i class='fa fa-eraser'></i></button>
          <button type="button" class="btn btn-danger" onClick="history.go(-1)">Cancelar <i class='fa fa-times'></i></button>
          <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
        </div>
      </form>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
