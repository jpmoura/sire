@extends('layout.base')

@section('title')
    Consulta de reserva em data específica
@endsection

@section('page_icon')
    <i class="fa fa-search-plus"></i>
@endsection

@section('description')
    Aqui estão as reservas feitas para {!! $recurso->nome !!} em {{ $data }}
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            @if(count($reservas) == 0)
                <h2 class="text-center">Não há nenhuma reserva para esse dia</h2>
            @else
                <h2 class="text-center">{!! $recurso->nome !!}</h2>
                @for($i=0; $i < 3; ++$i)
                    <div class="box box-primary-ufop collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="text-center">
                                <a href="#" style="color: black;" data-widget="collapse">
                                    @if($i == 0)
                                        <i class="fa fa-sun-o"></i> Turno Matutino
                                        @php
                                            $qtdAulas = $regras->quantidade_horarios_matutino;
                                            $turno = 'm';
                                            $inicio = $regras->horario_inicio_matutino;
                                        @endphp
                                    @elseif($i == 1)
                                        <i class="fa fa-cloud"></i> Turno Vespertino
                                        @php
                                            $qtdAulas = $regras->quantidade_horarios_vespertino;
                                            $turno = 'v';
                                            $inicio = $regras->horario_inicio_vespertino;
                                        @endphp
                                    @else
                                        <i class="fa fa-moon-o"></i> Turno Noturno
                                        @php
                                            $qtdAulas = $regras->quantidade_horarios_noturno;
                                            $turno = 'n';
                                            $inicio = $regras->horario_inicio_noturno;
                                        @endphp
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
                                    @php
                                        $intervalo = 0;
                                        $addTime = 0;
                                        $initTime = strtotime($inicio);
                                    @endphp

                                    @for($j=1; $j <= $qtdAulas; ++$j)
                                        <tr>
                                            {{--Adicionar o addTime ao tempo de inicio--}}
                                            <?php $endTime = strtotime("+50 minutes", $initTime); ?>

                                            <td>{{ date('H:i', $initTime) }} - {{ date('H:i', $endTime) }}</td>

                                            @php
                                                $initTime = $endTime;
                                                ++$intervalo;

                                                // Adicionar 20 minutos de intervalo a cada duas aulas
                                                // exceto para o horário entre o intervalo de 1h do turno vespertino e noturno
                                                if(($intervalo % 2) == 0) $initTime = strtotime("+20 minutes", $initTime);
                                                if($intervalo == 4 && $turno == 'v') $initTime = strtotime("-15 minutes", $initTime);

                                                $status = false;
                                            @endphp

                                            {{-- Olhar se alguma alocacao pertence aquele horario daquele turno  --}}
                                            <td>
                                                @foreach($reservas as $reserva)
                                                    @if($reserva->horario == $j && $reserva->turno == $turno) {{-- Se for igual então está reservado --}}
                                                        <a href="mailto:{!! $reserva->usuario->email !!}?subject=[UFOP-ICEA] Alocação">
                                                            {!! $reserva->usuario->nome !!}
                                                        </a>
                                                        <?php $status = true; ?>
                                                        @break
                                                    @endif
                                                @endforeach
                                                @if(!$status)
                                                    <span class="text-success text-bold">Livre</span>
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
