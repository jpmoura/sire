@extends('admin.admin_base')

@section('content')
  <div class='row'>
    <div class='col-md-8 col-md-offset-2'>
      @if(count($alocacoes) == 0)
        <h2 class="text-center">Não há nenhuma alocação para esse dia</h2>
      @else
        <h2 class="text-center">{!! $recurso->nome !!}</h2>
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
                    <th>Reservado por</th>
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

                        <?php $status = false; ?>
                        {{-- Olhar se alguma alocacao pertence aquele horario daquele turno  --}}
                        <td>
                          @foreach($alocacoes as $alocacao)
                            @if($alocacao->aula == ($j . $turno)) {{-- Se for igual então está reservado --}}
                              <a target="_blank" href="mailto:{{$alocacao->email}}?subject=[UFOP-ICEA] Alocação">{{$alocacao->nome}}</a>
                              <?php $status = true; ?>
                              @break
                            @endif
                          @endforeach
                          @if(!$status)
                            <span class="text-success"><b>Livre</b></span>
                          @endif
                        </td>
                    </tr>
                  @endfor
                </table>
              </div>
            </div>
          </div>
        @endfor
      @endif
      <div class="text-center">
        <button class="btn btn-warning" type="button" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
      </div>
    </div>
  </div>
@endsection
