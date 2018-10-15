<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReservaRequest;
use App\Http\Requests\ReservaSpecificDate;
use App\Http\Requests\ReservaSpecificDateRedirection;
use App\Recurso;
use App\Regra;
use App\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;

class ReservaController extends Controller
{

    /**
     * Redireciona o usuário para a página de quadro de reservas após ter escolhido o recurso
     * @param Request $request Requisição com os campos validados
     * @return \Illuminate\Http\RedirectResponse Redirecionamento para a página apropriada
     */
    public function selectedRedirection(Request $request)
    {
        return redirect()->route('reserva.show', $request->get('recurso'));
    }

    /**
     * Redireciona o usuário para a página apropriada após ter escolhido uma data e um recurso para visualizar as
     * reservas
     * @param ReservaSpecificDateRedirection $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectedByDateRedirection(ReservaSpecificDateRedirection $request)
    {
        // Transformação da data do formato dd/mm/aaaa para o formato ISO aaaa-mm-dd
        $data = Carbon::createFromFormat('d/m/Y', $request->get('data'))->format('Y-m-d');

        return redirect()->route('reserva.show.date', [
            'recurso' => $request->get('recurso'),
            'data' => $data
        ]);
    }

    /**
     * Renderiza tanto o quadro de reservas preenchido como a view com os horários que podem ser reservados.
     * @param Recurso $recurso Recurso que terá suas reservas visualizadas
     */
    public function show(Recurso $recurso) {

            $regras = Regra::first();

            // Se for um usuário autenticado, é necessário recuperar a quantidade de dias reserváveis para a montagem do
            // quadro de reservas. Se o usuário não estiver autenticado usa-se o padrão de uma semana para a montagem.
            if(auth()->check()) $quantidadeDias = $regras->quantidade_dias_reservaveis;
            else $quantidadeDias = 8;

            // Obtém todas as datas possíveis já formatadas para exibir na view
            $datas = array();
            for ($i = 0; $i < $quantidadeDias; ++$i) $datas[$i] = Carbon::now()->addDays($i)->format('d/m/Y');

            // Faixa de dias a qual as reservas serão recuperada
            $dataInicial = Carbon::now()->subDays(1)->format('Y-m-d'); // Reservas a partir deste dia
            $dataFinal = Carbon::now()->addDays($quantidadeDias)->format('Y-m-d'); // Até este dias

            // Recupera as reservas para uma determinada faixa de tempo de um determinado recurso
            $reservas = $recurso->reservas()->iniciandoEm($dataInicial)->finalizandoEm($dataFinal)->get();
            $reservas->load('usuario'); // Carrega previamente as informações dos usuários que fizeram reservas

            return view("reserva.show")->with([
                "reservas" => $reservas,
                "recurso" => $recurso,
                "datas" => $datas,
                "regras" => $regras]);
    }

    /**
     * Realiza as reservas escolhidas pelo usuário de um determinado recurso.
     * @param AddReservaRequest $request Requisão com campos validados
     */
    public function store(AddReservaRequest $request)
    {
        $reservas = $request->get('reservas'); // Aulas selecionadas value="{{$j . $turno}}.{{$dias[$k]}}"
        $tipo = "Erro"; // Tipo do retorno do resultado da ação

        if(!isset($reservas))
        {
            $mensagem = 'Você não selecionou nenhum horário.';
            Log::warning("O Usuário " . auth()->id() . " de nome " . auth()->user()->nome .
                " tentou reservar um recurso sem selecionar nenhum horário.");
        }
        else
        {
            $recurso_id = $request->get('id'); // Id do recurso a ser reservado
            $reservasParaInserir = []; // array de reservas a serem inseridas no banco
            $i = 0; // índice do array de reservas

            // Todas as reservas feitas pelo o usuário até então
            $reservasDoUsuario = auth()->user()->reservas()->get();
            $reservasDoUsuario->load('recurso');

            foreach ($reservas as $reservaBruta) // Para todas as aulas selecionadas
            {
                // Recupera o conjunto de informações sobre a reserva
                // Os índices são 'dia', 'horario' e 'turno'
                // True é usado para que retorne um array associativo ao invés de um objeto StdClass
                $novaReserva = json_decode($reservaBruta, true);

                // Recupera todas as reservas feitas pelo usuário no dia da reserva atual
                //$reservasDoUsuario = Reserva::with('recurso')->em($novaReserva['dia'])->where('usuario_id', $usuario_id)->get();
                //$reservasDoDia = auth()->user()->reservas()->em($novaReserva['dia'])->get();

                $reservasDoDia = $reservasDoUsuario->filter(function ($reserva) use ($novaReserva) {
                    return $reserva->data == $novaReserva['dia'];
                });

                // Verifica se o usuário não reservou outro recurso no mesmo horário
                foreach ($reservasDoDia as $reserva)
                {
                    // Se o usuário possuir uma reserva de outro recurso no mesmo turno e horário da reserva que está
                    // requisitando e se ele não for administrador, então ele não pode fazer a reserva.
                    if($reserva->horario == $novaReserva['horario']
                        && $reserva->turno == $novaReserva['turno']
                        && !auth()->user()->isAdmin())
                    {
                        // Recuperação do turno para inserir no log
                        if($reserva->turno == 'm') $turno = 'matutino';
                        else if($reserva->turno == 'v') $turno = 'vespertino';
                        else $turno = 'noturno';

                        Log::warning("O Usuário " . auth()->id() . " de nome " . auth()->user()->nome .
                            " tentou reservar mais de um recurso no mesmo horário.");

                        $mensagem = "Você já reservou " . $reserva->recurso->nome . " para o ".
                            $reserva->horario . "º horário do turno " . $turno .
                            ". Contate o Administrador caso REALMENTE necessite de vários recursos no mesmo horário.";

                        break;
                    }
                } // end foreach interno

                if(isset($mensagem)) break;

                // Se não houve nenhuma reserva do usuário para o mesmo horário para outro recurso então ele pode
                // realizar a reserva
                $reservasParaInserir[$i++] = [
                    'data' => $novaReserva['dia'],
                    'horario' => $novaReserva['horario'],
                    'turno' => $novaReserva['turno'],
                    'usuario_id' => auth()->id(),
                    'recurso_id' => $recurso_id
                ];
            } // end foreach externo
        }

        // Se o array de reservas não estiver vazio e nenhuma mensagem de erro foi definida então existem reservas a
        // serem gravadas no banco
        if(!empty($reservasParaInserir) && !isset($mensagem))
        {
            try
            {
                Reserva::insert($reservasParaInserir);
                $tipo = "Sucesso";
                $mensagem = "Recurso reservado com sucesso.";
            }
            catch(\Exception $ex)
            {
                $mensagem = "Falha ao inserir reservas: " . $ex->getMessage();
            }
        }

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return back();
    }

    /**
     * Desfaz uma reserva previamente feita.
     * @param Reserva $reserva Instância da reserva a ser excluída
     */
    public function destroy(Reserva $reserva)
    {
        try
        {
            $reserva->delete();
            $tipo = "Sucesso";
            $mensagem = "Reserva cancelada com suceso.";
        }
        catch(\Exception $ex)
        {
            $tipo = "Erro";
            $mensagem = "Erro ao tentar cancelar a reserva: " . $ex->getMessage();
        }

        session()->flash("tipo", $tipo);
        session()->flash("mensagem", $mensagem);

        return back();
    }

    /**
     * Renderiza uma view contendo todas as alocações feitas para um recurso em uma determinada data.
     * @param ReservaSpecificDate $request Requisição com os campos validados
     * @param Recurso $recurso Recurso que terá suas reservas visualizadas em um determinado dia
     */
    public function specificDate(ReservaSpecificDate $request, Recurso $recurso)
    {
        // Recupera todas as reservas feitas em uma data para um determinado recurso
        $reservas = $recurso->reservas()->with('usuario')->em($request->get('data'))->get();
        $regras = Regra::first();
        $datas[] = Carbon::createFromFormat('Y-m-d', $request->get('data'))->format('d/m/Y');

        return view('reserva.show')->with([
            'recurso' => $recurso,
            'reservas' => $reservas,
            'datas' => $datas,
            'regras' => $regras]);
    }
}
