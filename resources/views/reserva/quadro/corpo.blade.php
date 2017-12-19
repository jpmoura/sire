<?php
    setlocale(LC_ALL, "pt_BR", "pt_BR.utf8", "pt_BR.iso-8859-1", "Portuguese_Brazil.1252", "portuguese");
    $horariosSeguidos = 0;
    $tempoDeIntervaloBruto = explode(":", $regras->intervalo_entre_horarios_seguidos);
    $tempoDeIntervalo = 60 * (int) $tempoDeIntervaloBruto[0] + (int) $tempoDeIntervaloBruto[1];
    $tempoInicial = 0;
    
    if($turno == "m")
    {
        $tempoInicial = $regras->horario_inicio_matutino;
        $quantidadeDeHorarios = $regras->quantidade_horarios_matutino;
    }
    elseif($turno == "v")
    {
        $tempoInicial = $regras->horario_inicio_vespertino;
        $quantidadeDeHorarios = $regras->quantidade_horarios_vespertino;
    }
    else
    {
        $tempoInicial = $regras->horario_inicio_noturno;
        $quantidadeDeHorarios = $regras->quantidade_horarios_noturno;
    }

    $tempoHorarioBruto = explode(":", $regras->tempo_duracao_horario);
    $tempoHorario = intval($tempoHorarioBruto[0]) * 60 + intval($tempoHorarioBruto[1]);
    $tempoInicial = strtotime($tempoInicial);
?>

<div class="box-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover text-center">
            <tr>
                <th>Horário</th>

                {{--
                    Coloca no cabeçalho da tabela todas as datas com o nome do dia. Não é usado o Carbon pois
                    ele não é capaz de traduzir dos dias, por algum motivo, mesmo usando setlocale
                 --}}

                @for($d=0; $d < count($datas); $d++)
                    <th>
                        {!! utf8_encode(ucfirst(strftime("%A", DateTime::createFromFormat('d/m/Y', $datas[$d])->getTimestamp()))) !!} ({{ $datas[$d] }})
                    </th>
                @endfor
            </tr>

            {{-- Para cada dia da semana e para cada horario. %i se refere ao horario e %k aos dias --}}
            @for($i = 1; $i <= $quantidadeDeHorarios; ++$i)
                <tr>

                    {{-- Incrementa o horário --}}
                    <?php $tempoFinal = strtotime("+" . strval($tempoHorario) . " minutes", $tempoInicial); ?>

                    {{-- Imprime o horário a qual aquela linha se refere --}}
                    <td>{{ date('H:i', $tempoInicial) }} - {{ date('H:i', $tempoFinal) }}</td>

                    @php
                        $tempoInicial = $tempoFinal; // Na próxima iteração, o tempo inicial vai ser igual ao final anterior
                        ++$horariosSeguidos;

                        // Adiciona o tempo de intervalo quando se atinge a quantidade definida de horários seguidos
                        if(($horariosSeguidos % $regras->quantidade_horarios_seguidos) == 0)
                            $tempoInicial = strtotime("+" . strval($tempoDeIntervalo) ." minutes", $tempoInicial);

                        // exceto para o horário entre o intervalo de 1h do turno vespertino e noturno (Específico do ICEA)
                        if($horariosSeguidos == 4 && $turno == 'v') $tempoInicial = strtotime("-" . strval($tempoDeIntervalo) ." minutes", $tempoInicial);
                    @endphp

                    {{-- Impressão de cada coluna da linha atual --}}
                    @for($j = 0; $j < count($datas); ++$j)
                        <?php $status = false; ?>

                        {{--Verifica se alguma alocacao pertence aquele horario daquele turno--}}
                        <td>
                            @foreach($reservas as $reserva)

                                {{--Se for igual então está reservado--}}
                                @if($reserva->horario == $i && $reserva->turno == $turno && $reserva->data == \Carbon\Carbon::now()->addDays($j)->format('Y-m-d'))

                                    {{-- Tratamento para não motrar o e-mail e nome dos administradores. Comente este trecho caso queira qu sejam mostrados --}}
                                    @if($reserva->usuario->nivel == 1)
                                        @php
                                            $reserva->usuario->email = "admin@admin.com";
                                            $reserva->usuario->nome = "Administrador";
                                        @endphp
                                    @endif

                                    <a target="_blank" href="mailto:{!! $reserva->usuario->email !!}?subject=[Sistema de Reservas] Alocação do recurso {!! $recurso->nome !!}">
                                        {!! $reserva->usuario->nome !!}
                                    </a>

                                    @if(!Route::is('showAllocatedAssetBoard'))
                                        @if(auth()->user()->isAdmin() || $reserva->usuario->cpf == auth()->user()->cpf)
                                            <br />
                                            <a class="btn btn-warning btn-xs" style="color: white" href="{{ route('deleteAllocation', $reserva->id) }}">
                                                <i class="fa fa-times"></i> Desalocar
                                            </a>
                                        @endif
                                    @endif

                                    <?php $status = true; ?>
                                    {{-- Podemos parar de procurar, pois já encontramos uam reserva para o dia e o horário em questão --}}
                                    @break
                                @endif
                            @endforeach

                            @if(!$status)
                                @if(Route::is('showAllocatedAssetBoard'))
                                    <span class="text-success text-bold">Livre</span>
                                @else
                                    <input type="checkbox" name="reservas[]"
                                           value='{"horario": {{ $i }}, "turno": "{{ $turno }}", "dia": "{{ \Carbon\Carbon::now()->addDays($j)->format('Y-m-d') }}"}' > Alocar
                                @endif
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>
    </div>
</div>