@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <div class="column">
                <h1>Lista de clientes</h1>
                <table class="table table-hover">
                    <tr>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>Telefone</th>
                        <th>CNPJ</th>
                    </tr>
                    <tr>
                        <td>Lorem ipsum dolor</td>
                        <td>Lorem ipsum dolor</td>
                        <td>Lorem ipsum dolor</td>
                        <td>Lorem ipsum dolor</td>
                    </tr>
                </table>
                <a href="{{ route('cliente.create')}}" class="btn btn-submit">Cadastrar Cliente</button></a>
            </div>
        </div>
    </section>
@endsection