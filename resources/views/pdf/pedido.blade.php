@extends('layouts.app')
@section('content')

    <form action="{{ route('pdfGerar.pedido', $pedido->id) }}" method="get">
        <div class="container">
            <h1>NOME DA EMPRESA*</h1>
                <h2>Pedido: {{$pedido->id}}</h2>
                <main>
                    <div class="top">
                        Cliente: {{$pedido->cliente->nome}}
                        <br>
                        Contato: {{$pedido->contato->nome}}

                        <br>
                        <br>
                        <br>

                        <table class="table table-striped">
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Desconto</th>
                                <th>Valor</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                            </tr>
                            @foreach($pedidoproduto as $data)
                            <tr>
                                <td>{{$data->id_pp}}</td>
                                <td>{{$data->nome}}</td>
                                <td>{{$data->valor}}</td>
                                <td>{{$data->desconto}}</td>
                                <td>{{$data->valor_desconto}}</td>
                                <td>{{$data->quantidade}}</td>
                                <td>{{$data->total_pp}}</td>
                            </tr>
                            @endforeach
                            <td class="table-active">
                                <h5>
                                    Total: {{$totalValor}}
                                </h5>
                            </td>
                        </table>
                    </div>
                </main>
        </div>
    </form>

</body>
</html>