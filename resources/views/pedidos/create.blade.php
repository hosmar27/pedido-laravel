@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <form action="{{ route('pedido.store')}}" method="post">
            @csrf
                <h1>Cadastrar pedidos</h1>
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
                            <label for="form-label">Cliente:</label>
                            <select class="form-control" name="cliente_id">
                                <option value="" disabled selected>Selecione</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">CNPJ:</label>
                            <select class="form-control" name="cliente_id">
                                <option value="" disabled selected>Selecione</option>
                                @foreach ($produtos as $produtos)
                                    <option value="{{ $produto->id }}">{{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>     
                    </div>
                    <div class="column">
                        <div class="subcolumn">
                            <label for="form-label">Endereço:</label>
                            <input type="text" placeholder="Insira o endereço" class="form-control" name="endereco" id="endereco">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">Telefone:</label>
                            <input type="text" placeholder="Insira o telefone" class="form-control" name="telefone" id="telefone">
                        </div>              
                    </div>
                </div>
                <div class="buttons">
                    <button class="btn-submit" type="submit" action="{{ route('pedido.store')}}">Cadastrar</button>
                    <a href="{{ route('pedido.index')}}">Voltar</a>
                </div>
            </form>
        </div>
        
    </section>
@endsection