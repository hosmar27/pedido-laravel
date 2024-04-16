@extends('layouts.app')
@section('content')
@vite(['resoucer/css/app.css','resources/js/app.js'])

<section>
    <div class="container">
        <div class="column">
            <h1>Lista de pedidos</h1>
            <form method="GET" action="{{ route('pedido.index') }}" accept-charset="UTF-8" role="search">
                @csrf
                <div class="table-search" style="width: 350px;display:flex;flex-direction:row">
                    <div>
                        <button class="btn-submit" style="width: 100px;height:35px">
                            Procurar
                        </button>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder=" Digite aqui..." value="{{ request('search') }}" style="border-radius: 20px;border-color:#8200E6;width: 175px;height:35px">
                    </div>
                </div>
            </form>
            <table class="table table-hover" style="display:flex;flex-direction:column">
                <tr>
                    <th>Cliente</th>
                    <th>Contato</th>
                    <th>Excluir/Editar</th>
                </tr>
                <tr>
                    @foreach ($pedidos as $pedido)
                        <td>{{$pedidos->clientes.nome}}</td>
                        <td>{{$pedidos->contatos.nome}}</td>
                        <td class="action">
                        <a href="{{ route('pedido.edit', $pedido->id) }}" class="btn-submit" style="width: 100px;">Editar</a>
                        <form action="{{ route('pedido.destroy', $pedido->id) }}" method="post">Delete</form>
                        </td>
                    @endforeach
                </tr>
            </table>
            <div class="buttons">
                <a href="{{ route('pedido.create') }}" class="btn-submit" style="width: 100px;">Cadastrar</a>
                <div class="table-paginate">
                    {{$pedidos->links('layouts.pagination')}}
                </div>
            </div>
        </div>
    </div>
</section>