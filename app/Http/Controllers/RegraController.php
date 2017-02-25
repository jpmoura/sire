<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
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
    public function edit()
    {
            $form = Input::all();
            $tipo = "Erro";
            $mensagem = '';

            if($form['manha'] > 6) $mensagem .= "O número de horários pode ser no máximo 6 para o turno da manha.\n";
            if($form['tarde'] > 5) $mensagem .= "O número de horários pode ser no máximo 5 para o turno da tarde.\n";
            if($form['noite'] > 4) $mensagem .= "O número de horários pode ser no máximo 4 para o turno da noite.\n";

            $regras = Regra::first();

            $regras->quantidade_horarios_matutino = $form['manha'];
            $regras->quantidade_horarios_vespertino = $form['tarde'];
            $regras->quantidade_horarios_noturno = $form['noite'];
            $regras->quantidade_dias_reservaveis = $form['dias'];
            $regras->horario_inicio_matutino = $form['inicioManha'];
            $regras->horario_inicio_vespertino = $form['inicioTarde'];
            $regras->horario_inicio_noturno = $form['inicioNoite'];

            $updated = $regras->save();

            if($updated == 1) {
                $tipo = "Sucesso";
                $mensagem = "Atualização feita com sucesso!";
            }
            else $mensagem .= "Erro no banco de dados ou nas regras. Atualização cancelada.";

            session()->flash("tipo", $tipo);
            session()->flash("mensagem", $mensagem);

            return back();
    }
}
