<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::select("SELECT * FROM `produtos` WHERE produtos.deleted_at IS null");
        $produtos = collect($query)->toArray();

        $keyword = $request->get('search');
        $perPage = 4;

        if(!empty($keyword)){
            $produtos = Produto::where('nome', 'LIKE',"%$keyword%")
                ->orWhere('estoque','LIKE',"$keyword")
                ->orWhere('valor','LIKE',"$keyword")
                ->orWhere('descricao','LIKE',"$keyword")
                ->latest()->paginate($perPage);
        }else{
            $produtos = Produto::latest()->paginate($perPage);
        }
        return view('produtos.index', ['produtos'=>$produtos])->with('i',(request()->input('page',1) -1) *4);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'estoque' => 'required',
            'valor' => 'required',
        ]);

        $produto = new Produto();

        $produto->nome = $request->nome;
        $produto->estoque = $request->estoque;
        $produto->descricao = $request->descricao;


        $produto->valor = $request->valor;
        $valor = $produto->valor;
        $produto->valor = str_replace(',','.',$valor);
        
        
        $produto->save();
        return redirect('/produto')->with('sucess','Produto criado');
    }

    /**
     * Display the specified resource.
     */
    public function show(produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.edit',['produto' => $produto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, produto $produto)
    {
        $produto = Produto::find($request->id);
        $produto->nome = $request->input('nome');
        $produto->estoque = $request->input('estoque');
        $produto->valor = $request->input('valor');
        $produto->descricao = $request->input('descricao');

        $produto->save();
        return redirect()->route('produto.index')->with('update','Produto atualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $produto = Produto::find($produto->id)->delete();
        return redirect()->route('produto.index')->with('delete','Produto excluido');
    }
}
