<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Marca;
use App\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos.index',compact(['produtos']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas = Marca::all();
        $departamentos = Departamento::all();
        return view('produtos.create', 
            compact(['marcas','departamentos']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $p = new Produto();
        $p->nome = $request->nome;
        $p->estoque = $request->estoque;
        $p->preco = $request->preco;
        $p->marca_id = $request->marca_id;
        $p->save();
        
        // Cria os registros na tabela produto_departamento
        // um registro para cada departamento no array
        $p->departamentos()->sync( $request->departamentos );

        return redirect()->route('produtos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        $marcas = Marca::all();
        $departamentos = Departamento::all();
        return view('produtos.edit', 
                    compact(['produto', 'marcas', 'departamentos']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto)
    {
        $produto->nome = $request->nome;
        $produto->estoque = $request->estoque;
        $produto->marca_id = $request->marca_id;
        $produto->preco = $request->preco;
        $produto->save();
        $produto->departamentos()->sync( $request->departamentos );
        return redirect()->route('produtos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index');
    }
}
