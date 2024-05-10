@extends('layouts.app')
@section('content')
@vite(['resoucer/css/app.css','resources/js/app.js'])

<section>
    <div class="container">
        <div class="column">
            <h1>Pedidos & Produtos</h1>
            <form method="GET" action="{{ route('pedidoProduto.index') }}" accept-charset="UTF-8" role="search">
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
                    <th>Id</th>
                    <th>Valor</th>
                    <th>Desconto</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>N. Pedido</th>
                    <th>Excluir/Editar</th>
                </tr>
                @foreach ($pedidos_produtos as $pedido_produto)
                <tr>
                    <td>{{$pedido_produto->id}}</td>
                    <td>{{ number_format($pedido_produto->valor, 2)}}</td>
                    <td>{{$pedido_produto->desconto}}</td>
                    <td>{{$pedido_produto->produto_id}}</td>
                    <td>{{$pedido_produto->quantidade}}</td>
                    <td>{{$pedido_produto->pedido_id}}</td>
                    <td class="action">
                        <a href="{{ route('pedidoProduto.edit', $pedido_produto->id) }}" class="btn-submit" style="width: 100px;">Editar</a>
                        <form method="post" action="{{ route('pedidoProduto.destroy', $pedido_produto->id) }}">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Excluir" class="btn-submit" style="width: 150px;">
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="buttons">
                <a href="{{ route('pedido.index') }}" class="btn-submit" style="width: 100px;">Pedidos</a>

                <div class="table-paginate">
                    {{$pedidos_produtos->links('layouts.pagination')}}
                </div>
            </div>
        </div>
    </div>
</section>
@if ($message = Session::get('delete'))
<script type="text/javascript">
    const Toast3 = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast3.fire({
        icon: "success",
        title: "Contato excluido"
    });
</script>
@endif
@if ($message = Session::get('sucess'))
<script type="text/javascript">
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: "success",
        title: "Contato adicionado"
    });
</script>
@endif
@if ($message = Session::get('update'))
<script type="text/javascript">
    const Toast2 = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast2.fire({
        icon: "success",
        title: "Contato atualizado"
    });
</script>
@endif
@endsection