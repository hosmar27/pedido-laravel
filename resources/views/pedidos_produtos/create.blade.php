@extends('layouts.app')
@section('content')
<section>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="container">
        <form action="{{ route('pedido.storeProduto')}}" method="post">
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
                        <input type="text" placeholder="Ex: Aparencia otima" class="form-control" name="descricao" id="descricao">
                    </div>
                </div>
                <div class="column">
                    <div class="subcolumn">
                        <label for="estoque">Estoque:</label>
                        <input type="text" placeholder="Ex: 1000" class="form-control" name="estoque" id="estoque">
                    </div>
                    <div class="subcolumn">
                        <label for="desconto">Desconto:</label>
                        <input type="text" placeholder="Ex: 4360,00" class="form-control" name="desconto" id="desconto" >
                    </div>
                    <div class="subcolumn" style="height:70px;width:20%;produto:flex"></div>
                </div>
                <div class="buttons">
                    <button class="btn-submit" type="submit" action="{{ route('pedido.storeProduto')}}">Cadastrar</button>
                    <a href="{{ route('pedido.index')}}">Voltar</a>
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

                        var valor = produto[0]['valor'];
                        valor = valor.toFixed(2);
                        valor = valor.replace('.', ',');
                        $('#valor').val(valor);

                        var descricao = produto[0]['descricao'];
                        $('#descricao').val(descricao);

                        var estoque = produto[0]['estoque'];
                        $('#estoque').val(estoque);

                        console.log(produto);

                        console.log('valor:', produto.valor);
                        console.log('descricao:', produto.descricao);
                        console.log('estoque', produto.estoque);
                    
                        //valor.setAttribute('value', produto.valor);
                        //descricao.setAttribute('value', produto.descricao);
                        //estoque.setAttribute('value', produto.estoque);
                    }
                });
            });
        });
    </script>
@endsection