<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use Session;
use Input;
use Illuminate\Support\Facades\Redirect;
use Log;
use App\Rule;

class RuleController extends Controller
{
    /**
     * Exibe a visão geral das regras de horários
     */
    public function show()
    {
        $regras = Rule::select("horNumAulaManha as manha", "horNumAulaTarde as tarde", "horNumAulaNoite as noite", "horNumDias as dias")->first();
        Session::put("menu", "showRule");
        return View::make('rule.show')->with(['regras' => $regras]);
    }

    /**
     * Exibe o formulário com os detalhes da regra de horário que são passíveis de edição
     */
    public function details()
    {
        $regras = Rule::select("horNumAulaManha as manha", "horNumAulaTarde as tarde", "horNumAulaNoite as noite", "horNumDias as dias", "horId as id", "inicioManha", "inicioTarde", "inicioNoite")
                    ->first();
        return View::make('rule.edit')->with(['regras' => $regras]);
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

            $regras = Rule::first();
            $regras->horNumAulaManha = $form['manha'];
            $regras->horNumAulaTarde = $form['tarde'];
            $regras->horNumAulaNoite = $form['noite'];
            $regras->horNumDias = $form['dias'];
            $regras->inicioManha = $form['inicioManha'];
            $regras->inicioTarde = $form['inicioTarde'];
            $regras->inicioNoite = $form['inicioNoite'];
            $updated = $regras->save();

            if($updated == 1) {
                $tipo = "Sucesso";
                $mensagem = "Atualização feita com sucesso!";
            }
            else $mensagem .= "Erro no banco de dados ou nas regras. Atualização cancelada.";

            Session::flash("tipo", $tipo);
            Session::flash("mensagem", $mensagem);

            return Redirect::back();
    }
}
