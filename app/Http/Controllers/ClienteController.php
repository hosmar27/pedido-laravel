<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::select("SELECT * FROM `clientes` WHERE clientes.deleted_at IS null");
        $clientes = collect($query)->toArray();

        $keyword = $request->get('search');
        $perPage = 4;

        if(!empty($keyword)){
            $clientes = Cliente::where('nome','LIKE',"%$keyword%")
                ->orWhere('cnpj','LIKE',"%$keyword%")
                ->orWhere('endereco','LIKE',"%$keyword%")
                ->orWhere('telefone','LIKE',"%$keyword%")
                ->latest()->paginate($perPage);
        }else{
            $clientes = Cliente::latest()->paginate($perPage);
        }

        return view('clientes.index', ['clientes'=>$clientes])->with('i',(request()->input('page',1) -1) *4);
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
        return redirect()->route('cliente.index')->with('sucess','Cliente criado');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        //dd($cliente);
        return view('clientes.edit',['cliente'=>$cliente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $cliente = Cliente::find($request->id);
        $cliente->nome = $request->input('nome');
        $cliente->cnpj = $request->input('cnpj');
        $cliente->endereco = $request->input('endereco');
        $cliente->telefone = $request->input('telefone');  
        
        $cliente->save();       // Salvou os novos dados no DB
        return redirect('/cliente')->with('update','Cliente atualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        Cliente::find($cliente->id)->delete();
        return redirect()->route('/cliente')->with('delete','Cliente excluido');
    }

    public function fetchCliente()
    {
        $data['clientes'] = Cliente::get(["nome","id"]);
        return view('pedidos.create', $data);
    }

    public function fetchContato(Request $request)
    {
        $data['contatos'] = Contato::where("deleted_at", $request->contato_id)->get(["nome","id"]);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }
}