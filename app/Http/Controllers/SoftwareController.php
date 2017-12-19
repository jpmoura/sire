<?php

namespace App\Http\Controllers;

use App\FabricanteSoftware;
use App\Software;
use App\Http\Requests;

class SoftwareController extends Controller
{
    /**
     * Renderiza a view com a lista de softwares cadastrados.
     */
    public function index()
    {
        return view('software.index')->with('softwares', Software::with('fabricante')->get());
    }

    /**
     * Renderiza a view com o formulário para cadastro de um novo software
     */
    public function create()
    {
        return view('software.create')->with('fabricantes', FabricanteSoftware::all());
    }

    /**
     * Cria uma nova instância de Software na base de dados.
     *
     * @param Requests\CreateSoftwareRequest $request Requisição com os dados validados
     * @return \Illuminate\Http\RedirectResponse Rota de índice dos softwares
     */
    public function store(Requests\CreateSoftwareRequest $request)
    {
        try
        {
            Software::create([
                'nome' => $request->get('nome'),
                'fabricante_software_id' => $request->get('fabricante'),
                'versao' => $request->get('versao'),
                'status' => $request->get('status'),
            ]);

            $tipo = 'Sucesso';
            $mensagem = 'Software cadastrado com sucesso.';

        }
        catch (\Exception $e)
        {
            $tipo = 'Erro';
            $mensagem = 'Erro ao criar novo software: ' . $e->getMessage();
        }

        session()->flash('tipo', $tipo);
        session()->flash('mensagem', $mensagem);

        return redirect()->route('software.index');
    }

    /**
     * Renderiza a view com o formulário de edição de uma instância de Software
     *
     * @param Software $software Instância a ser editada
     */
    public function edit(Software $software)
    {
        return view('software.edit')->with(['fabricantes' => FabricanteSoftware::all(), 'software' => $software]);
    }

    /**
     * Atualiza uma instância de Software na base de dados
     *
     * @param Requests\EditSoftwareRequest $request Requisição com os campos do formulário já validados
     * @param Software $software Instância a ser editada
     * @return \Illuminate\Http\RedirectResponse Rota de índice de software
     */
    public function update(Requests\EditSoftwareRequest $request, Software $software)
    {
        try
        {
            $software->update([
                'nome' => $request->get('nome'),
                'fabricante_software_id' => $request->get('fabricante'),
                'versao' => $request->get('versao'),
                'status' => $request->get('status'),
            ]);

            $tipo = 'Sucesso';
            $mensagem = 'Software atualizado com sucesso.';

        }
        catch (\Exception $e)
        {
            $tipo = 'Erro';
            $mensagem = 'Falha ao atualizar software: ' . $e->getMessage();
        }

        session()->flash('tipo', $tipo);
        session()->flash('mensagem', $mensagem);

        return redirect()->route('software.index');
    }

    /**
     * Remove uma instância de Software da base de dados.
     *
     * @param Software $software Insância a ser removida
     * @return \Illuminate\Http\RedirectResponse Rota de índice de softwares
     */
    public function destroy(Software $software)
    {
        try
        {
            $software->delete();
            $tipo = 'Sucesso';
            $mensagem = 'Software removido com sucesso';
        }
        catch (\Exception $e)
        {
            $tipo = 'Erro';
            $mensagem = 'Falha ao remover software: ' . $e->getMessage();
        }

        session()->flash('tipo', $tipo);
        session()->flash('mensagem', $mensagem);

        return redirect()->route('software.index');
    }
}
