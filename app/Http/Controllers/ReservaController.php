<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReservaRequest;
use App\Http\Requests\DetailsReservaRequest;
use App\Recurso;
use App\Regra;
use App\Reserva;
use App\ReservaLegado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;

class ReservaController extends Controller
{
    /**
     * Exibe a view de seleção de recurso a ser visualizado. A view é a mesma para a consulta em dia específico.
     */
    public function select()
    {
        $recursos = Recurso::where('status', 1)->get();
        return view('reserva.select')->with(['recursos' => $recursos]);
    }

    /**
     * Renderiza tanto o quadro de reservas preenchido como a view com os horários que podem ser reservados.
     */
    public function show(Request $request) {

        // Obtém o ID do recurso da sessão caso tnha vindo de um redirecionamento de alocação/desalocação senão recupera do formulário de seleção
        $recurso_id = session()->pull('allocationRedirection', $request->get('recurso'));

        // Tratamento para usuários autenticados que fecham o navegador nesta tela e tentam reinicar o processo através de tal página
        // Comum acontecer com dispositivos móveisque realizam cache do endereço e tentam renovar a requisição
        if(is_null($recurso_id))
        {
            Log::warning("O Usuário " . auth()->user()->cpf . " de nome " . auth()->user()->nome ." tentou acessar o quadro de viualização provavelmente via POST sem o ID do recurso.");
            abort(428);
        }
        else
        {
            $regras = Regra::first();
            $recurso = Recurso::find($recurso_id);

            // Obtém o recurso e define a view que será renderizada pelo tipo do usuário
            if(auth()->check())
            { // Selecionado por um usuário autenticado
                $quantidadeDias = $regras->quantidade_dias_reservaveis;
            }
            else
            { // Selecionado por um usuário não autenticado
                $quantidadeDias = 8;
            }

            // Obtém todas as datas possíveis já formatadas para exibir na view
            $datas = array();
            for ($i = 0; $i < $quantidadeDias; ++$i) $datas[$i] = Carbon::now()->addDays($i)->format('d/m/Y');

            // Faixa de dias a qual a reserva será recuperada
            $diaInicial = Carbon::now()->subDays(1)->format('Y-m-d'); // Reservas a partir deste dia
            $diaFinal = Carbon::now()->addDays($quantidadeDias)->format('Y-m-d'); // Até este dias

            // Recupera as reservas para uma determinada faixa de tempo de um determinado recurso
            $reservas = Reserva::with('usuario')->where('data', '>=', $diaInicial)->where('data', '<=', $diaFinal)->where('recurso_id', $recurso->id)->get();

            return view("reserva.show")->with(["reservas" => $reservas, "recurso" => $recurso, "datas" => $datas, "regras" => $regras, 'quantidadeDias' => $quantidadeDias]);
        }
    }

    /**
     * Realiza as reservas escolhidas pelo usuário de um determinado recurso.
     */
    public function store(AddReservaRequest $request)
    {
        $reservas = $request->get('reservas'); // Aulas selecionadas value="{{$j . $turno}}.{{$dias[$k]}}"
        if(!isset($reservas))
        {
            // Se nenhum horário foi selecionado, então volta para a página de seleção
            session()->flash('tipo', 'Erro');
            session()->flash('mensagem', 'Você não selecionou nenhum horário.');
            session()->flash("allocationRedirection", $request->get('id'));
            Log::warning("O Usuário " . auth()->user()->cpf . " de nome " . auth()->user()->nome ." tentou reservar um recurso sem selecionar nenhum horário.");
            return back();
        }
        else
        {
            $usuario_id = auth()->user()->cpf;
            $recurso_id = $request->get('id');

            $tipo = "Erro";

            $reservasParaInserir = []; // array de reservas a serem inseridas no banco
            $i = 0; // índice do array de reservas

            foreach ($reservas as $reserva) // Para todas as aulas selecionadas
            {
                // Recupera o conjunto de informações sobre a reserva
                // Os índices são 'dia', 'horario' e 'turno'
                $novaReserva = json_decode($reserva, true); // True é usado para que retorne um array associativo ao invés de um objeto StdClass

                // Recupera todas as reservas feitas pelo usuário no dia da reserva atual
                $reservasDoUsuario =  Reserva::with('recurso')->where('usuario_id', $usuario_id)->where('data', $novaReserva['dia'])->get();

                // Verifica se o usuário não reservou outro recurso no mesmo horário
                foreach ($reservasDoUsuario as $reservaExistente)
                {
                    if($reservaExistente->horario == $novaReserva['horario'] && $reservaExistente->turno == $novaReserva['turno'] && !auth()->user()->isAdmin())
                    {
                        switch ($reservaExistente->turno)
                        {
                            case 'm':
                                $turno = "matutino";
                                break;
                            case 'v':
                                $turno = "vespertino";
                                break;
                            case 'n':
                                $turno = "noturno";
                                break;
                            default:
                                $turno = "Não definido";
                                break;
                        }

                        Log::warning("O Usuário " . auth()->user()->cpf . " de nome " . auth()->user()->nome ." tentou reservar mais de um recurso no mesmo horário");

                        session()->flash('tipo', "Erro");
                        session()->flash('mensagem',
                            "Você já reservou " . $reservaExistente->recurso->nome . " para o ". $reservaExistente->horario ."º horário do turno " . $turno .
                            ". Contate o NTI caso REALMENTE necessite de vários recursos no mesmo horário.");
                        session()->flash("allocationRedirection", $recurso_id);
                        return back();
                    }
                }

                $reservasParaInserir[$i] = [
                    'data' => $novaReserva['dia'],
                    'horario' => $novaReserva['horario'],
                    'turno' => $novaReserva['turno'],
                    'usuario_id' => $usuario_id,
                    'recurso_id' => $recurso_id
                ];

                ++$i;
            } // end foreach

            $total = Reserva::insert($reservasParaInserir);

            // Verifica se todas as reseervas foram inseridas
            if($total == count($reservas))
            {
                $tipo = "Sucesso";
                $mensagem = "Recurso reservado com sucesso.";
            }
            else $mensagem = "Falha de SQL ao inserir reservas";

            session()->flash("mensagem", $mensagem);
            session()->flash("tipo", $tipo);
            session()->flash("allocationRedirection", $recurso_id);
            return back();
        }
    }

    /**
     * Desfaz uma reserva previamente feita.
     * @param Reserva $reserva Instância da reserva a ser excluída
     */
    public function delete(Reserva $reserva)
    {
        session()->flash('allocationRedirection', $reserva->recurso_id);
        $deleted = $reserva->delete();

        if ($deleted)
        {
            $tipo = "Sucesso";
            $mensagem = "Reserva cancelada com suceso.";
        }
        else
        {
            $tipo = "Erro";
            $mensagem = "Erro ao tentar cancelar a reserva.";
        }

        session()->flash("tipo", $tipo);
        session()->flash("mensagem", $mensagem);

        return back();
    }

    /**
     * Recupera as reservas feitas em uma determinada data.
     * @param string $data Data no formato d/m/Y
     * @param Recurso $recurso Instância do recurso a ser procurada.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    private function searchAllocationsAt($data, $recurso)
    {

        // Reservas cadastradas no sistema atual
        $reservas = Reserva::with('usuario')->where('data', $data)->where('recurso_id', $recurso->id)->get();

        // Reservas cadastradas no sistema legado
        $reservasAntigas = ReservaLegado::with('usuario')->where('data', $data)->where('recurso_id', $recurso->id)->get();

        // Concatenação de resultados
        foreach ($reservasAntigas as $antiga) $reservas->add($antiga);

        return $reservas;
    }

    /**
     * Renderiza uma view contendo todas as alocações feitas para um recurso em uma determinada data.
     */
    public function details(DetailsReservaRequest $request)
    {
        $form = $request->all();
        $recurso = Recurso::find($form['recurso']);
        $regras = Regra::first();

        // Formata a data do formato d/m/Y para o formato Y-m-d
        $data = Carbon::createFromFormat('d/m/Y', $form['data'])->format('Y-m-d');

        // Recupera todas as reservas feitas em uma data para um determinado recurso
        $reservas = $this->searchAllocationsAt($data, $recurso);

        return view('reserva.details')->with(['recurso' => $recurso, 'reservas' => $reservas, 'data' => $form['data'], 'regras' => $regras]);
    }
}
