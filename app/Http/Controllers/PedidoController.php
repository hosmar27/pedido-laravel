<?php

namespace App\Http\Controllers;

use App\Models\{Pedido, Produto, Contato, PedidoProduto};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\Paginator;

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
        //echo $request;
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

    public function indexPedidoProduto(Request $request, $pedidoId)
    {
        $id = $pedidoId;

        $pedidos_produtos = PedidoProduto::where('pedidos_produtos.pedido_id', $pedidoId)
                            ->join('pedidos','pedidos.id', '=', 'pedidos_produtos.pedido_id')
                            ->join('produtos','produtos.id', '=', 'pedidos_produtos.produto_id')
                            ->select('pedidos.id AS pedidoId','produtos.id AS produtoId','produtos.nome','produtos.estoque',
                            'pedidos_produtos.id AS id','pedidos_produtos.quantidade',
                            'pedidos_produtos.valor','pedidos_produtos.desconto')
                            ->where('pedidos.deleted_at', '=', null)
                            ->where('pedidos_produtos.deleted_at', '=', null)
                            ->paginate(4);


        return view('pedidos_produtos.index',compact('pedidos_produtos','pedidoId'))->with('i',(request()->input('page',1) -1) *4);
    }
    
    public function createPedidoProduto($id)
    {
        $query = DB::select("SELECT produtos.id, produtos.nome, produtos.valor, produtos.estoque AS quantidade, produtos.descricao
                            FROM `produtos`
                            WHERE deleted_at IS NULL");

        $produtos = collect($query)->toArray();

        $pedidos = Pedido::findOrFail($id);


        return view('pedidos_produtos.create', ['produtos'=>$produtos], ['pedidos'=>$pedidos]);
    }

    public function storePedidoProduto(Request $request)
    {
        $pedidosprodutos = new PedidoProduto();

        $pedidosprodutos->quantidade = $request->quantidade;

        //Transforma os valores referentes a dinheiro no formato correto
        $pedidosprodutos->valor = $request->valor;
        $valor = $pedidosprodutos->valor;
        $pedidosprodutos->valor = str_replace('.','',$valor);
        $pedidosprodutos->valor = str_replace(',','.',$valor);

        //Transforma os valores referentes a dinheiro no formato correto
        $pedidosprodutos->desconto = $request->desconto;
        $desconto = $pedidosprodutos->desconto;
        $pedidosprodutos->desconto = str_replace('.','',$desconto);
        $pedidosprodutos->desconto = str_replace(',','.',$desconto);

        $pedidosprodutos->produto_id = $request->produto_id;
        $pedidosprodutos->pedido_id = $request->pedido_id;
        $pedidosprodutos->observacao = $request->observacao;

        $pedidosprodutos->save();
        return redirect('/pedido')->with('succ ess', 'Pedido criado');
    }

    public function editPedidoProduto(PedidoProduto $pedido_produto)
    {
        
    }

    public function updatePedidoProduto()
    {
        
    }

    public function destroyPedidoProduto($id)
    {
        PedidoProduto::find($id)->delete();
        return back()->with('delete','Pedido & Produto excluido');
    }

    public function fetchProduto(Request $request)
    {
        //dd($request);
        $query = Produto::where("id", $request->id)
                                ->get(["nome","valor","estoque","descricao","id"])
                                ->whereNull(["deleted_at"]);
                                

        $produto = collect($query)->toArray();

        return response()->json($produto);
    }

    public function fetchPedido(Request $request)
    {
        $query = Pedido::where("id", $request->id)
                                ->get(["id","cliente_id","contato_id","total","frete"])
                                ->whereNull(["deleted_at"]);


        $pedido = collect($query)->toArray();

        return response()->json($pedido);
    }
}

/*public function fetchProdutos()
    {
        $query = DB::select("SELECT produtos.id, produtos.nome, produtos.valor, produtos.estoque, produtos.descricao, pedidos_produtos.produto_id, produtos.deleted_at, pedidos_produtos.deleted_at 
        FROM `pedidos_produtos` 
        RIGHT JOIN `produtos` 
        ON produtos.id = pedidos_produtos.produto_id
        AND produtos.deleted_at IS NULL
        AND pedidos_produtos.deleted_at IS NULL;");

        $produtos = collect($query)->toArray();
        
        return response()->json($produtos);
    }*/

    /*public function moneyFormat($value)
    {
        return 'R$' . number_format($value, 2)
    }*/

    /*$query = DB::select("SELECT pedidos.id AS pedidoId, pedidos_produtos.pedido_id
    FROM `pedidos_produtos`
    JOIN `pedidos` ON pedidos.id = pedidos_produtos.pedido_id
    WHERE pedidos.deleted_at IS NULL
    AND pedidos_produtos.deleted_at");
$pedidos = collect($query)->toArray();*/


/*$query = DB::select("SELECT pedidos_produtos.id,pedidos_produtos.quantidade,pedidos_produtos.valor,pedidos_produtos.desconto,pedidos_produtos.observacao,pedidos_produtos.pedido_id,pedidos_produtos.produto_id,pedidos_produtos.deleted_at
FROM `pedidos_produtos`
WHERE pedidos_produtos.pedido_id = $pedidos
AND pedidos_produtos.deleted_at IS NULL;");
$pedidos_produtos = collect($query)->toArray();


 ->select('pedidos_produtos.id','pedidos_produtos.quantidade','pedidos_produtos.valor','pedidos_produtos.desconto','pedidos_produtos.observacao','pedidos_produtos.pedido_id','pedidos_produtos.produto_id','pedidos_produtos.deleted_at')
                            ->whereNull('pedidos_produtos.deleted_at')

        $keyword = $request->get('search');
        $perPage = 5;

            $pedidos_produtos = PedidoProduto::where('pedidos_produtos.pedido_id', $id)
            ->join('pedidos','pedidos.id', '=', 'pedidos_produtos.pedido_id')
            ->where('pedidos.deleted_at', '=', null)
            ->where('pedidos_produtos.deleted_at', '=', null)
            ->get()
            ->paginate($perPage);*/