@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <form action="{{ route('produto.store')}}" method="post">
            @csrf
                <h1>Cadastrar produtos</h1>
                @if($errors->any)
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="row">
                    <div class="column">
                        <div class="subcolumn">
                            <label for="form-label">Nome:</label>
                            <input type="text" placeholder="Insira o nome" class="form-control" name="nome" id="nome">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">Estoque:</label>
                            <input type="text" placeholder="Insira o estoque" class="form-control" name="estoque" id="estoque">
                        </div>     
                    </div>
                    <div class="column">
                        <div class="subcolumn">
                            <label for="form-label">Valor:</label>
                            <input type="text" placeholder="Insira o valor" class="form-control" name="valor" id="valor">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">Descrição:</label>
                            <input type="text" placeholder="Insira o descrição" class="form-control" name="descricao" id="descricao">
                        </div>              
                    </div>
                </div>
                <div class="buttons">
                    <button class="btn-submit" type="submit" action="{{ route('produto.store')}}">Cadastrar</button>
                    <a href="{{ route('produto.index')}}">Voltar</a>
                </div>
            </form>
        </div>
        
    </section>
@endsection