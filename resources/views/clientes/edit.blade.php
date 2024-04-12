@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <form action="/cliente/{{$cliente->id}}/update" method="POST">
            @csrf
            @method('PUT')
                <h1>Editar Clientes</h1>
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
                            <input type="text" value="{{ $cliente->nome }}" placeholder="Insira o nome" class="form-control" name="nome" id="nome">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">CNPJ:</label>
                            <input type="text" value="{{ $cliente->cnpj }}" placeholder="Insira o CNPJ" class="form-control" name="cnpj" id="cnpj">
                        </div>     
                    </div>
                    <div class="column">
                        <div class="subcolumn">
                            <label for="form-label">Endereço:</label>
                            <input type="text" value="{{ $cliente->endereco }}" placeholder="Insira o endereço" class="form-control" name="endereco" id="endereco">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">Telefone:</label>
                            <input type="text" value="{{ $cliente->telefone }}" placeholder="Insira o telefone" class="form-control" name="telefone" id="telefone">
                        </div>              
                    </div>
                </div>
                <div class="buttons">
                    <button class="btn-submit" type="submit" action="{{ route('cliente.store')}}">Cadastrar</button>
                    <a href="{{ route('cliente.index')}}">Voltar</a>
                </div>
            </form>
        </div>
        
    </section>
@endsection