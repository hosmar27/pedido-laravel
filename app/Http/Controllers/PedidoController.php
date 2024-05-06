<?php

namespace App\Http\Controllers;

use App\Models\{Pedido, Produto, Contato, PedidoProduto};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::select("SELECT pedidos.id, clientes.id, contatos.id, clientes.nome, contatos.nome
        FROM `pedidos`
        JOIN `clientes` ON pedidos.cliente_id = clientes.id 
        JOIN `contatos` ON contatos.id = pedidos.contato_id 
        WHERE pedidos.deleted_at IS NULL
        ORDER BY pedidos.id
        ");
        $pedidos = collect($query)->toArray();

        $keyword = $request->get('search');
        $perPage = 3;

        if (!empty($keyword)) {
            $pedidos = Pedido::where('id', 'LIKE', "%$keyword%")
                ->orWhere('cliente_id', 'LIKE', "$keyword")
                ->orWhere('pedido_id', 'LIKE', "$keyword")
                ->latest()->paginate($perPage);
        } else {
            $pedidos = Pedido::latest()->paginate($perPage);
        }

        return view('pedidos.index', ['pedidos' => $pedidos])->with('i', (request()->input('page', 1) - 1) * 3);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = DB::select('SELECT id,nome FROM `clientes` WHERE deleted_at IS null');
        $clientes = collect($query)->toArray();
        return view('pedidos.create', ['clientes' => $clientes]);
    }

    public function fetchContatos(Request $request)
    {
        $contatos['contatos'] = Contato::where("cliente_id", $request->cliente_id)
                                ->get(["nome", "id"]);

        return response()->json($contatos);
    
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $query = DB::select("SELECT * FROM `clientes` WHERE deleted_at IS null");
        $contato = collect($query)->toArray();
        $query = DB::select("SELECT * FROM `clientes` WHERE deleted_at IS null");
        $clientes = collect($query)->toArray();
        return view('pedidos.edit',['pedido' => $pedido ,'contato' => $contato, 'clientes' => $clientes]);
    }

    public function update(Request $request, Pedido $pedido)
    {
        $pedido = Pedido::find($request->id);
        
        $pedido->cliente_id = $request->input('cliente_id');
        $pedido->contato_id = $request->input('contato_id');

        $pedido->save();
        return redirect()->route('pedido.index')->with('update','Pedido atualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        $pedido = Pedido::find($pedido->id)->delete();
        return redirect('/pedido')->with('delete','Pedido excluido');
    }

    public function indexPedidoProduto()
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
    
    public function addProduto()
    {
        $query = DB::select("SELECT id,nome,valor FROM `produtos` WHERE deleted_at IS NULL");

        $produtos = collect($query)->toArray();
        return view('pedidos_produtos.create', ['produtos'=>$produtos]);
    }

    public function storeProduto(Request $request)
    {
        $pedidosprodutos = new PedidoProduto();

        $pedidosprodutos->cliente_id = $request->cliente_id;
        $pedidosprodutos->contato_id = $request->contato_id;

        $pedidosprodutos->save();
        return redirect('/pedido')->with('sucess', 'Pedido criado');
    }

    public function fetchProdutos(Request $request)
    {
        $query = DB::select("SELECT * FROM `produtos` WHERE deleted_at  IS NULL");
        $produtos = collect($query)->toArray();
        
        return response()->json($produtos);
    }
}
/*
$query = DB::select("SELECT pedidos_produtos.id, pedidos_produtos.quantidade, pedidos_produtos.valor, pedidos_produtos.observacao, pedidos_produtos.pedido_id, pedidos_produtos.produto_id, produtos.estoque, pedidos.id, pedidos.total, produtos.id, produtos.nome,pedidos_produtos.desconto
FROM `pedidos_produtos`,`pedidos`,`produtos`
WHERE pedidos_produtos.pedido_id = pedidos.id
AND pedidos_produtos.produto_id = produtos.id
AND pedidos_produtos.deleted_at IS NULL
AND pedidos.deleted_at IS NULL
AND produtos.deleted_at IS NULL");
*/