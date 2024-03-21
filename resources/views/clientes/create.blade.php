@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <form action="" method="post">
            @csrf
                <h1 style="color: #602D86;">Cadastrar Clientes</h1>
                <div class="row">
                    <div class="column">
                        <div class="subcolumn">
                            <label for="form-label">Nome:</label>
                            <input type="text" placeholder="Insira o nome" class="input-sm" name="nome" id="nome">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">CNPJ:</label>
                            <input type="text" placeholder="Insira o CNPJ" class="input-sm" name="cnpj" id="cnpj">
                        </div>     
                    </div>
                    <div class="column">
                        <div class="subcolumn">
                            <label for="form-label">Endereço:</label>
                            <input type="text" placeholder="Insira o endereço" class="input-sm" name="endereco" id="endereco">
                        </div>
                        <div class="subcolumn">    
                            <label for="form-label">Telefone:</label>
                            <input type="text" placeholder="Insira o telefone" class="input-sm" name="telefone" id="telefone">
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