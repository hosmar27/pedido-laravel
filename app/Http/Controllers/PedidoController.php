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
        $query = DB::select("SELECT pedidos.id,cliente_id,contato_id,clientes.nome,contatos.nome 
        FROM `pedidos`
        JOIN `clientes` ON `pedidos`.ID = `clientes`.ID
        JOIN `contatos` ON `contatos`.ID = `clientes`.ID"); //pedidos.cliente_id=clientes.nome pedidos.contato_id=contatos.nome 
        $pedidos = collect($query)->toArray();
        $query = DB::select("SELECT clientes.id, clientes.nome FROM `clientes` INNER JOIN `pedidos`ON clientes.id = pedidos.cliente_id WHERE pedidos.deleted_at AND clientes.deleted_at IS null");
        $clientes = collect($query)->toArray();
        $query = DB::select("SELECT contatos.id, contatos.nome FROM `contatos` INNER JOIN `clientes`ON contatos.clientes_id = clientes.id WHERE clientes.deleted_at AND contatos.deleted_at IS null");
        $contatos = collect($query)->toArray();

        $keyword = $request->get('search');
        $perPage = 2;

        if (!empty($keyword)) {
            $pedidos = Pedido::where('id', 'LIKE', "%$keyword%")
                ->orWhere('cliente_id', 'LIKE', "$keyword")
                ->orWhere('pedido_id', 'LIKE', "$keyword")
                ->latest()->paginate($perPage);
        } else {
            $pedidos = Pedido::latest()->paginate($perPage);
        }

        return view('pedidos.index', ['pedidos' => $pedidos])->with('i', (request()->input('page', 1) - 1) * 2);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = DB::select("SELECT * FROM `clientes` WHERE deleted_at IS null");
        $clientes = collect($query)->toArray();
        $query = DB::select("SELECT contatos.nome, contatos.id FROM `contatos` INNER JOIN `clientes` ON clientes.id = contatos.clientes_id AND contatos.deleted_at IS null;");
        $contatos = collect($query)->toArray();
        return view('pedidos.create', ['clientes' => $clientes], ['contatos' => $contatos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pedido = new Pedido();

        $pedido->cliente_id = $request->cliente_id;
        $pedido->contato_id = $request->contato_id;

        $pedido->save();
        return redirect('/pedido')->with('sucess', 'Pedido criado');
    }

    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $query = DB::select("SELECT * FROM `pedidos` WHERE deleted_at IS null");
        $pedido = collect($query)->toArray();
        return view('pedidos.edit', ['pedido' => $pedido]);
    }

    public function update(Request $request, Pedido $pedido)
    {
        $pedido = Pedido::find($request->id);
        $pedido->cliente = $request->select('cliente_id');
        $pedido->cliente = $request->select('contato_id');

        $pedido->save();
        return redirect()->route('pedido.index')->with('update','Contato atualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pedido $pedido)
    {
        Pedido::find($pedido->id)->delete();
        return redirect()->route('contato.index')->with('delete','Contato excluido');
    }
}