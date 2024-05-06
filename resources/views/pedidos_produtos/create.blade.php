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
                        <select class="form-control" id="produto_id" name="produto">
                            <option value="" disabled selected>-- Produto --</option>
                            @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="subcolumn">
                        <label for="valor_id">Valor:</label>
                        <input type="text" placeholder="Ex: 5,0" class="form-control" id="valor_id" name="valor_id">
                        </p>
                    </div>
                    <div class="subcolumn">
                        <label for="observacao_id">Observacao:</label>
                        <input type="text" placeholder="Ex: Aparencia otima" class="form-control" name="observacao" id="observacao_id">
                    </div>
                </div>
                <div class="column">
                    <div class="subcolumn">
                        <label for="estoque_id">Estoque:</label>
                        <input type="text" placeholder="Ex: 1000" class="form-control" name="estoque" id="estoque_id">
                    </div>
                    <div class="subcolumn">
                        <label for="desconto_id">Desconto:</label>
                        <input type="text" placeholder="Ex: 4360,00" class="form-control" name="desconto" id="desconto_id" >
                    </div>
                    <div class="subcolumn" style="height:70px;width:20%;display:flex"></div>
                </div>
                <div class="buttons">
                    <button class="btn-submit" type="submit" action="{{ route('pedido.storeProduto')}}">Cadastrar</button>
                    <a href="{{ route('pedido.indexProduto')}}">Voltar</a>
                </div>
        </form>
    </div>

</section>
<script type="text/javascript">
        $(document).ready(function() {
            $('#produto_id').on('change', function() {
                var produtoId = this.value;
                $("valor").html('');
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('/pedido/fetchProdutos')}}",
                    type: "POST",
                    data: {
                        produto_id: produtoId,
                    },
                    dataType: 'JSON',
                    success: function (result) {
                        console.log(result);
                        $("#valor_id").html(result.valor);
                        console.log('fim');
                    }
                });
            });
        });
    </script>
@endsection