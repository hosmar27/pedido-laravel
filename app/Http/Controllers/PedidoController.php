<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Pedido;
use Illuminate\Support\Facades\Response;
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
        $query = DB::select("SELECT * FROM `clientes` WHERE clientes.deleted_at IS null");
        $clientes = collect($query)->toArray();
        $query = DB::select("SELECT * FROM `contatos` WHERE contatos.deleted_at IS null");
        $contatos = collect($query)->toArray();

        $keyword = $request->get('search');
        $perPage = 4;

        if(!empty($keyword)) {
            $pedidos = Pedido::where('id','LIKE',"%$keyword%")
            ->orWhere('cliente_id','LIKE',"$keyword")
            ->orWhere('pedido_id','LIKE',"$keyword")
            ->latest()->paginate($perPage);
        }else{
            $pedidos = Pedido::latest()->paginate($perPage);
        }

        return view('pedidos.index', ['pedidos'=>$pedidos], ['clientes'=>$clientes], ['contatos'=>$contatos])->with('i',(request()->input('page',1) -1) *4);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = DB::select("SELECT * FROM `clientes` WHERE deleted_at IS null");
        $clientes = collect($query)->toArray();
        $query = DB::select("SELECT * FROM `contatos` INNER JOIN `clientes` ON clientes.id = contatos.clientes_id AND contatos.deleted_at IS null;");
        $contatos = collect($query)->toArray();
        return view('pedidos.create', ['clientes'=>$clientes], ['contatos'=>$contatos]);
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
        return redirect('/pedido')->with('sucess','Pedido criado');
    }

    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $query = DB::select("SELECT * FROM `pedidos` WHERE deleted_at IS null");
        $pedido = collect($query)->toArray();
        return view('pedidos.edit',['pedido' => $pedido]);
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
     * Remove the specified resource from storage.
     */
    public function destroy(pedido $pedido)
    {
        //
    }
}
