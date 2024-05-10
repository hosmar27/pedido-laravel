@extends('layouts.app')
@section('content')
<section>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="container">
        <form action="{{ route('pedidoProduto.store')}}" method="post">
            @csrf
            <h1>Inserir produtos</h1>
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
                        <label for="produto_id">Produto:</label>
                        <select class="form-control" id="produto_id" name="produto_id">
                            <option value="" disabled selected>-- Produto --</option>
                            @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="subcolumn">
                        <label for="valor">Valor:</label>
                        <input type="text" placeholder="Ex: 5,0" class="form-control" id="valor" name="valor">
                    </div>
                    <div class="subcolumn">
                        <label for="descricao">Observacao:</label>
                        <input type="text" placeholder="Ex: Aparencia otima" class="form-control" name="observacao" id="descricao">
                    </div>
                </div>
                <div class="column">
                    <div class="subcolumn">
                        <label for="estoque">Estoque:</label>
                        <input type="text" placeholder="Ex: 1000" class="form-control" name="quantidade" id="estoque">
                    </div>
                    <div class="subcolumn">
                        <label for="desconto">Desconto:</label>
                        <input type="text" placeholder="Ex: 4360,00" class="form-control" name="desconto" id="desconto" >
                    </div>
                    <div class="subcolumn">
                        <label for="pedido_id">Pedido:</label>
                        <input type="text" value="{{$pedidos->id}}" placeholder="Ex: 19" class="form-control" name="pedido_id" id="pedido_id">
                    </div>
                </div>
                <div class="buttons">
                    <button class="btn-submit" type="submit" action="{{ route('pedidoProduto.store')}}">Cadastrar</button>
                    <a href="{{ route('pedidoProduto.index')}}">Voltar</a>
                </div>
        </form>
    </div>

</section>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>  
<script type="text/javascript">

    $(document).ready(function() {       
        $('#produto_id').on('change', function() {
            var idProduto = this.value;
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/pedido/fetchProduto')}}",
                type: "POST",
                data: {
                    id: idProduto,
                },
                dataType: 'JSON',
                success: function (produto) {

                    var quantidade;

                    var desconto;

                    var valor = produto[0]['valor'];
                    valor = valor.replace('.', ',');
                    valor = 'R$ '+valor;
                    $('#valor').val(valor);

                    var descricao = produto[0]['descricao'];
                    $('#descricao').val(descricao);

                    var estoque = produto[0]['estoque'];
                    $('#estoque').val(estoque);

                    desconto = '0,00';
                    desconto = 'R$ '+desconto;
                    $('#desconto').val(desconto);

                    var estoque = quantidade;

                    console.log(produto);

                    console.log('valor:', produto[0].valor);
                    console.log('descricao:', produto[0].descricao);
                    console.log('estoque:', produto[0].estoque);
                
                    //valor.setAttribute('value', produto.valor);
                    //descricao.setAttribute('value', produto.descricao);
                    //estoque.setAttribute('value', produto.estoque);
                }
            });
        });
    });


</script>
@endsection