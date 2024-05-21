<?php

namespace App\Http\Controllers;

use App\Models\{Pedido, Produto, Contato, PedidoProduto};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\PDF;

class PedidoController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = DB::select("SELECT pedidos.id,pedidos_produtos.quantidade,pedidos_produtos.valor,pedidos_produtos.desconto,pedidos_produtos.total, clientes.id, contatos.id, clientes.nome, contatos.nome
        FROM `pedidos`
        JOIN `clientes` ON pedidos.cliente_id = clientes.id 
        JOIN `contatos` ON pedidos.contato_id = contatos.id 
        JOIN `pedidos_produtos` ON pedidos.id = pedidos_produtos.pedido_id
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
    public function destroy($id)
    {
        Pedido::find($id)->delete();
        return back()->with('delete','Pedido & Produto excluido');
    }

    public function indexPedidoProduto(Request $request, $id)
    {
        $pedidos_produtos = PedidoProduto::where('pedidos_produtos.pedido_id', $id)
                            ->join('pedidos','pedidos.id', '=', 'pedidos_produtos.pedido_id')
                            ->join('produtos','produtos.id', '=', 'pedidos_produtos.produto_id')
                            ->select('pedidos.id AS pedidoId','produtos.id AS produtoId','produtos.nome','produtos.estoque',
                            'pedidos_produtos.id AS id','pedidos_produtos.quantidade AS quantidade',
                            'pedidos_produtos.valor AS valor','pedidos_produtos.desconto','pedidos_produtos.total AS total')
                            ->whereNull('pedidos.deleted_at')
                            ->whereNull('pedidos_produtos.deleted_at')
                            ->paginate(4);
        

        return view('pedidos_produtos.index',compact('pedidos_produtos','id'))->with('i',(request()->input('page',1) -1) *4);
    }
    
    public function createPedidoProduto($id)
    {
        $query = DB::select("SELECT produtos.id, produtos.nome, produtos.valor, produtos.estoque AS quantidade, produtos.descricao
                            FROM `produtos`
                            WHERE deleted_at IS NULL");

        DB::table("pedidos_produtos")->select(DB::raw("(valor * quantidade) as total"))->get();

        $produtos = collect($query)->toArray();

        $pedidos = Pedido::findOrFail($id);


        return view('pedidos_produtos.create', ['produtos'=>$produtos], ['pedidos'=>$pedidos]);
    }

    public function storePedidoProduto(Request $request)
    {
        $pedidosprodutos = new PedidoProduto();

        //Chama o valor direto do forms
        $valor = $request->valor;
        //Transforma os valores referentes a dinheiro no formato correto
        $valor = str_replace('.','',$valor);
        $valor = str_replace(',','.',$valor);

        //Transforma os valores referentes a dinheiro no formato correto
        $desconto = $request->desconto;
        $desconto = str_replace('.','',$desconto);
        $desconto = str_replace(',','.',$desconto);

        $quantidade = $request->quantidade;

        //Manda os valores para variável que irá para o banco de dados
        $pedidosprodutos->valor = $valor;
        $pedidosprodutos->desconto = $desconto;
        $pedidosprodutos->quantidade = $quantidade;
        $pedidosprodutos->produto_id = $request->produto_id;
        $pedidosprodutos->pedido_id = $request->pedido_id;
        $pedidosprodutos->observacao = $request->observacao;

        
        
        $total = ($valor-$desconto)*$quantidade;

        $pedidosprodutos->total = $total;

        $pedidosprodutos->save();
        return redirect('/pedido')->with('success', 'Pedido criado');
    }

    public function editPedidoProduto(PedidoProduto $pedido_produto, $id)
    {
        $pedido_produto = PedidoProduto::findOrFail($id);
        $query = DB::select("SELECT pedidos_produtos.pedido_id AS pp_id, pedidos_produtos.total AS pp_total, pedidos_produtos.id, pedidos_produtos.quantidade, pedidos_produtos.desconto, pedidos_produtos.produto_id, pedidos_produtos.observacao, pedidos_produtos.valor,
        pedidos.id AS p_id, pedidos.total AS p_total, pedidos.cliente_id, pedidos.contato_id 
        FROM `pedidos_produtos` JOIN `pedidos` ON  pedidos_produtos.pedido_id = pedidos.id 
        WHERE pedidos_produtos.deleted_at IS NULL 
        AND pedidos.deleted_at IS NULL");
        $pedido_produto = collect($query)->toArray();

        $pedido_produto = PedidoProduto::findOrFail($id);
        $query = DB::select("SELECT * FROM `produtos` WHERE deleted_at IS null");
        $produtos = collect($query)->toArray();

        return view('pedidos_produtos.edit',['pedido_produto' => $pedido_produto , 'produtos' => $produtos]);
    }

    public function updatePedidoProduto(Request $request, $id)
    {

        $pedido_produto = PedidoProduto::find($request->id);

        //Chama o valor direto do forms
        $valor = $request->input('valor');
        //Transforma os valores referentes a dinheiro no formato correto
        $valor = str_replace('.','',$valor);
        $valor = str_replace(',','.',$valor);

        //Chama o valor direto do forms
        $desconto = $request->input('desconto');
        //Transforma os valores referentes a dinheiro no formato correto
        $desconto = str_replace('.','',$desconto);
        $desconto = str_replace(',','.',$desconto);
        
        $quantidade = $request->input('quantidade');
        $quantidade = str_replace('.','', $quantidade);
        $quantidade = str_replace(',','', $quantidade);

        $pedido_produto->valor = $valor;
        $pedido_produto->desconto = $desconto;
        $pedido_produto->produto_id = $request->input('produto_id');
        $pedido_produto->observacao = $request->input('observacao');
        $pedido_produto->quantidade = $request->input('quantidade');

        $total = ($valor-$desconto)*$quantidade;

        $pedido_produto->total = $total;

        $pedido_produto->save();
        return redirect()->route('pedidoProduto.index', ['id' => $id])->with('update','Pedido atualizado');

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
}