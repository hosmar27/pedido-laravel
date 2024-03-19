@extends('layouts.app')
@section('content')

        <section>
            <div class="container">
                <h1 style="color: #602D86;">Cadastrar clientes</h1>
                <div class="row">
                    <div class="column">
                    <label for="form-label">Nome:</label><br>
                    <input type="text" placeholder="Insira o nome" class="input-sm" name="nome" id="nome">
                    <br>
                    <br>
                    <label for="form-label">CNPJ:</label><br>
                    <input type="text" placeholder="Insira o CNPJ" class="input-sm" name="cnpj" id="nome">
                    </div>
                    <div class="column">
                    <label for="form-label">Endereço:</label><br>
                    <input type="text" placeholder="Insira o endereço" class="input-sm" name="endereco" id="nome">
                    <br>
                    <br>
                    <label for="form-label">Telefone:</label><br>
                    <input type="text" placeholder="Insira o telefone" class="input-sm" name="telefone" id="nome">
                    </div>
                </div>
                <br>
                <button class="btn-submit" type="submit">Cadastrar</button>
            </div>
        </section>

@endsection