<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::select("SELECT * FROM `contatos` WHERE contatos.deleted_at IS null");
        $contatos = collect($query)->toArray();

        $keyword = $request->get('search');
        $perPage = 5;

        if(!empty($keyword)){
            $contatos= contato::where('nome','LIKE',"%$keyword%")
                    ->orWhere('email','LIKE', "$keyword")
                    ->orWhere('telefone','LIKE', "$keyword")
                    ->orWhere('cpf','LIKE', "$keyword")
                    ->latest()->paginate($perPage);
        }else{
            $contatos = contato::latest()->paginate($perPage);
        }
        return view('contatos.index', ['contatos'=>$contatos])->with('i',(request()->input('page',1) -1) *5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contatos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required'
        ]);

        $contato = new Contato();

        $contato->nome = $request->nome;
        $contato->email = $request->email;
        $contato->telefone = $request->telefone;
        $contato->cpf = $request->cpf;

        $contato->save();
        return redirect()->route('contato.index')->with('sucess','Contato criado');
    }

    /**
     * Display the specified resource.
     */
    public function show(contato $contato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contato = Contato::findOrFail($id);
        return view('contatos.edit',['contato' => $contato]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, contato $contato)
    {
        $contato = Contato::find($request->id);
        $contato->nome = $request->input('nome');
        $contato->email = $request->input('email');
        $contato->telefone = $request->input('telefone');
        $contato->cpf = $request->input('cpf');

        $contato->save();
        return redirect()->route('contato.index')->with('update','Contato atualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(contato $contato)
    {
        Contato::find($contato->id)->delete();
        return redirect()->route('contato.index')->with('delete','Contato excluido'); 
    }
}
