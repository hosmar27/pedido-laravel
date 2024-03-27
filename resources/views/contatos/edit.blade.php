@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <form action="/contato/{{$contato->id}}/update" method="POST">
            @csrf
            @method('PUT')
                <h1>Editar contatos</h1>
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
                            <input type="text" value="{{ $contato->nome}}" placeholder="Insira o nome" class="form-control" name="nome" id="nome">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">CNPJ:</label>
                            <input type="text" value="{{ $contato->email}}" placeholder="Insira o email" class="form-control" name="email" id="email">
                        </div>     
                    </div>
                    <div class="column">
                        <div class="subcolumn">
                            <label for="form-label">Endereço:</label>
                            <input type="text" value="{{ $contato->telefone}}"placeholder="Insira o telefone" class="form-control" name="telefone" id="telefone">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">Telefone:</label>
                            <input type="text" value="{{ $contato->cpf}}" placeholder="Insira o CPF" class="form-control" name="cpf" id="cpf">
                        </div>              
                    </div>
                </div>
                <div class="buttons">
                    <button class="btn-submit" type="submit">Editar</button>
                    <a href="{{ route('contato.index')}}">Voltar</a>
                </div>
            </form>
        </div>
        
    </section>
@endsection