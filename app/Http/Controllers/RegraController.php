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
    public function index()
    {
        return view('regra.index')->with(['regras' => Regra::first()]);
    }

    /**
     * Exibe o formulário com os detalhes da regra de horário que são passíveis de edição
     */
    public function edit(Regra $regras)
    {
        return view('regra.edit')->with('regras', $regras);
    }

    /**
     * Edita os dados da regra de horário
     */
    public function update(Requests\EditRegraRequest $request, $regras)
    {
            $tipo = "Erro";

            try
            {
                $regras->update($request->all());
                $tipo = "Sucesso";
                $mensagem = "Atualização feita com sucesso!";
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
