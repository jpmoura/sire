<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Session;
use Input;
use Illuminate\Support\Facades\Redirect;
use Log;
use Auth;
use Carbon\Carbon;
use App\Asset;
use App\Allocation;
use App\Rule;

class AllocationController extends Controller
{
    /**
     * Exibe a view de seleção de recurso a ser visualizado. A view é a mesma para a consulta em dia específico.
     */
    public function select()
    {
        $assets = Asset::select('equID as id', 'equNome as nome')->where('equStatus', 1)->get();
        return View::make('allocation.select')->with(['recursos' => $assets]);
    }

    /**
     * Renderiza tanto o quadro de reservas preenchido como a view com os horários que podem ser reservados.
     */
    public function show() {

        // Obtém o ID do recurso da sessão caso tnha vindo de um redirecionamento de alocação/desalocação senão recupera do formulário de seleção
        $assetID = Session::pull('allocationRedirection', Input::get('recurso'));

        // Tratamento para usuários autenticados que fecham o navegador nesta tela e tentam reinicar o processo através de tal página
        // Comum acontecer com dispositivos móveisque realizam cache do endereço e tentam renovar a requisição
        if(is_null($assetID))
        {
            Log::warning("O Usuário " . Auth::user()->cpf . " de nome " . Auth::user()->nome ." tentou acessar o quadro de viualização provavelmente via POST sem o ID do recurso.");
            abort(428);
        }
        else
        {
            $rule = Rule::select('horNumAulaManha as manha', 'horNumAulaTarde as tarde', 'horNumAulaNoite as noite', 'horNumDias as diasQtd', 'inicioManha', 'inicioTarde', 'inicioNoite')->first();
            $assetName = Asset::select("equNome as nome")->where("equId", $assetID)->first()->nome;

            // Obtém o recurso e define a view que será renderizada pelo tipo do usuário
            if(Auth::check())
            { // Selecionado por um usuário autenticado
                //$view = "allocation.add";
                $totalDays = (int) $rule->diasQtd;
            }
            else
            { // Selecionado por um usuário não autenticado
                //$view = 'allocation.show';
                $totalDays = 8;
            }

            // Obtém todas as datas possíveis já formatadas para exibir na view
            $weekDays = array();
            for ($i = 0; $i < $totalDays; ++$i) $weekDays[$i] = Carbon::now()->addDays($i)->format('j/m/y');

            $initialDay = Carbon::now()->subDays(1); // Reservas a partir deste dia
            $finalDay = Carbon::now()->addDays($totalDays); // Até este dias

            $allocations = DB::table('tb_alocacao')->join('ldapusers', 'cpf', '=', 'tb_alocacao.usuId')
                ->select("aloId as reservaID", "cpf as autorID", "nome as autorNOME", "email as autorEMAIL", "equId as recursoID", "aloData as data", "aloAula as aula")
                ->where(DB::raw("STR_TO_DATE(aloData, '%d/%m/%y')"), ">=", $initialDay)
                ->where(DB::raw("STR_TO_DATE(aloData, '%d/%m/%y')"), "<=", $finalDay)
                ->where("equId", $assetID)
                ->get();

            return View::make("allocation.show")->with(["alocacoes" => $allocations, "recursoNome" => $assetName, "recursoID" => $assetID, "dias" => $weekDays, "regras" => $rule, 'totalDays' => $totalDays]);
        }
    }

    /**
     * Realiza as reservas escolhidas pelo usuário de um determinado recurso.
     */
    public function store()
    {
        $userID = Auth::user()->cpf;
        $assetID = (int) Input::get('id');

        $tipo = "Erro";

        $allocations = Input::get('reservas'); // Aulas selecionadas value="{{$j . $turno}}.{{$dias[$k]}}"
        $toInsert = []; // array de reservas a serem inseridas no banco
        $i = 0; // índice do array de reservas

        foreach ($allocations as $allocation) // Para todas as aulas selecionadas
        {
            // Recupera o conjunto de informações sobre a reserva
            // Os índices são 'dia', 'horario' e 'turno'
            $newAllocation = json_decode($allocation, true); // True é usado para que retorne um array associativo ao invés de um objeto StdClass

            // Recupera todas as reservas feitas pelo usuário no dia da reserva atual
            $userAllocationsAt = Allocation::select('equId', 'aloAula')->where('usuId', $userID)->where('aloData', $newAllocation['dia'])->get();

            // Define a aula (conjunto do horario concatenado com o turno)
            $schedule = $newAllocation['horario'] . $newAllocation['turno'];

            // Verifica se o usuário não reservou outro recurso no mesmo horário
            foreach ($userAllocationsAt as $previousAllocation)
            {
                if($previousAllocation->aloAula == $schedule && Auth::user()->nivel != 1)
                {
                    Log::warning("O Usuário " . Auth::user()->cpf . " de nome " . Auth::user()->nome ." tentou reservar mais de um recurso no mesmo horário");
                    Session::flash('tipo', "Erro");
                    Session::flash('mensagem', "Você já reservou outro recurso para o mesmo horário. Contate o NTI caso REALMENTE necessite de vários recursos.");
                    Session::flash("allocationRedirection", $assetID);
                    return Redirect::back();
                }
            }

            $toInsert[$i] = array('aloData' => $newAllocation['dia'], 'aloAula' => $schedule, 'usuId' => $userID, 'equId' => $assetID);
            ++$i;
        } // end for each

        $total = Allocation::insert($toInsert);

        // Verifica se todas as reseervas foram inseridas
        if($total == count($allocations))
        {
            $tipo = "Sucesso";
            $mensagem = "Recurso reservado com sucesso.";
        }
        else $mensagem = "Falha de SQL ao inserir reservas";

        Session::flash("mensagem", $mensagem);
        Session::flash("tipo", $tipo);
        Session::flash("allocationRedirection", $assetID);
        return Redirect::back();
    }

    /**
     * Desaloca um recurso de uma reserva previamente feita
     * @param $id ID da alocação
     */
    public function delete($id)
    {
        $reservista = Allocation::select("usuId as id", "equId as equipamento")->where("aloId", $id)->first();

        // USAR UM GUARD PARA VERIFICAR SE O USUÁRIO É DONO DA RESERVA

        if(Auth::user()->isAdmin() || $reservista->id == Auth::user()->cpf)
        {
            $deleted = Allocation::destroy($id);
            if ($deleted)
            {
                $tipo = "Sucesso";
                $mensagem = "Recurso desalocado com sucesso.";
            }
            else
            {
                $tipo = "Erro";
                $mensagem = "Erro ao tentar desalocar o recurso.";
            }
        }
        else abort(403);

        Session::flash("tipo", $tipo);
        Session::flash("mensagem", $mensagem);
        Session::flash('allocationRedirection', $reservista->equipamento);
        return Redirect::back();
    }

    /**
     * Recupera todas as alocações feitas para um recurso em uma determinada data. Combina a tabela de usuários antigos e novos nas busca caso o usuário busque por
     * uma reserva feita no sistema legado.
     * @param $date Data da reserva
     * @param $resource Recurso da reserva
     * @return array Alocações feitas
     */
    private function searchAllocationsAt($date, $resource)
    {
        $newAllocations = DB::table('tb_alocacao')->join('ldapusers', 'cpf', '=', 'usuId')
            ->select('nome', 'email', 'aloAula as aula')
            ->where('aloData', $date)
            ->where('equId', $resource)
            ->get();

        $oldAllocations = DB::table('tb_alocacao')->join('tb_usuario', 'tb_usuario.usuId', '=', 'tb_alocacao.usuId')
            ->select('tb_usuario.usuNome as nome', 'tb_usuario.usuEmail as email', 'aloAula as aula')
            ->where('aloData', $date)
            ->where('equId', $resource)
            ->get();

        $allocations = array_merge($oldAllocations, $newAllocations);
        return $allocations;
    }

    /**
     * Renderiza uma view contendo todas as alocações feitas para um recurso em uma determinada data.
     */
    public function details()
    {
        $form = Input::all();
        $asset = Asset::select('equNome as nome')->where('equId', $form['recurso'])->first();
        $rule = Rule::select('horNumAulaManha as manha', 'horNumAulaTarde as tarde', 'horNumAulaNoite as noite', 'horNumDias as diasQtd', 'inicioManha', 'inicioTarde', 'inicioNoite')->first();

        // Recupera todas as reservas feitas em uma data para um determinado recurso
        $allocations = $this->searchAllocationsAt($form['data'], $form['recurso']);

        return View::make('allocation.details')->with(['recurso' => $asset, 'alocacoes' => $allocations, 'data' => $form['data'], 'regras' => $rule]);
    }
}
