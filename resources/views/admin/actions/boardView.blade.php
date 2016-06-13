@if(false)
  @extends('admin.admin_base')
@endif


@section('content')
  <div class='row'>
    <div class='col-md-8 col-md-offset-2 text-center'>
      <h2>Reservas para {{$recursoNome}}</h2>

      @for($i=0; $i < 3; ++$i)
        <div class="box box-primary-ufop collapsed-box">
          <div class="box-header with-border">
            <h3 class="text-center">
              @if($i == 0)
                <i class="fa fa-sun-o"></i> Turno Matutino
                <?php $qtdAulas = $regras->manha; $turno = 'm';?>
              @elseif($i == 1)
                <i class="fa fa-cloud"></i> Turno Vespertino
                <?php $qtdAulas = $regras->tarde; $turno = 'v';?>
              @else
                <i class="fa fa-moon-o"></i> Turno Noturno
                <?php $qtdAulas = $regras->noite; $turno = 'n';?>
              @endif
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
                @for($j=1; $j <= $qtdAulas; ++$j)
                  <tr>
                    <td>{{$j}}º Horário</td>
                    @for($k=0; $k < $diasPossiveis; ++$k)
                      <?php $status = false; ?>
                      {{-- Olhar se alguma alocacao pertence aquele horario daquele turno  --}}
                      <td>
                        @foreach($alocacoes as $alocacao)
                          @if($alocacao->aula == ($j . $turno) && $alocacao->data == $dias[$k]) {{-- Se for igual então está reservado --}}
                            <a target="_blank" href="mailto:{{$alocacao->autorEMAIL}}?subject=(UFOP-ICEA) Alocação do recurso {{$recursoNome}}">{{$alocacao->autorNOME}}</a>
                            <?php $status = true; ?>
                            @break
                          @endif
                        @endforeach
                        @if(!$status)
                          <span class="text-success"><b>Livre</b></span>
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
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
