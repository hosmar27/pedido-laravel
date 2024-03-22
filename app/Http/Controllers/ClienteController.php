<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = DB::select("SELECT * FROM clientes");
        $clientes = collect($query)->toArray();
        return view('clientes.index', ['clientes'=>$clientes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(view: 'clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'cnpj' => 'required'
        ]);

        $cliente = new Cliente();

        $cliente->nome = $request->nome;
        $cliente->cnpj = $request->cnpj;
        $cliente->telefone = $request->telefone;
        $cliente->endereco = $request->endereco;

        $cliente->save();
        return redirect()->route('cliente.index')->with('sucess','Product added sucessfuly');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $id)
    {
        $cliente = Cliente::find($id);
        return view('clientes.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $id)
    {
        $cliente = Cliente::find($id);
        $cliente->nome = $request->input('nome');
        $cliente->cnpj = $request->input('cnpj');
        $cliente->endereco = $request->input('endereco');
        $cliente->telefone = $request->input('telefone');   

        $cliente->save();       // Salvou os novos dados no DB
        return redirect('/clientes')->with('sucess','Cliente atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }
}