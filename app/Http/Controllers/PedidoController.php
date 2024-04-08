<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::select("SELECT * FROM `pedidos` WHERE pedidos.deleted_at IS null");
        $pedidos = collect($query)->toArray();

        $keyword = $request->get('search');
        $perPage = 4;

        if(!empty($keyword)) {
            $pedidos = Pedido::where('id','LIKE',"%$keyword%")
            ->orWhere('clientes_id','LIKE',"$keyword")
            ->orWhere('pedidos_produtos_id','LIKE',"$keyword");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pedidos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'clientes_id' => 'required',
            'contatos_id' => 'required',
        ]);

        $pedido = new Pedido();
        
        $pedido->clientes_id = $request->clientes_id;
        $pedido->contatos_id = $request->produtos_id;

        $pedido->save();
        return redirect('/pedido')->with('sucess','Pedido criado');
    }

    /**
     * Display the specified resource.
     */
    public function show(pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pedido $pedido)
    {
        //
    }
}
