<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Log;
use App\Regra;

class RegraController extends Controller
{
    /**
     * Exibe a visão geral das regras de horários
     */
    public function show()
    {
        return view('regra.show')->with(['regras' => Regra::first()]);
    }

    /**
     * Exibe o formulário com os detalhes da regra de horário que são passíveis de edição
     */
    public function details()
    {
        return view('regra.edit')->with(['regras' => Regra::first()]);
    }

    /**
     * Edita os dados da regra de horário
     */
    public function edit(Requests\EditRegraRequest $request)
    {
            $form = $request->all();
            $tipo = "Erro";
            $mensagem = '';

            $regras = Regra::first()->update([
                'quantidade_horarios_matutino' => $form['manha'],
                'quantidade_horarios_vespertino' => $form['tarde'],
                'quantidade_horarios_noturno' => $form['noite'],
                'horario_inicio_matutino' => $form['inicioManha'],
                'horario_inicio_vespertino' => $form['inicioTarde'],
                'horario_inicio_noturno' => $form['inicioNoite'],
                'quantidade_dias_reservaveis' => $form['dias']
            ]);

            if(isset($regras)) {
                $tipo = "Sucesso";
                $mensagem = "Atualização feita com sucesso!";
            }
            else $mensagem .= "Erro no banco de dados ou nas regras. Atualização cancelada.";

            session()->flash("tipo", $tipo);
            session()->flash("mensagem", $mensagem);

            return back();
    }
}
