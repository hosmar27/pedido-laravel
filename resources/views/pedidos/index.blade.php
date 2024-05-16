@extends('layouts.app')
@section('content')

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
                    <th>Produto</th>
                    <th>Criar</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
                @foreach ($pedidos as $pedido)
                <tr>
                    <td>{{$pedido->id}}</td>
                    <td>{{$pedido->cliente->nome}}</td>
                    <td>{{$pedido->contato->nome}}</td>
                    <td class="icon">
                        <form method="get" action="{{ route('pedidoProduto.index', $pedido->id) }}">
                            <button type="submit" class="btn-submit" style="width: 50px;height: 30px;"><i class="bi bi-list" type="submit"></i></button>
                        </form>
                    </td>
                    <td style="display: flex;gap:10px"> 
                        <a href="{{ route('pedidoProduto.create', $pedido->id) }}" class="btn-submit" style="width: 50px;height: 30px;"><i class="bi bi-plus-circle"></i></a>
                    </td>
                    <td>
                        <a href="{{ route('pedido.edit', $pedido->id) }}" class="btn-submit" style="width: 50px;height: 30px;"><i class="bi bi-pencil-square"></i></a>
                    </td>
                    <td>    
                        <form method="post" action="{{ route('pedido.destroy', $pedido->id) }}">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn-submit" style="width: 50px;height: 30px;"><i class="bi bi-trash3"></i></button>
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