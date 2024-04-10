@extends('layouts.app')
@section('content')
@vite(['resoucer/css/app.css','resources/js/app.js'])

<section>
    <div class="container">
        <div class="column">
            <form method="GET" action="{{ route('pedido.index') }}" accept-charset="UTF-8" role="search">
            @csrf
                <div class="table-search" style="width: 350px;display:flex;flex-direction:row">
                    <div>
                        <button class="btn-submit" style="width: 100px;height:35px">
                            Procurar
                        </button>
                    </div>
                    <div class="relative">
                        <input type="text" name="search" class="search-input" placeholder="Digite aqui..." value="{{ request('search') }}">
                    </div>
                </div>
            </form>
            <table class="table table-hover">
                <tr>
                    <th>Cliente</th>
                    <th>Contato</th>
                    <th>Planilha</th>
                    <th>Excluir/Editar</th>
                </tr>
                <tr>
                    @foreach ($clientes as $cliente)
                        <td>{{$cliente->nome}}</td>
                    @endforeach
                    @foreach ($contatos as $contato)
                    <td>{{$contato->nome}}</td>
                    @endforeach
                    <td></td>
                    <td class="action"></td>
                </tr>
            </table>
        </div>
    </div>
</section>