@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <form action="/pedido/{{$pedido->id}}/update" method="POST">
            @csrf
            @method('PUT')
                <h1>Editar pedidos</h1>
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
                                <input type="text" value="{{ $pedido->nome }}" placeholder="Insira o nome" class="form-control" name="nome" id="nome">
                            </div>
                            <div class="subcolumn">    
                                <label for="form-label">Email:</label>
                                <input type="text" value="{{ $pedido->email }}" placeholder="Insira o email" class="form-control" name="email" id="email">
                            </div>   
                            <div class="subcolumn">  
                            <label for="exampleFormControlSelect1">Cliente:</label>
                                <select class="form-control" name="clientes_id">
                                    <option value="" disabled selected>Selecione</option>
                                    @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="column">
                            <div class="subcolumn">
                                <label for="form-label">Telefone:</label>
                                <input type="text" value="{{ $pedido->telefone }}" placeholder="Insira o telefone" class="form-control" name="telefone" id="telefone">
                            </div>
                            <div class="subcolumn">    
                                <label for="form-label">CPF:</label>
                                <input type="text" value="{{ $pedido->cpf }}" placeholder="Insira o CPF" class="form-control" name="cpf" id="cpf">
                            </div>  
                            <div class="subcolumn" style="background-color:#f1f1f1; width:100%; height:8vh"></div>
                        </div> 
                    <div class="buttons">
                        <button class="btn-submit" type="submit" action="{{ route('pedido.store')}}">Editar</button>
                        <a href="{{ route('pedido.index')}}">Voltar</a>
                    </div>
                </div>
            </form>
        </div>
        
    </section>
@endsection