<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoProduto;
use Illuminate\Http\Request;

class PedidoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = PedidoProduto::query()
            ->select('pedidos_produtos.id AS pedidos_produtos_id','pedidos_produtos.preco','pedidos_produtos.total','pedidos_produtos.desconto','pedidos_produtos.frete')
            ->join('pedidos','pedidos.id','=','pedidos_produtos.pedido_id')
            ->wherenull('pedidos.deleted_at')
            ->wherenull('pedidos_produtos.deleted_at');
        $pedidos_produtos = collect($query)->toArray();
        $query = Pedido::query()
            ->select('pedidos.cliente_id','pedidos.contato_id')
            ->join('pedidos_produtos','pedidos_produtos.pedido_id','=','pedidos.id')
            ->wherenull('pedidos.deleted_at')
            ->wherenull('pedidos_produtos.deleted_at');
        $pedidos = collect($query)->toArray();

        return view('pedidos_produtos.index', ['pedidos_produtos'=>$pedidos_produtos, 'pedidos'=>$pedidos])->with('i',(request()->input('page',1) -1) *4);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = DB::select("SELECT * FROM `pedidos_produtos` WHERE deleted_at IS NULL");
        // Usar id produto e id pedido tmb
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PedidoProduto $pedidoProduto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PedidoProduto $pedidoProduto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PedidoProduto $pedidoProduto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PedidoProduto $pedidoProduto)
    {
        //
    }
}
