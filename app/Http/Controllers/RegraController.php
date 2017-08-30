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
    public function details(Regra $regras)
    {
        return view('regra.edit')->with('regras', $regras);
    }

    /**
     * Edita os dados da regra de horário
     */
    public function edit(Requests\EditRegraRequest $request, $regras)
    {
            $tipo = "Erro";
            $mensagem = '';

            try
            {
                $atualizado = $regras->update($request->all());

                if(isset($atualizado)) {
                    $tipo = "Sucesso";
                    $mensagem = "Atualização feita com sucesso!";
                }
                else $mensagem .= "Erro no banco de dados ou nas regras. Atualização cancelada.";
            }
            catch(\Exception $e)
            {
                $mensagem = 'Erro durante a atualização das regras: ' . $e->getMessage();
            }


            session()->flash("tipo", $tipo);
            session()->flash("mensagem", $mensagem);

            return back();
    }
}
