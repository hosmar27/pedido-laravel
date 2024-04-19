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
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Contato</th>
                    <th>Excluir/Editar</th>
                </tr>
                @dd($pedidos)
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{$pedido->id}}</td>
                        <td>{{$pedido->cliente->nome}}</td>
                        <td>{{$pedido->contato->nome}}</td>
                        <td class="action">
                        <a href="{{ route('pedido.edit', $pedido->id) }}" class="btn-submit" style="width: 100px;">Editar</a>
                        <form action="{{route('pedido.destroy', $pedido->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Excluir" class="btn-submit" style="width: 100px;">
                        </form>
                    </td>
                    </tr>
                @endforeach
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