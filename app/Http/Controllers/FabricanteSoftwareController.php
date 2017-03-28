<?php

namespace App\Http\Controllers;

use App\FabricanteSoftware;
use Illuminate\Http\Request;
use App\Http\Requests;

class FabricanteSoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fabricanteSoftware.index')->with('fabricantes', FabricanteSoftware::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fabricanteSoftware.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateFabricanteRequest $request)
    {
        try
        {
            $fabricante = FabricanteSoftware::create([
                'nome' => $request->get('nome')
            ]);

            $mensagem = "Fabricante adicionado com sucesso";
            $tipo = 'Sucesso';
        }
        catch (\Exception $e)
        {
            $mensagem = $e->getMessage();
            $tipo = 'Erro';
        }

        session()->flash('mensagem', $mensagem);
        session()->flash('tipo', $tipo);

        return redirect()->route('fabricante.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FabricanteSoftware $fabricante)
    {
        return view('fabricanteSoftware.edit')->with('fabricante', $fabricante);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\EditFabricanteRequest $request, FabricanteSoftware $fabricante)
    {
        try
        {
            $fabricante->update([
                'nome' => $request->get('nome'),
            ]);

            $tipo = "Sucesso";
            $mensagem = "Fabricante alterado com sucesso";
        }
        catch (\Exception $e)
        {
            $tipo = "Erro";
            $mensagem = $e->getMessage();
        }

        session()->flash('tipo', $tipo);
        session()->flash('mensagem', $mensagem);

        return redirect()->route('fabricante.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FabricanteSoftware $fabricante)
    {
        try
        {
            $fabricante->delete();
            $tipo = 'Sucesso';
            $mensagem = 'Fabricante removido com sucesso';
        }
        catch (\Exception $e)
        {
            $tipo = 'Erro';
            $mensagem = $e->getMessage();
        }

        session()->flash('tipo', $tipo);
        session()->flash('mensagem', $mensagem);

        return redirect()->route('fabricante.index');
    }
}
